<?php

namespace App\Filament\Admin\Resources\BorrowResource\Pages;

use App\Models\Borrow;
use App\Models\Product;
use App\Filament\Admin\Resources\BorrowResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Carbon\Carbon;
use Illuminate\Support\Arr;


class CreateBorrow extends CreateRecord
{
    protected static string $resource = BorrowResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $borrow_date_return = Carbon::parse($data['borrow_date']);
        $borrow_date_return->setTime(16, 0);

        $borrowNumber = $this->generateNumber();
        Arr::set($data, 'borrow_number', $borrowNumber);
        Arr::set($data, 'borrow_date_return', $borrow_date_return->toDateTimeString());

        return $data;
    }

    protected function generateNumber(){
        $currentDate = Carbon::now()->format('ymd');

        // Find the last booking number for the current date
        $lastBooking = Borrow::where('borrow_number', 'like', "BR-{$currentDate}-%")
            ->latest()
            ->first();

        $serialNumber = 1; // Default for the first booking of the day

        if ($lastBooking) {
            $lastSerial = substr($lastBooking->borrow_number, -4);
            $serialNumber = intval($lastSerial) + 1;
        }

        // Pad the serial number with leading zeros to ensure 4 digits
        $paddedSerial = str_pad($serialNumber, 4, '0', STR_PAD_LEFT);
        $bookingNumber = "BR-{$currentDate}-{$paddedSerial}";

        return $bookingNumber;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
