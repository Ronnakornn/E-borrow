<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Branch: string implements HasLabel, HasColor
{
    use Utilities;

    case Management = 'management';
    case Marketing = 'marketing';
    case Information = 'information';
    case Digital = 'digital';
    case Accounting = 'accounting';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Management => 'สาขาการจัดการ',
            self::Marketing => 'สาขาการตลาด',
            self::Information => 'สาขาระบบสารสนเทศ',
            self::Digital => 'ธรุกิจดิจิทัล',
            self::Accounting => 'สาขาการบัญชี',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Management => 'primary',
            self::Marketing => 'success',
            self::Information => 'warning',
            self::Digital => 'danger',
            self::Accounting => 'info',
        };
    }
}
