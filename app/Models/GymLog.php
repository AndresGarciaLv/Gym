<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_user',
        'id_gym',
        'action',
        'timestamp',
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
