<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class);
    }

    public function checkouts(): HasMany {
        return $this->hasMany(Checkout::class);
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }

    public function company(): HasOne {
        return $this->hasOne(Company::class);
    }

    public function department(): HasOne {
        return $this->hasOne(Department::class);
    }
}
