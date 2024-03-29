<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\Branch;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;

class BorrowChart extends ChartWidget
{
    protected static ?string $heading = 'รายการยืม อนุมัติ';

    protected static ?string $description = 'รายการยืม  / เดือน';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getBorrowPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'รายการยืม(อนุมัติ)',
                    'data' => $data['branchPerMonth'],
                ]
            ],
            'labels' => $data['branches'],
        ];
    }

    public function getColor(): string
    {
        return 'success';
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // get borrow per month
    // private function getBorrowPerMonth(){
    //     $now = Carbon::now();

    //     $months = collect(range(1, 12))->map(function ($month) use ($now) {
    //         return $now->month($month)->format('M');
    //     })->toArray();

    //     $borrowsPerMoth = collect(range(1, 12))->map(function ($month) use ($now) {
    //         $count = Borrow::whereMonth('created_at', $now->month($month))->whereYear('created_at', $now->format('Y'))->count();
    //         return $count;
    //     })->toArray();

    //     return [
    //         'borrowsPerMoth' => $borrowsPerMoth,
    //         'months' => $months
    //     ];
    // }

    private function getBorrowPerMonth(){
        $now = Carbon::now();

        $branchEng = ['management', 'marketing', 'information', 'digital', 'accounting'];

        $branchPerMonth = collect($branchEng)->map(function ($branch) use ($now) {
            $managementId =  User::where('branch', $branch)->pluck('id')->toArray();
            $count = Borrow::where('status', 'confirmed')->whereMonth('created_at', $now->month)->whereYear('created_at', $now->format('Y'))->whereIn('user_id', $managementId)->count();
            return $count;
        })->toArray();

        $branches = ['สาขาการจัดการ', 'สาขาการตลาด', 'สาขาระบบสารสนเทศ', 'ธรุกิจดิจิทัล', 'สาขาการบัญชี'];

        return [
            'branchPerMonth' => $branchPerMonth,
            'branches' => $branches
        ];
    }

}
