<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\BorrowResource\Pages;
use App\Filament\User\Resources\User\BorrowResource\RelationManagers;
use App\Models\Borrow;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Support\Enums\FontWeight;

class BorrowResource extends Resource
{
    protected static ?string $model = Borrow::class;

    protected static ?string $navigationIcon = 'heroicon-s-newspaper';
    
    protected static ?string $navigationLabel = 'รายการการยืม';

    protected static ?string $pluralModelLabel = 'รายการการยืม';

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
                Forms\Components\DateTimePicker::make('borrow_date')
                    ->label('วันที่ยืม')
                    ->seconds(false)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $carbon = Carbon::parse($state);
                        $carbon->setTime(17, 0);
                        return $set('borrow_date_return', $carbon->toDateTimeString());
                    })
                    ->required(),
                Forms\Components\DateTimePicker::make('borrow_date_return')
                    ->label('วันที่คืน')
                    ->disabled()
                    ->live(onBlur: true)
                    ->seconds(false),
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
                                return Product::where('status', 'enable')->where('amount', '>', '0')
                                    ->limit(20)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->options(function () {
                                return Product::limit(20)->where('amount', '>', '0')
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
                                    ->where('amount', '>', 0)
                                    ->limit(50)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                        Forms\Components\TextInput::make('amount')
                            ->label('จำนวน')
                            ->numeric()
                            ->step(1)
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                    ])->columns(2)
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
                Tables\Actions\DeleteAction::make()
                    ->label('ลบ')
                    ->hidden(fn ($record) => $record->status->value != 'pending')
                    ->before(function ($record) {
                       $productAmount = $record->borrowItems->pluck('product_id', 'amount');

                       foreach ($productAmount as $key => $value) {
                           $product = Product::where('id', $key)->increment('amount', $value);
                       }
                    }),
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
            'view' => Pages\ViewBorrows::route('/{record}'),
        ];
    }
}
