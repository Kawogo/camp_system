<?php

namespace App\Models;

use App\Enums\MemberTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['room_id','company_id','department_id','name', 'phone','id_number','occupation'];

    protected $casts = ['type' => MemberTypeEnum::class];

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class);
    }

    public function checkouts(): HasMany {
        return $this->hasMany(Checkout::class);
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function camp(): BelongsTo {
        return $this->belongsTo(Camp::class);
    }
}
