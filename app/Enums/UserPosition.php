<?php

namespace App\Enums;

use App\Enums\Concerns\Utilities;
use Filament\Support\Contracts\HasLabel;

enum UserPosition: string implements HasLabel
{
    use Utilities;

    case Student = 'student';
    case Lecturer = 'lecturer';
    case Personnel = 'personnel';
    case Officer = 'officer';
    case Admin = 'admin';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Student => 'นักศึกษา',
            self::Lecturer => 'อาจารย์',
            self::Personnel => 'บุคคลากร',
            self::Officer => 'เจ้าหน้าที่',
            self::Admin => 'แอดมิน',
        };
    }
}
