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

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('เพิ่มอุปกรณ์'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'ทั้งหมด' => Tab::make('All')
                ->label('ทั้งหมด'),
            'พร้อมใช้งาน' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'ready'))
                ->icon(ProductStatus::Ready->getIcon())
                ->badge(Product::query()->where('status', 'ready')->count())
                ->badgeColor(ProductStatus::Ready->getColor()),
            'ยืม' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'borrow'))
                ->icon(ProductStatus::Borrow->getIcon())
                ->badge(Product::query()->where('status', 'borrow')->count())
                ->badgeColor(ProductStatus::Borrow->getColor()),
            'ชํารุด' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'bamaged'))
                ->icon(ProductStatus::Damaged->getIcon())
                ->badge(Product::query()->where('status', 'bamaged')->count())
                ->badgeColor(ProductStatus::Damaged->getColor()),
        ];
    }
}
