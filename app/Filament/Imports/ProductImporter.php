<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {

        return [
            // ImportColumn::make('name')
        ];
    }

    protected function afterSave(): void
    {
        $this->record->addMedia(Arr::get($this->data, 'image', ''))->preservingOriginal()->storingConversionsOnDisk('media')->toMediaCollection('products', 'media');
    }

    public function resolveRecord(): ?Product
    {
        $category = Category::whereName(Str::of(Arr::get($this->data, 'category'))->trim());
        if ($category->count() == 0) {
            $params = [
                'name' => Str::of(Arr::get($this->data, 'category'))->trim(),
                'status' => 'enable'
            ];

            $categoryInsert =  Category::create($params);
            $categoryId = $categoryInsert->id;
        } else {
            $categoryId = $category->first()->id;
        }

        return Product::updateOrCreate([
            // Update existing records, matching them by `$this->data['column_name']`
            'product_attr->sku' => Arr::get($this->data, 'sku'),
        ],[
            // Create new records, matching them by `$this->data['column_name']`
            'category_id' =>  $categoryId,
            'name' => Arr::get($this->data, 'name'),
            'description' => Arr::get($this->data, 'description'),
            'product_attr' => [
                'sku' => Arr::get($this->data, 'sku'),
                'price' => Arr::get($this->data, 'srpin_vat'),
                'price_ex_vat' => Arr::get($this->data, 'srpex_vat'),
            ],
            'remark' => Arr::get($this->data, 'remark')
        ]);

        return new Product();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
