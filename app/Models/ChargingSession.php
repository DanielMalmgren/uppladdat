<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Charger;

class ChargingSession extends Model
{
    use HasFactory;

    function __construct(Charger $charger) {
        parent::__construct();
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
}
