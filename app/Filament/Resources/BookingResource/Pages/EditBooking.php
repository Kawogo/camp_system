<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Enums\BookingStatus;
use App\Enums\RoomStatusEnum;
use App\Filament\Resources\BookingResource;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }


    protected function afterSave(): void
    {
       if ($this->record->status->value === BookingStatus::Closed->value) {
           Room::where('id','=', $this->record->room_id)->update(['status' => RoomStatusEnum::Open->value]);
       }
    }
}
