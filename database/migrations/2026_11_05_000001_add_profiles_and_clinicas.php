<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('perfil')->nullable();
        });
        Schema::create('clinicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('responsavel_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::table('funcionario', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->restrictOnDelete();
            $table->string('crmv')->nullable();
            $table->foreignId('clinica_id')->nullable()->constrained('clinicas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('funcionario', function (Blueprint $table) {
            $table->dropConstrainedForeignId('clinica_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('crmv');
        });
        Schema::dropIfExists('clinicas');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('perfil');
        });
    }
};
