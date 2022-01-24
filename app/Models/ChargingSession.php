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

    function initialize(Charger $charger) {
        $this->charger_id = $charger->id;
        $this->start_at = (new \DateTime());
        list($hours, $minutes, $seconds) = sscanf($charger->owner->max_time, '%d:%d:%d');
        $length = new \DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds));
        $this->end_at = (new \DateTime())->add($length);
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

    public function getDurationAttribute()
    {
        return $this->end_at->diffInMinutes($this->start_at)/60;
    }

    public function getAmountAttribute()
    {
        return $this->duration * $this->charger->price_per_hour;
    }
}
