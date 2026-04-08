<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    protected $table = 'matches'; // Laravel por defecto busca 'matchings', especificamos 'matches'
    
    protected $fillable = [
        'perro_id_1',
        'perro_id_2',
        'estado'
    ];

public function perro1()
{
    return $this->belongsTo(Perro::class, 'perro_id_1');
}

public function perro2()
{
    return $this->belongsTo(Perro::class, 'perro_id_2');
}

public function mensajes()
{
    // Un match tiene muchos mensajes
    // El segundo parámetro es la clave foránea en tu tabla 'mensajes'
    return $this->hasMany(Mensaje::class, 'matching_id');
}
}
