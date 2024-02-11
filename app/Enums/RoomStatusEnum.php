<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RoomStatusEnum: string implements HasLabel, HasColor
{
    case Open = 'open';
    case Full = 'full';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Open => 'Open',
            self::Full => 'Full',
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Open => 'success',
            self::Full => 'danger',
        };
    }
}
