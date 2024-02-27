<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BorrowStatus: string implements HasLabel, HasColor, HasIcon
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Canceled = 'canceled';
    case Returned = 'returned';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'รอดำเนินการ',
            self::Confirmed => 'ยืนยันการจอง',
            self::Canceled => 'ยกเลิกการจอง',
            self::Returned => 'คืนอุปกรณ์',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Canceled => 'danger',
            self::Returned => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-o-sparkles',
            self::Confirmed => 'heroicon-o-check',
            self::Canceled => 'heroicon-o-x-mark',
            self::Returned => 'heroicon-o-receipt-refund',
        };
    }
}
