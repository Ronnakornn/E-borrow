<?php

namespace App\Filament\Admin\Resources;

use App\Enums\BorrowStatus;
use App\Filament\Admin\Resources\BorrowResource\Pages;
use App\Filament\Admin\Resources\BorrowResource\RelationManagers;
use App\Models\Borrow;
use App\Models\Product;
use App\Models\ProductItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Carbon\Carbon;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Support\Enums\Alignment;

class BorrowResource extends Resource
{
    protected static ?string $model = Borrow::class;

    protected static ?string $navigationIcon = 'heroicon-s-newspaper';

    protected static ?string $navigationLabel = 'รายการการยืม';

    protected static ?string $navigationGroup = 'รายการการยืม';

    protected static ?string $modelLabel = 'รายการการยืม';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('กรอกข้อมูลเพื่อทำการยืม')
            ->schema([
                Forms\Components\TextInput::make('borrow_number')
                    ->label('รหัสการยืม')
                    ->default(function ($state, Forms\Set $set) {
                        $currentDate = Carbon::now()->format('ymd');

                        // Find the last booking number for the current date
                        $lastBooking = Borrow::where('borrow_number', 'like', "BR-{$currentDate}-%")
                            ->latest()
                            ->first();

                        $serialNumber = 1; // Default for the first booking of the day

                        if ($lastBooking) {
                            $lastSerial = substr($lastBooking->borrow_number, -4);
                            $serialNumber = intval($lastSerial) + 1;
                        }

                        // Pad the serial number with leading zeros to ensure 4 digits
                        $paddedSerial = str_pad($serialNumber, 4, '0', STR_PAD_LEFT);
                        $bookingNumber = "BR-{$currentDate}-{$paddedSerial}";

                        return $bookingNumber;
                    })
                    ->columnSpanFull()
                    ->disabled()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('สมาชิก')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->optionsLimit(20)
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('เบอร์โทรศัพท์')
                    ->tel()
                    ->regex('/^0\d{8,9}$/')
                    ->validationAttribute('เบอร์โทรศัพท์')
                    ->required(),
                Forms\Components\DatePicker::make('borrow_date')
                    ->label('วันที่ยืม')
                    ->seconds(false)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $carbon = Carbon::parse($state);
                        $carbon->setTime(16, 0);
                        return $set('borrow_date_return', $carbon->toDateTimeString());
                    })
                    ->required(),
                Forms\Components\DateTimePicker::make('borrow_date_return')
                    ->label('วันที่คืน')
                    ->disabled()
                    ->live(onBlur: true)
                    ->seconds(false),
                Forms\Components\Textarea::make('note')
                    ->label('หมายเหตุ')
                    ->columnSpan(2),
            ])->columns(2),
            Forms\Components\Section::make('ข้อมูลอุปกรณ์')
            ->id('product-information')
            ->schema([
                Forms\Components\Repeater::make('borrowItems')
                    ->label('อุปกรณ์')
                    ->relationship('borrowItems')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('อุปกรณ์')
                            ->lazy()
                            ->relationship('product', 'name')
                            ->options(function () {
                                return Product::where('status', 'enabled')
                                    ->limit(20)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->optionsLimit(20)
                            ->searchable()
                            ->required()
                            ->getSearchResultsUsing(function (string $search) {
                                return Product::where('name', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%")
                                    ->where('status', 'enabled')
                                    ->limit(50)
                                    ->get()
                                    ->pluck('name', 'id');
                            }),
                        Forms\Components\Select::make('product_item_id')
                            ->label('เลขครุภัณฑ์')
                            ->lazy()
                            ->relationship(
                                'productItem',
                                'sku',
                                modifyQueryUsing: fn (Builder $query, Forms\Get $get, $record) => $query->where('product_id', $get('product_id'))->where('status_quantity', 'enabled')->Where('status_borrow', 'ready')->orWhere('id', $record?->product_item_id)
                            )
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->required(),
                    ])->columns(2)
                    // ->disabled( fn ($context) => $context === 'edit' )
            ])->columns(['lg' => 'full']),
            Forms\Components\Section::make('สถานะการยืม')
                ->schema([
                    Forms\Components\ToggleButtons::make('status')
                        ->label('สถานะ')
                        ->inline()
                        ->options(BorrowStatus::class)
                        ->hidden(fn ($context ) => $context === 'create')
                        ->required(),
                ])->hidden(fn ($context ) => $context === 'create')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('borrow_number')
                    ->label('รหัสการยืม')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('ผู้ยืม')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.branch')
                    ->label('สาขา')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('เบอร์โทรศัพท์')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrow_date')
                    ->label('วันที่ยืม')
                    ->searchable()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrow_date_return')
                    ->label('กำหนดคืน')
                    ->dateTime('d/m/Y H:i')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('สถานะ')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('วันที่ทำรายการ')
                    ->searchable()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')
                        ->label('วันที่ทำรายการจากวันที่'),
                    Forms\Components\DatePicker::make('created_until')
                        ->label('วันที่ทำรายการถึงวันที่'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'] ?? null,
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'] ?? null,
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $indicators = [];
                    if ($data['created_from'] ?? null) {
                        $indicators['created_from'] = 'วันที่ทำการจองจากวันที่ ' . Carbon::parse($data['created_from'])->format('d/m/Y');
                    }
                    if ($data['created_until'] ?? null) {
                        $indicators['created_until'] = 'วันที่ทำการจองถึงวันที่ ' . Carbon::parse($data['created_until'])->format('d/m/Y');
                    }

                    return $indicators;
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('ลบ')
                    ->hidden(fn ($record) => $record->status->value != 'pending')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('export')->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('borrow_number')->heading('รหัสการยืม'),
                            Column::make('user.name')->heading('ผู้ยืม'),
                            Column::make('user.branch')->heading('สาขา'),
                            Column::make('phone')->heading('เบอร์โทรศัพท์'),
                            Column::make('product')->heading('อุปกรณ์')
                                ->getStateUsing(function ($record) {
                                    $productName = $record->borrowItems->pluck('product.name')->toArray();
                                    $productName = implode(', ', array_values($productName));

                                    return $productName;
                                }),
                            Column::make('borrowItems.productItem')->heading('ครุภัณฑ์')
                                ->getStateUsing(function ($record) {
                                    $productName = $record->borrowItems->pluck('productItem.sku')->toArray();
                                    $productName = implode(', ', array_values($productName));

                                    return $productName;
                                }),
                            Column::make('note')->heading('หมายเหตุ'),
                            Column::make('borrow_date')->heading('วันที่ยืม'),
                            Column::make('borrow_date_return')->heading('กำหนดคืน'),
                            Column::make('status')->heading('สถานะ'),
                            Column::make('created_at')->heading('วันที่ทำรายการ'),
                        ])
                    ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ])
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrows::route('/'),
            'create' => Pages\CreateBorrow::route('/create'),
            'edit' => Pages\EditBorrow::route('/{record}/edit'),
        ];
    }
}
