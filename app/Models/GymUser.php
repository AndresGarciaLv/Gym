<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymUser extends Model
{
    use HasFactory;

    protected $table = 'gym_users';

    protected $fillable = [
        'id_user',
        'id_gym',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class, 'id_gym');
    }
}
