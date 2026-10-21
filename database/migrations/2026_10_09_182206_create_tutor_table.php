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
            $table->id('id_tutor');
            $table->string('nm_tutor');
            $table->string('nm_endereco_tutor');
            $table->string('nm_email_tutor');
            $table->char('cd_telefone_tutor',11);
            $table->char('cd_cpf_tutor',11);
            $table->timestamps();
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
