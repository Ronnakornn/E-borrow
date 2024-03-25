<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use App\Models\Product;
use App\Enums\ProductStatus;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use App\Imports\ProductsImport;
use App\Filament\Imports\ProductImporter;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ImportAction::make()
            //     ->label('นำเข้าไฟล์')
            //     ->importer(ProductImporter::class)
            //     ->chunkSize(50),
            Actions\CreateAction::make()
                ->label('เพิ่มอุปกรณ์'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'ทั้งหมด' => Tab::make('All')
                ->label('ทั้งหมด'),
            'เปิดใช้งาน' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'enabled'))
                ->icon(ProductStatus::Enabled->getIcon())
                ->badge(Product::query()->where('status', 'enabled')->count())
                ->badgeColor(ProductStatus::Enabled->getColor()),
            'ปิดใช้งาน' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'disabled'))
                ->icon(ProductStatus::Disabled->getIcon())
                ->badge(Product::query()->where('status', 'disabled')->count())
                ->badgeColor(ProductStatus::Disabled->getColor()),
        ];
    }
}
