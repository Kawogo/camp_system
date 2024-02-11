<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    public function member(): BelongsTo {
        return $this->belongsTo(Member::class);
    }

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class);
    }
}