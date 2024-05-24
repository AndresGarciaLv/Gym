<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_gym',
        'membership_id',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * Relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

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
     * Relación con el modelo Membership.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
