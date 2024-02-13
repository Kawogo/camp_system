<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BookingStatus: string implements HasLabel, HasColor
{
    case Active = 'active';
    case Pending = 'pending';
    case Closed = 'closed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Pending => 'Pending',
            self::Closed => 'Closed',
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Pending => 'warning',
            self::Closed => 'danger',
        };
    }
}