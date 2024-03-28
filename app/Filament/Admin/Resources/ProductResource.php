<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Enums\ProductStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\Alignment;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = 'อุปกรณ์';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'อุปกรณ์';

    protected static ?string $pluralModelLabel = 'อุปกรณ์';

    protected static ?string $navigationGroup = 'อุปกรณ์';

    protected static ?int $navigationSort = 2;

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
                                        modifyQueryUsing: fn (Builder $query) => $query->where('status', 'enabled'),
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
                                Forms\Components\ToggleButtons::make('status')
                                    ->label('เปิดการใช้งาน')
                                    ->inline()
                                    ->live()
                                    ->options(ProductStatus::class)
                                    ->required(),
                                Forms\Components\Placeholder::make('status_description')
                                    ->hiddenLabel()
                                    ->live()
                                    ->default('enable')
                                    ->content(fn (Get $get): string => $get('status') === 'enable' ? 'พร้อมให้บริการตลอดเวลา' : 'ไม่พร้อมให้บริการตลอดเวลา'),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make('ราคา')
                            ->id('prices')
                            ->schema([
                                Forms\Components\TextInput::make('product_attr.price_ex_vat')
                                    ->label('ราคาไม่รวมภาษี')
                                    ->suffix('บาท')
                                    ->numeric()
                                    ->columnSpan(['lg' => 3])
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->required(),
                                Forms\Components\TextInput::make('product_attr.price')
                                    ->label('ราคารวมภาษี')
                                    ->suffix('บาท')
                                    ->numeric()
                                    ->columnSpan(['lg' => 3])
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->required(),
                            ])->columns(6),
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

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('สร้างเมื่อ')
                                    ->content(fn (Product $record): ?string => $record->created_at?->format('d/m/Y H:i:s') . ' (' . $record->created_at?->diffForHumans() . ')'),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('แก้ไขล่าสุดเมื่อ')
                                    ->content(fn (Product $record): ?string => $record->updated_at?->format('d/m/Y H:i:s') . ' (' . $record->updated_at?->diffForHumans() . ')'),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Product $record) => $record === null),
                    ])
                    ->extraAttributes([
                        'class' => 'sticky',
                        'style' => 'top: 5.5rem',
                    ])
            ])->columns([
                'sm' => null,
                'lg' => 3,
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
                Tables\Columns\TextColumn::make('product_attr.price')
                    ->label('ราคา')
                    ->money('THB')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('product_attr->price', $direction);
                    })
                    ->searchable('product_attr->price')
                    ->alignment(Alignment::End),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('export')
                    ->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('name')->heading('อุปกรณ์'),
                            Column::make('product_attr.price')->heading('ราคา'),
                            Column::make('remain')->heading('จำนวนคงเหลือ'),
                            Column::make('quantity')->heading('จำนวนทั้งหมด'),
                            Column::make('status')->heading('สถานะ'),
                            Column::make('created_at')->heading('สร้างเมื่อ'),
                        ])
                    ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ])
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    // public static function getModelLabel(): string
    // {
    //     return __('admin/menu.product.label');
    // }
}

