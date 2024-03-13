<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductStatus: string implements HasLabel, HasColor, HasIcon
{
    use Utilities;

    case Enable = 'enable';
    case Disable = 'disable';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Enable => 'เปิดใช้งาน',
            self::Disable => 'ปิดใช้งาน',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Enable => 'success',
            self::Disable => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Enable => 'heroicon-o-check-circle',
            self::Disable => 'heroicon-o-x-circle',
        };
    }
}
