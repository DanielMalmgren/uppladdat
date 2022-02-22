<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Owner');
    }

    public function chargers(): HasManyDeep
    {
        return $this->hasManyDeep(Charger::class, ['owner_user', Owner::class]);
    }

    public function payments(): HasManyDeep
    {
        return $this->hasManyDeep(Payment::class, ['owner_user', Owner::class, Charger::class, ChargingSession::class]);
    }
}
