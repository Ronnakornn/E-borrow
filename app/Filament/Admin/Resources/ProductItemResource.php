<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ProductItemBorrowStatus;
use App\Enums\ProductItemQuantityStatus;
use App\Filament\Admin\Resources\ProductItemResource\Pages;
use App\Filament\Admin\Resources\ProductItemResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class ProductItemResource extends Resource
{
    protected static ?string $model = ProductItem::class;

    protected static ?string $navigationIcon = 'heroicon-c-qr-code';

    protected static ?string $modelLabel = 'ครุภัณฑ์';

    protected static ?string $navigationGroup = 'อุปกรณ์';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\section::make()
                    ->schema([
                        Forms\Components\select::make('product_id')
                        ->label('ชื่ออุปกรณ์')
                        ->relationship(
                            'product',
                            'name',
                            modifyQueryUsing: fn (Builder $query) => $query->where('status', 'enabled')
                        )
                        ->options(Product::where('status', 'enabled')->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('sku')
                        ->label('เลขครุภัณฑ์')
                        ->unique(ignorable: fn ($record) => $record)
                        ->required()
                        ->maxLength(255),
                    Forms\Components\ToggleButtons::make('status_quantity')
                        ->label('สถานะอุปกรณ์')
                        ->inline()
                        ->options(ProductItemQuantityStatus::class)
                        ->required(),
                    Forms\Components\ToggleButtons::make('status_borrow')
                        ->label('สถานะการยืม')
                        ->inline()
                        ->options(ProductItemBorrowStatus::class)
                        ->required(),
                    Forms\Components\Textarea::make('remark')
                        ->label('หมายเหตุ')
                        ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('ชื่ออุปกรณ์')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('เลขครุภัณฑ์')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_quantity')
                    ->label('สถานะการใช้งาน')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_borrow')
                    ->label('สถานะการยืม')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->label('หมายเหตุ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('สร้างเมื่อ')
                    ->searchable()
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
                    ->after(function (Model $record){
                        $productId = $record->pluck('product_id');

                        dd($record);

                        $countQuantity = $record->where('status_quantity', 'enabled')->count();
                        $countBorrow = $record->where('status_borrow', 'ready')->count();

                        dd('$countQuantity : '.$countQuantity);

                        Product::whereIn('id', $productId)->update(['quantity' => $countQuantity, 'remain' => $countBorrow]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProductItems::route('/'),
            'create' => Pages\CreateProductItem::route('/create'),
            'edit' => Pages\EditProductItem::route('/{record}/edit'),
        ];
    }
}
