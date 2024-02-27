<?php

namespace App\Filament\User\Resources\User\BorrowResource\Pages;

use App\Filament\User\Resources\User\BorrowResource;
use App\Models\Borrow;
use App\Enums\BorrowStatus;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListBorrows extends ListRecords
{
    protected static string $resource = BorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('ยืมอุปกรณ์'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'ทั้งหมด' => Tab::make('All')
                ->label('ทั้งหมด'),
            'รอดำเนินการ' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending')->where('user_id', auth()->user()->id))
                ->icon(BorrowStatus::Pending->getIcon())
                ->badge(Borrow::query()->where('status', 'pending')->count())
                ->badgeColor(BorrowStatus::Pending->getColor()),
            'ยืนยันการยืม' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'confirmed')->where('user_id', auth()->user()->id))
                ->icon(BorrowStatus::Confirmed->getIcon())
                ->badge(Borrow::query()->where('status', 'confirmed')->count())
                ->badgeColor(BorrowStatus::Confirmed->getColor()),
            'คืนอุปกรณ์' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'returned')->where('user_id', auth()->user()->id))
                ->icon(BorrowStatus::Returned->getIcon())
                ->badge(Borrow::query()->where('status', 'returned')->count())
                ->badgeColor(BorrowStatus::Returned->getColor()),
            'ยกเลิกการยืม' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'canceled')->where('user_id', auth()->user()->id))
                ->icon(BorrowStatus::Canceled->getIcon())
                ->badge(Borrow::query()->where('status', 'canceled')->count())
                ->badgeColor(BorrowStatus::Canceled->getColor()),
        ];
    }
}
