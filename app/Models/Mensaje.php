<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
protected $fillable = 
['matching_id', 'perro_emisor_id', 'contenido'];

public function matching()
{
    return $this->belongsTo(Matching::class);
}

public function perroEmisor()
{
    // Relacionamos el mensaje con el perro que lo envió
    return $this->belongsTo(Perro::class, 'perro_emisor_id');
}
}
