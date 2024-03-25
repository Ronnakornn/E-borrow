<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BorrowStatus: string implements HasLabel, HasColor, HasIcon
{
    use Utilities;

    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Canceled = 'canceled';
    case Returned = 'returned';
    case Late = 'late';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'รอดำเนินการ',
            self::Confirmed => 'อนุมัติ',
            self::Canceled => 'ยกเลิก',
            self::Returned => 'คืนอุปกรณ์แล้ว',
            self::Late => 'คืนอุปกรณ์ล่าช้า',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Canceled => 'danger',
            self::Returned => 'info',
            self::Late => Color::hex('#EE82EE'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-o-sparkles',
            self::Confirmed => 'heroicon-o-check',
            self::Canceled => 'heroicon-o-x-mark',
            self::Returned => 'heroicon-o-receipt-refund',
            self::Late => 'heroicon-o-clock',
        };
    }
}
