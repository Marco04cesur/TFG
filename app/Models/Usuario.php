<?php

namespace App\Models;

// Cambiamos Model por Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'teléfono',
        'ciudad',
        'latitud',
        'longitud',
        'verificado',
        'calificación',
        'avatar',
    ];

    protected $hidden = ['password','remember_token',];

    // Indispensable: Laravel busca por defecto la columna 'password'
    // Como le he llamado contraseña 'contraseña', hay que avisarle:
    public function getAuthPassword() {
        return $this->password;
    }

    // Le dice a Laravel cómo se llama la columna en la base de datos
    public function getAuthPasswordName()
    {
        return 'password';
    }

    // Las relaciones se quedan igual
    public function perros() {
        return $this->hasMany(Perro::class, 'usuario_id');
    }

    public function calificaciones() {
        return $this->hasMany(Calificacion::class, 'usuario_id');
    }

    // El mutador para el hash
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}