<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductItemQuantityStatus: string implements HasLabel, HasColor, HasIcon
{
    use Utilities;

    case Enabled = 'enabled';
    case Disabled = 'disabled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Enabled => 'พร้อมใช้',
            self::Disabled => 'ไม่พร้อมใช้',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Enabled => 'success',
            self::Disabled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Enabled => 'heroicon-o-check-circle',
            self::Disabled => 'heroicon-o-x-circle',
        };
    }
}
