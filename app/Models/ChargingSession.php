<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use App\Models\Charger;

class ChargingSession extends Model
{
    use HasFactory;

    protected $dates = ['start_at', 'end_at'];

    function initialize(Charger $charger): void
    {
        $this->charger_id = $charger->id;
        $this->start_at = (Carbon::now());
        list($hours, $minutes, $seconds) = sscanf($charger->owner->max_time, '%d:%d:%d');
        $this->end_at = (Carbon::now()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds));
        $this->save();
    }

    public function charger(): BelongsTo
    {
        return $this->belongsTo('App\Models\Charger');
    }

    public function payments(): HasMany
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function getDurationAttribute(): float
    {
        return $this->end_at->diffInMinutes($this->start_at)/60;
    }

    public function getAmountAttribute(): float
    {
        return $this->duration * $this->charger->price_per_hour;
    }
}
