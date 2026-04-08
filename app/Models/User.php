<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function perros() {
    return $this->hasMany(Perro::class, 'usuario_id');
}
}
