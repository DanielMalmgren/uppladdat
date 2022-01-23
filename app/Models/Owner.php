<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Owner extends Model
{
    use HasFactory;

    public function chargers(): HasMany
    {
        return $this->hasMany('App\Models\Charger');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function owner_payment_methods(): HasMany
    {
        return $this->hasMany('App\Models\OwnerPaymentMethod');
    }
}
