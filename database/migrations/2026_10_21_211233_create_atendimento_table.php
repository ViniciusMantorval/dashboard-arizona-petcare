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
        Schema::create('atendimento', function (Blueprint $table) {
            $table->id("atendimento_id");
            $table->foreignId('id_funcionario')->constrained('funcionario','id_funcionario');
            $table->foreignId('id_pet')->constrained('pet','id_pet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimento');
    }
};
