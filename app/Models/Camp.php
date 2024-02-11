<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camp extends Model
{
    use HasFactory;

    public function rooms(): HasMany {
        return $this->hasMany(Room::class);
    }
    
    public function members(): HasMany {
        return $this->hasMany(Member::class);
    }
}
