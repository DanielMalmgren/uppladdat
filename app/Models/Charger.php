<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Charger extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo('App\Models\Owner');
    }

    public function charging_sessions(): HasMany
    {
        return $this->hasMany('App\Models\ChargingSession');
    }

}
