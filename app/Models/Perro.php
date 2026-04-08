<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perro extends Model
{
    protected $fillable = [
        'usuario_id', 
        'nombre', 
        'raza', 
        'sexo', 
        'edad', 
        'peso', 
        'color', 
        'pedigree', 
        'foto_url', 
        'descripción', // Asegúrate de que coincida con la migración
        'disponible'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    public function matchingsEnviados() {
    return $this->hasMany(Matching::class, 'perro_id_1');
}

    // Para que el whereDoesntHave funcione
    public function matchingsRecibidos() {
    return $this->hasMany(Matching::class, 'perro_id_2');
}
}
