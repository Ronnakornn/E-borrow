<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductStatus: string implements HasLabel, HasColor, HasIcon
{
    use Utilities;

    // case Ready = 'ready';
    // case Borrow = 'borrow';
    // case Damaged = 'bamaged';

    // public function getLabel(): ?string
    // {
    //     return match ($this) {
    //         self::Ready => 'พร้อมใช้',
    //         self::Borrow => 'ยืม',
    //         self::Damaged => 'ชำรุด',
    //     };
    // }

    // public function getColor(): string | array | null
    // {
    //     return match ($this) {
    //         self::Ready => 'success',
    //         self::Borrow => 'warning',
    //         self::Damaged => 'danger',
    //     };
    // }

    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::Ready => 'heroicon-o-check-circle',
    //         self::Borrow => 'heroicon-o-arrow-path',
    //         self::Damaged => 'heroicon-o-x-circle',
    //     };
    // }

    case Enabled = 'enabled';
    case Disabled = 'disabled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Enabled => 'พร้อมใช้งาน',
            self::Disabled => 'ปิดใช้งาน',
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
