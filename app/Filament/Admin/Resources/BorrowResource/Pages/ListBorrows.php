<?php

namespace App\Filament\Admin\Resources\BorrowResource\Pages;

use App\Filament\Admin\Resources\BorrowResource;
use Filament\Actions;
use App\Models\Borrow;
use App\Enums\BorrowStatus;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Filament\Support\Colors\Color;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListBorrows extends ListRecords
{
    protected static string $resource = BorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ ยืมอุปกรณ์'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'รอดำเนินการ' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending'))
                ->icon(BorrowStatus::Pending->getIcon())
                ->badge(Borrow::query()->where('status', 'pending')->count())
                ->badgeColor(BorrowStatus::Pending->getColor()),
            'รอคืนอุปกรณ์' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'confirmed'))
                ->icon(BorrowStatus::Confirmed->getIcon())
                ->badge(Borrow::query()->where('status', 'confirmed')->count())
                ->badgeColor(BorrowStatus::Confirmed->getColor()),
            'คืนอุปกรณ์แล้ว' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'returned'))
                ->icon(BorrowStatus::Returned->getIcon())
                ->badge(Borrow::query()->where('status', 'returned')->count())
                ->badgeColor(BorrowStatus::Returned->getColor()),
            'คืนอุปกรณ์ล่าช้า' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->whereIn('status', ['confirmed', 'late'])->where('borrow_date', '<', now()))
                ->icon(BorrowStatus::Late->getIcon())
                ->badge(Borrow::query()->whereIn('status', ['confirmed', 'late'])->where('borrow_date', '<', now())->count())
                ->badgeColor(BorrowStatus::Late->getIcon()),
            'ยกเลิกการยืม' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'canceled'))
                ->icon(BorrowStatus::Canceled->getIcon())
                ->badge(Borrow::query()->where('status', 'canceled')->count())
                ->badgeColor(BorrowStatus::Canceled->getColor()),
            'ทั้งหมด' => Tab::make('All')
                ->label('ทั้งหมด'),
        ];
    }
}
