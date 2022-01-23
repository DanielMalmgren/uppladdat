<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChargingSession extends Model
{
    use HasFactory;

    public function charger(): BelongsTo
    {
        return $this->belongsTo('App\Models\Charger');
    }

    public function payments(): HasMany
    {
        return $this->hasMany('App\Models\Payment');
    }
}
