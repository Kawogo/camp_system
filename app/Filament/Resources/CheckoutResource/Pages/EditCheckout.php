<?php

namespace App\Filament\Resources\CheckoutResource\Pages;

use App\Enums\BookingStatus;
use App\Enums\RoomStatusEnum;
use App\Filament\Resources\CheckoutResource;
use App\Models\Booking;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckout extends EditRecord
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void {
        $isActiveBooking = Booking::where(['member_id' => $this->record->member_id, 'status' => BookingStatus::Active->value])->first();


        if ($isActiveBooking) {
            // recalucate the onsite days
            $fromDate = \Carbon\Carbon::parse($isActiveBooking->from_date);
            $toDate = \Carbon\Carbon::parse($this->record->leave_date);
            $period_onsite = $toDate->diffInDays($fromDate) + 1;

            // update
            $isActiveBooking->status = BookingStatus::Closed->value;
            $isActiveBooking->to_date = $this->record->leave_date;
            $isActiveBooking->from_date = $isActiveBooking->from_date;
            $isActiveBooking->period_onsite = $period_onsite;
            $isActiveBooking->save();
            
            Room::where('id', '=', $isActiveBooking->room_id)->update(['status' => RoomStatusEnum::Open->value]);
        }
    }
}
