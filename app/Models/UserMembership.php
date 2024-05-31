<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_gym',
        'id_membership',
        'start_date',
        'end_date',
        'duration_days',
        'isActive',
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
        return $this->belongsTo(Membership::class, 'id_membership');
    }

    public function getStatusAttribute()
    {
        $now = Carbon::now()->startOfDay();
        $end_date = Carbon::parse($this->end_date)->startOfDay();
        $days_remaining = $now->diffInDays($end_date, false);
        
        if ($now->isSameDay($end_date)) {
            $this->isActive = true;
            return 'Vence Hoy';
        } elseif ($days_remaining > 7) {
            $this->isActive = true;
            return 'Vigente';
        } elseif ($days_remaining >= 1 && $days_remaining <= 7) {
            $this->isActive = true;
            return 'Por Vencer';
        } else {
            $this->isActive = false;
            return 'Vencido';
        }
    }
    
    
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'Vigente':
                return '#28a745'; // Verde
            case 'Por Vencer':
                return '#ffc107'; // Naranja
            case 'Vencido':
                return '#dc3545'; // Rojo
            case 'Vence Hoy':
                return '#007bff'; // Azul
            default:
                return '#6c757d'; // Gris
        }
    }

}
