<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Borrow;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class BorrowCancelChart extends ChartWidget
{
    protected static ?string $heading = 'รายการยืม ยกเลิก';

    protected static ?string $description = 'รายการยืม  / เดือน';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = $this->getBorrowPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'รายการยืม(ยกเลิก)',
                    'data' => $data['branchPerMonth'],
                ]
            ],
            'labels' => $data['branches'],
        ];
    }

    public function getColor(): string
    {
        return 'danger';
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function getBorrowPerMonth(){
        $now = Carbon::now();

        $branchEng = ['management', 'marketing', 'information', 'digital', 'accounting'];

        $branchPerMonth = collect($branchEng)->map(function ($branch) use ($now) {
            $managementId =  User::where('branch', $branch)->pluck('id')->toArray();
            $count = Borrow::where('status', 'canceled')->whereMonth('created_at', $now->month)->whereYear('created_at', $now->format('Y'))->whereIn('user_id', $managementId)->count();
            return $count;
        })->toArray();

        $branches = ['สาขาการจัดการ', 'สาขาการตลาด', 'สาขาระบบสารสนเทศ', 'ธรุกิจดิจิทัล', 'สาขาการบัญชี'];

        return [
            'branchPerMonth' => $branchPerMonth,
            'branches' => $branches
        ];
    }
}
