<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perro extends Model
{
protected $fillable = 
['usuario_id', 'nombre', 'raza', 'sexo', 'edad', 'peso', 'color', 'pedigree', 'foto_url', 'descripcion', 'disponible'];
public function usuario() { return $this->belongsTo(Usuario::class); }

}
