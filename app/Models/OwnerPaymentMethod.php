<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerPaymentMethod extends Model
{
    use HasFactory;

    public function charging_session(): BelongsTo
    {
        return $this->belongsTo('App\Models\ChargingSession');
    }

}
