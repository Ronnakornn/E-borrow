<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\Alignment;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'อุปกรณ์';

    protected static ?string $pluralModelLabel = 'อุปกรณ์';

    protected static ?string $navigationIcon = 'heroicon-c-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
           //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('product_img')
                    ->label('')
                    ->limit(1)
                    ->height('4rem')
                    ->width('4rem')
                    ->collection('products')
                    ->square()
                    ->conversion('small')
                    ->extraImgAttributes([
                        'class' => 'rounded',
                    ]),
                Tables\Columns\TextColumn::make('name')
                    ->label('ชื่ออุปกรณ์')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description')
                    ->label('รายละเอียด')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('remain')
                    ->label('จำนวนคงเหลือ')
                    ->formatStateUsing(fn ($record): ?string => $record?->remain . '/' . $record?->quantity)
                    ->alignment(Alignment::Center)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('สถานะ')
                    ->sortable()
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('สร้างเมื่อ')
                    ->dateTime('d/m/Y H:i:s')
                    ->searchable()
                    ->sortable()
                    ->alignment(Alignment::Center),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static  function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make([
                    Infolists\Components\Section::make('อุปกรณ์')
                    ->schema([
                        Components\SpatieMediaLibraryImageEntry::make('product->media')
                            ->collection('products')
                            ->hiddenLabel()
                            ->height('15rem')
                            ->width('15rem')
                            ->square()
                            ->columnSpanFull()
                            ->extraImgAttributes([
                                'class' => 'rounded',
                            ]),
                            Infolists\Components\Section::make('รายละเอียดอุปกรณ์')
                                ->schema([
                                    Infolists\Components\TextEntry::make('name')
                                        ->label('ชื่ออุปกรณ์')
                                        ->weight(FontWeight::Bold)
                                        ->copyable()
                                        ->copyMessage('Copied!')
                                        ->limit(30),
                                    Infolists\Components\TextEntry::make('productItems.sku')
                                        ->label('เลขครุภัณฑ์')
                                        ->separator(',')
                                        ->badge()
                                        ->weight(FontWeight::Bold),
                                    Infolists\Components\TextEntry::make('description')
                                        ->label('รายละเอียด'),
                                    Infolists\Components\TextEntry::make('remark')
                                        ->label('หมายเหตุ')
                                        ->limit(30)
                                ])->columns(2),
                    ])->columns(3)
                ])->columnSpanFull(),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }
}
