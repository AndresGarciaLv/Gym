<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'location',
        'isActive',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'gym_users', 'id_gym', 'id_user');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'id_gym');
    }
}
