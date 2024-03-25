<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductItemBorrowStatus: string implements HasLabel, HasColor, HasIcon
{
    use Utilities;

    case Ready = 'ready';
    case Borrow = 'borrow';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ready => 'ว่าง',
            self::Borrow => 'ถูกยืม',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Ready => 'success',
            self::Borrow => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Ready => 'heroicon-o-check-circle',
            self::Borrow => 'heroicon-o-arrow-path',
        };
    }
}
