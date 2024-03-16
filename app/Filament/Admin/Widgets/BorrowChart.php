<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Borrow;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class BorrowChart extends ChartWidget
{
    protected static ?string $heading = 'รายการยืม';

    protected static ?string $description = 'รายการยืม  / เดือน';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getBorrowPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'รายการยืม',
                    'data' => $data['borrowsPerMoth'],
                ]
            ],
            'labels' => $data['months'],
        ];
    }

    public function getColor(): string
    {
        return 'danger';
    }

    protected function getType(): string
    {
        return 'line';
    }

    // get borrow per month
    private function getBorrowPerMonth(){
        $now = Carbon::now();

        $months = collect(range(1, 12))->map(function ($month) use ($now) {
            return $now->month($month)->format('M');
        })->toArray();

        $borrowsPerMoth = collect(range(1, 12))->map(function ($month) use ($now) {
            $count = Borrow::whereMonth('created_at', $now->month($month))->whereYear('created_at', $now->format('Y'))->count();
            return $count;
        })->toArray();

        return [
            'borrowsPerMoth' => $borrowsPerMoth,
            'months' => $months
        ];
    }

}
