<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_gym',
        'id_user',
        'title',
        'content',
        'isActive',
        'slug',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class, 'id_gym');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Generar un slug único al crear o actualizar un aviso
    public static function boot()
    {
        parent::boot();

        static::creating(function ($notice) {
            $notice->slug = self::generateUniqueSlug($notice->title);
        });

        static::updating(function ($notice) {
            $notice->slug = self::generateUniqueSlug($notice->title);
        });
    }

    // Método para generar un slug único basado en el título
    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = self::where('slug', 'like', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}

