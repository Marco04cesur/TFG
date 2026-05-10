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