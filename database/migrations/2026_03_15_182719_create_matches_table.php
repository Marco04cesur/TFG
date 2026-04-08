<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
    Schema::create('matches', function (Blueprint $table) {
        $table->id();
        // El perro que da el "like"
        $table->foreignId('perro_id_1')->constrained('perros')->onDelete('cascade');
        // El perro que recibe el "like"
        $table->foreignId('perro_id_2')->constrained('perros')->onDelete('cascade');
        // Estado: 'pendiente' (uno dio like) o 'aceptado' (los dos dieron like)
        $table->enum('estado', ['pendiente', 'aceptado', 'rechazado', 'completado'])->default('pendiente');
        $table->boolean('compatible')->default(true);
        $table->timestamp('fecha_match')->useCurrent();
        $table->timestamps();
    });
}


};
