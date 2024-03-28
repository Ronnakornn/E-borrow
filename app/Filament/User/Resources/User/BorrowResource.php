<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\BorrowResource\Pages;
use App\Filament\User\Resources\User\BorrowResource\RelationManagers;
use App\Models\Borrow;
use App\Models\BorrowItem;
use App\Models\Product;
use App\Enums\BorrowStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;


class BorrowResource extends Resource
{
    protected static ?string $model = Borrow::class;

    protected static ?string $navigationIcon = 'heroicon-s-newspaper';

    protected static ?string $navigationLabel = 'รายการการยืม';

    protected static ?string $pluralModelLabel = 'รายการการยืม';

    protected static ?string $modelLabel = 'รายการการยืม';

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
                Forms\Components\TextInput::make('phone')
                    ->label('เบอร์โทรศัพท์')
                    ->formatStateUsing(fn () => auth()->user()->phone ?? '')
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
                    ->relationship()
                    ->label('อุปกรณ์')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('อุปกรณ์')
                            ->relationship('product', 'name')
                            ->options(function () {
                                return Product::where('status', 'enable')
                                    ->limit(20)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->options(function () {
                                return Product::limit(20)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->optionsLimit(20)
                            ->searchable()
                            ->required()
                            ->getSearchResultsUsing(function (string $search) {
                                return Product::where('product_attr->sku', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%")
                                    ->where('status', 'enable')
                                    ->limit(50)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                    ])
            ])->columns(['lg' => 'full']),
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
                Tables\Columns\TextColumn::make('borrowItems.productItem.product.name')
                    ->label('อุปกรณ์')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrowItems.productItem.sku')
                    ->label('รหัสอุปกรณ์')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('เบอร์โทรศัพท์')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrow_date')
                    ->label('วันที่ยืม')
                    ->searchable()
                    ->dateTime('d/m/Y H:i')
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
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('ลบ')
                    ->hidden(fn ($record) => $record->status->value != 'pending')
            ])
            ->defaultSort('created_at', 'desc');
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('รายการอุปกรณ์')
                        ->schema([
                            Infolists\Components\RepeatableEntry::make('borrowItems')
                                ->label('รายการอุปกรณ์')
                                ->hiddenLabel()
                                ->contained(false)
                                ->schema([
                                    Infolists\Components\ImageEntry::make('image')
                                        ->limit(1)
                                        ->hiddenLabel()
                                        ->defaultImageUrl(
                                            static function (BorrowItem $record): ?string {
                                                return $record->product->getFirstMediaUrl('products', 'mobile');
                                            }
                                        )
                                        ->height('8rem')
                                        ->width('8rem')
                                        ->square()
                                        ->extraImgAttributes([
                                            'class' => 'rounded',
                                        ]),
                                    Infolists\Components\TextEntry::make('product.name')
                                        ->label('ชื่ออุปกรณ์')
                                        ->hiddenLabel()
                                        ->weight(FontWeight::Bold)
                                        ->helperText(function (BorrowItem $record) {
                                            return new HtmlString(Arr::get($record->product->product_attr, 'sku'));
                                        })
                                        ->limit(30)
                                        ->columnSpan(['default' => 2, 'sm' => 4]),
                                ])
                                ->columns(['default' => 6, 'sm' => 5])
                        ])
                        ->columnSpan(['lg' => 1]),
                ])
                    ->columnSpan(['lg' => 2]),
                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('ข้อมูลการยืม')
                        ->schema([
                            Infolists\Components\TextEntry::make('status')
                                ->label('สถานะ')
                                ->badge(),
                            Infolists\Components\TextEntry::make('borrow_number')
                                ->label('รหัสการยืม')
                                ->copyable(),
                            Infolists\Components\TextEntry::make('borrow_date')
                                ->label('วันที่ยืม'),
                            Infolists\Components\TextEntry::make('borrow_date_return')
                                ->label('กำหนดคืน'),
                        ]),
                    Infolists\Components\Section::make([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('สร้างเมื่อ'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('แก้ไขเมื่อ'),
                    ])
                ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
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
            'view' => Pages\ViewBorrows::route('/{record}'),
        ];
    }
}
