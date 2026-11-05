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
        Schema::create('tutor', function (Blueprint $table) {
        $table->integer('id_tutor')->autoIncrement();

        $table->string('nm_cliente', 50)->nullable();
        $table->string('nm_endereco_cliente', 50)->nullable();
        $table->char('cd_telefone_cliente', 11)->nullable();
        $table->char('cd_cpf_tutor', 11);

        $table->primary('id_tutor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor');
    }
};
