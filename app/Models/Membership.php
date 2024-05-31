<?php

namespace App\Models;

use App\Enums\DurationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_gym',
        'name',
        'description',
        'price',
        'isActive',
        'duration_type',
    ];
    protected $casts = [
        'duration_type' => DurationType::class,
    ];

    /**
     * Relación con el modelo Gym.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'id_gym');
    }

    /**
     * Relación con el modelo UserMembership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class, 'id_membership');
    }
}
