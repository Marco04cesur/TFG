<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
    Schema::create('perros', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
        $table->string('nombre', 100);
        $table->string('raza', 100);
        $table->enum('sexo', ['M', 'H']);
        $table->integer('edad');
        $table->decimal('peso', 5, 2)->nullable();
        $table->string('color', 100)->nullable();
        $table->boolean('pedigree')->default(false);
        $table->string('foto_url', 255)->nullable();
        $table->text('descripción')->nullable();
        $table->boolean('disponible')->default(true);
        $table->timestamps();
    });
}
};