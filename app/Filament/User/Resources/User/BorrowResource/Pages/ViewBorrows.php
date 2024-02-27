<?php

namespace App\Filament\User\Resources\User\BorrowResource\Pages;

use App\Filament\User\Resources\User\BorrowResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBorrows extends ViewRecord
{
    protected static string $resource = BorrowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
