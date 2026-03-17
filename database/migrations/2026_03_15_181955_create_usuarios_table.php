<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->string('email', 100)->unique();
        $table->string('contraseña', 255);
        $table->string('teléfono', 20)->nullable();
        $table->string('ciudad', 100)->nullable();
        $table->decimal('latitud', 10, 8)->nullable();
        $table->decimal('longitud', 11, 8)->nullable();
        $table->boolean('verificado')->default(false);
        $table->float('calificación')->default(0);
        $table->timestamps();
    });
}
};
