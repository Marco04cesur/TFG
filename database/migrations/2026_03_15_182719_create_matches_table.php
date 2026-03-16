<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
    Schema::create('matches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('perro_id_1')->constrained('perros')->onDelete('cascade');
        $table->foreignId('perro_id_2')->constrained('perros')->onDelete('cascade');
        $table->enum('estado', ['pendiente', 'aceptado', 'rechazado', 'completado'])->default('pendiente');
        $table->boolean('compatible')->default(true);
        $table->timestamp('fecha_match')->useCurrent();
        $table->timestamps();
    });
}


};
