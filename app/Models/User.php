<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'phone_emergency',
        'avatar',
        'photo',
        'isActive',
        'code',
        'birthdate',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Método para generar un código único
    public static function generateUniqueCode()
    {
        // Lista de caracteres amigables
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Sin 0, O, 1, I
        $codeLength = 6; // Longitud del código

        do {
            $code = '';
            for ($i = 0; $i < $codeLength; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (self::where('code', $code)->exists());

        return $code;
    }

    // Generar un código único al crear un usuario
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->code = self::generateUniqueCode();
        });
    }

    public function gyms()
    {
        return $this->belongsToMany(Gym::class, 'gym_users', 'id_user', 'id_gym');
    }

    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class, 'id_user');
    }
}
