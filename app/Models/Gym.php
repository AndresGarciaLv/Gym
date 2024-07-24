<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gym extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'isActive',
        'photo',
        'phone_number',
        'email',
        'slug',

    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'gym_users', 'id_gym', 'id_user');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'id_gym');
    }

       // Generar un slug único al crear o actualizar un gimnasio
       public static function boot()
       {
           parent::boot();

           static::creating(function ($gym) {
               $gym->slug = self::generateUniqueSlug($gym->name);
           });

           static::updating(function ($gym) {
               $gym->slug = self::generateUniqueSlug($gym->name);
           });
       }

       // Método para generar un slug único basado en el nombre del gimnasio
       public static function generateUniqueSlug($name)
       {
           $slug = Str::slug($name);
           $count = self::where('slug', 'like', "{$slug}%")->count();

           return $count ? "{$slug}-{$count}" : $slug;
       }

}
