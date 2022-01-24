<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function owner(): BelongsTo
    {
        return $this->belongsTo('App\Models\Owner');
    }

    public function charging_session(): BelongsTo
    {
        return $this->belongsTo('App\Models\ChargingSession');
    }

}
