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
        
        Schema::create('pet', function (Blueprint $table) {
            $table->id('id_pet');
            $table->string('nm_pet');
            $table->string('nm_especie_pet');
            $table->string('nm_raca_pet');
            $table->float('qt_peso_pet');
            $table->foreignId('id_tutor')->constrained('tutor','id_tutor','id_tutor_fk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet');
    }
};
