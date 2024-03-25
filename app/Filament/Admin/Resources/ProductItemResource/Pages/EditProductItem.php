<?php

namespace App\Filament\Admin\Resources\ProductItemResource\Pages;

use App\Filament\Admin\Resources\ProductItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductItem extends EditRecord
{
    protected static string $resource = ProductItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
