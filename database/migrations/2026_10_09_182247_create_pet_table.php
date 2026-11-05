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
            $table->integer('id_pet')->autoIncrement();
            $table->string('nm_pet', 50)->nullable();
            $table->string('nm_especie_pet', 50)->nullable();
            $table->string('nm_raca_pet', 50)->nullable();
            $table->decimal('qt_peso_pet', 5, 2)->nullable();
            $table->integer('tutor_fk');
            $table->primary('id_pet');
            $table->foreign('tutor_fk')->references('id_tutor')->on('tutor');
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
