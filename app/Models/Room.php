<?php

namespace App\Models;

use App\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $casts = ['status' => RoomStatusEnum::class];

    public function camp(): BelongsTo {
        return $this->belongsTo(Camp::class);
    }

    public function member(): HasOne {
        return $this->hasOne(Member::class);
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }
}
