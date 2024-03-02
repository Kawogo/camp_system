<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Enums\BookingStatus;
use App\Enums\RoomStatusEnum;
use App\Filament\Resources\BookingResource;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;


    protected function afterCreate(): void
    {
        
        if ($this->record->status->value === BookingStatus::Active->value) {     
            Room::where('id', '=', $this->record->room_id)->update(['status' => RoomStatusEnum::Full->value]);
        }

    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $fromDate = \Carbon\Carbon::parse($data['from_date']);
        $toDate = \Carbon\Carbon::parse($data['to_date']);

        $data['period_onsite'] = $toDate->diffInDays($fromDate) + 1;
        return $data;
    }

}
