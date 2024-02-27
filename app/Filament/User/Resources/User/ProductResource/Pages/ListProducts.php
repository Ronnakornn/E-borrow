<?php

namespace App\Filament\User\Resources\User\ProductResource\Pages;

use App\Filament\User\Resources\User\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
