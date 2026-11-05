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
            $table->integer('id_atendimento')->autoIncrement();

            $table->string('nm_tipo_atendimento', 50)->nullable();
            $table->date('dt_atendimento')->nullable();
            $table->decimal('vl_atendimento', 7, 2)->nullable();

            $table->integer('PET_id_pet');
            $table->integer('FUNCIONARIO_id_funcionario');

            $table->primary('id_atendimento');

            $table->foreign('PET_id_pet')->references('id_pet')->on('pet');

            $table->foreign('FUNCIONARIO_id_funcionario')->references('id_funcionario')->on('funcionario');
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
