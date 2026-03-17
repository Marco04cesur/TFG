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
        'contraseña',
        'teléfono',
        'ciudad',
        'latitud',
        'longitud',
        'verificado',
        'calificación',
    ];

    protected $hidden = ['contraseña'];

    // Indispensable: Laravel busca por defecto la columna 'password'
    // Como la tuya se llama 'contraseña', hay que avisarle:
    public function getAuthPassword() {
        return $this->contraseña;
    }

    // Tus relaciones se quedan igual
    public function perros() {
        return $this->hasMany(Perro::class, 'usuario_id');
    }

    public function calificaciones() {
        return $this->hasMany(Calificacion::class, 'usuario_id');
    }

    // Tu mutador para el hash
    public function setContraseñaAttribute($value) {
        $this->attributes['contraseña'] = Hash::make($value);
    }
}