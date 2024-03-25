<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use App\Enums\ProductStatus;
use App\Enums\UserPosition;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            // Stat::make('Users', User::where('user_role', '!=', 'admin')->count())
            //     ->label('จํานวนผู้ใช้งาน')
            //     ->description('จํานวนผู้ใช้งานทั้งหมด')
            //     ->color('success')
            //     ->chart([1, 4, 3, 7, 5, 9, 13]),
            // Stat::make('Products', Product::count())
            //     ->label('จํานวนคุรุภัณฑ์')
            //     ->description('จํานวนคุรุภัณฑ์ทั้งหมด')
            //     ->color('warning')
            //     ->chart([7, 2, 10, 3, 15, 4, 17]),
            // Stat::make('Users', User::where('position', UserPosition::Student)->count())
            //     ->label('จํานวนนักศึกษา')
            //     ->color('info')
            //     ->chart([1, 4, 3, 7, 5, 9, 13]),
            // Stat::make('Users', User::where('position', UserPosition::Lecturer)->count())
            //     ->label('จํานวนอาจารย์')
            //     ->color('info')
            //     ->chart([1, 4, 3, 7, 5, 9, 13]),
            // Stat::make('Users', User::where('position', UserPosition::Personnel)->count())
            //     ->label('จํานวนบุคลากร')
            //     ->color('info')
            //     ->chart([1, 4, 3, 7, 5, 9, 13]),
            // Stat::make('Users', User::where('position', UserPosition::Officer)->count())
            //     ->label('จํานวนเจ้าหน้าที่')
            //     ->color('info')
            //     ->chart([1, 4, 3, 7, 5, 9, 13]),
            // Stat::make('Products', Product::where('status', ProductStatus::Ready)->count())
            //     ->label('จํานวนคุรุภัณฑ์ที่พร้อมใช้งาน')
            //     ->color('warning')
            //     ->chart([7, 2, 10, 3, 15, 4, 17]),
            // Stat::make('Products', Product::where('status', ProductStatus::Borrow)->count())
            //     ->label('จํานวนคุรุภัณฑ์ที่ถูกยืม')
            //     ->color('warning')
            //     ->chart([7, 2, 10, 3, 15, 4, 17]),
            // Stat::make('Products', Product::where('status', ProductStatus::Damaged)->count())
            //     ->label('จํานวนคุรุภัณฑ์ที่ชํารุด')
            //     ->color('warning')
            //     ->chart([7, 2, 10, 3, 15, 4, 17]),

        ];
    }
}
