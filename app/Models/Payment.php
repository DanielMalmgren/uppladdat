<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Payment extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function charging_session(): BelongsTo
    {
        return $this->belongsTo('App\Models\ChargingSession');
    }

    public function scopeAllForUser(Builder $query): Collection
    {
        $user = Auth::user();
        if($user->is_admin) {
            return $query->get();
        } else {
            return $query->get(); //TODO!!!
        }
    }
}
