<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
        // ID del match al que pertenece el mensaje
        $table->foreignId('matching_id')->constrained('matches')->onDelete('cascade');
        
        // ID del perro que envía el mensaje
        $table->foreignId('perro_emisor_id')->constrained('perros')->onDelete('cascade');
        
        // El texto del mensaje
        $table->text('contenido');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('mensajes', function (Blueprint $table) {
        $table->dropForeign(['matching_id']);
        $table->dropForeign(['perro_emisor_id']);
        $table->dropColumn(['matching_id', 'perro_emisor_id', 'contenido']);
    });
}
};
