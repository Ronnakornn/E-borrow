<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\ProductResource\Pages;
use App\Filament\User\Resources\User\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Get;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

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
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('ข้อมูลพื้นฐาน')
                        ->id('basic-information')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('หมวดหมู่อุปกรณ์')
                                ->relationship(
                                    name: 'category',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query) => $query->enabled(),
                                )
                                ->preload()
                                ->searchable()
                                ->required(),
                        ])
                        ->columns(2),
                    Forms\Components\Section::make('รายละเอียด')
                        ->id('attributes')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('ชื่ออุปกรณ์')
                                ->maxLength(255)
                                ->string()
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('description')
                                ->label('รายละเอียดอุปกรณ์')
                                ->maxLength(1024)
                                ->nullable()
                                ->autosize()
                                ->columnSpanFull(),
                            // Forms\Components\TextInput::make('product_attr.color')
                            //     ->label('สี'),
                            // Forms\Components\TextInput::make('product_attr.weight')
                            //     ->label('น้ำหนัก'),
                            // Forms\Components\TextInput::make('product_attr.dimension')
                            //     ->label('ขนาด'),
                            // Forms\Components\TextInput::make('warranty')
                            //     ->label('การรับประกัน')
                            //     ->maxLength(100)
                            //     ->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->columnSpan(['lg' => 1]),
                    Forms\Components\Section::make('รูปอุปกรณ์')
                        ->id('images')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('product_img')
                                ->hiddenLabel()
                                ->multiple()
                                ->openable()
                                ->maxSize(5000)
                                ->imageEditor()
                                ->preserveFilenames()
                                ->image()
                                ->maxFiles(5)
                                ->reorderable()
                                ->panelLayout('grid')
                                ->collection('products')
                                ->disk('media')
                        ]),
                    Forms\Components\Section::make('สถานะอุปกรณ์')
                        ->id('status')
                        ->schema([
                            Forms\Components\Toggle::make('status')
                                ->label('เปิดการใช้งาน')
                                ->default(true)
                                ->live()
                                ->onColor('success'),
                            Forms\Components\Placeholder::make('status_description')
                                ->hiddenLabel()
                                ->default(true)
                                ->content(fn (Get $get): string => $get('status') ? 'พร้อมให้บริการตลอดเวลา' : 'ไม่พร้อมให้บริการตลอดเวลา'),
                        ])
                        ->columns(2),
                    // Forms\Components\Section::make('ราคา')
                    //     ->id('prices')
                    //     ->schema([
                    //         Forms\Components\TextInput::make('product_attr.price_ex_vat')
                    //             ->label('ราคาไม่รวมภาษี')
                    //             ->suffix('บาท')
                    //             ->numeric()
                    //             ->columnSpan(['lg' => 3])
                    //             ->minValue(0)
                    //             ->step(0.01)
                    //             ->required(),
                    //         Forms\Components\TextInput::make('product_attr.price')
                    //             ->label('ราคารวมภาษี')
                    //             ->suffix('บาท')
                    //             ->numeric()
                    //             ->columnSpan(['lg' => 3])
                    //             ->minValue(0)
                    //             ->step(0.01)
                    //             ->required(),
                    //     ])->columns(6),
                    Forms\Components\Section::make('ตัวบ่งชี้อุปกรณ์')
                        ->id('identifiers')
                        ->schema([
                            Forms\Components\TextInput::make('product_attr.sku')
                                ->label('เลขครุภัณฑ์')
                                ->unique(column: 'products.product_attr->sku', ignoreRecord: true)
                                ->maxLength(100)
                                ->required(),
                        ]),
                    // Forms\Components\Section::make('อุปกรณ์คงคลัง')
                    //     ->id('inventory')
                    //     ->schema([
                    //         Forms\Components\TextInput::make('amount')
                    //             ->label('จำนวนอุปกรณ์')
                    //             ->numeric()
                    //             ->minValue(0)
                    //             ->required(),
                    //         // Forms\Components\Select::make('type')
                    //         //     ->label('ประเภทอุปกรณ์')
                    //         //     ->required()
                    //         //     ->options(ProductType::class),
                    //     ])
                    //     ->columns(2),
                    Forms\Components\Section::make('หมายเหตุ')
                        ->id('remarks')
                        ->schema([
                            Forms\Components\Textarea::make('remark')
                                ->label('หมายเหตุ')
                                ->maxLength(200)
                                ->nullable()
                                ->autosize()
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(['lg' => 2]),
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
                    ->label('ชื่อ')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('product_attr.sku')
                    ->label('เลขครุภัณฑ์')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('product_attr->sku', $direction);
                    })
                    ->searchable('product_attr->sku')
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('description')
                    ->label('รายละเอียด')
                    ->sortable()
                    ->searchable()
                    ->wrap(),

                // Tables\Columns\TextColumn::make('product_attr.price')
                //     ->label('ราคา')
                //     ->money('THB')
                //     ->sortable(query: function (Builder $query, string $direction): Builder {
                //         return $query
                //             ->orderBy('product_attr->price', $direction);
                //     })
                //     ->searchable('product_attr->price')
                //     ->alignment(Alignment::End),
                // Tables\Columns\TextColumn::make('amount')
                //     ->label('จํานวน')
                //     ->sortable()
                //     ->searchable()
                //     ->alignment(Alignment::Center),
                // Tables\Columns\TextColumn::make('type')
                //     ->label('ประเภท')
                //     ->badge()
                //     ->sortable()
                //     ->searchable()->alignment(Alignment::Center),
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
                                        ->label('ชื่อสินค้า')
                                        ->weight(FontWeight::Bold)
                                        ->limit(30),
                                    Infolists\Components\TextEntry::make('product_attr.sku')
                                        ->label('เลขครุภัณฑ์')
                                        ->weight(FontWeight::Bold)
                                        ->limit(30),
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
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
