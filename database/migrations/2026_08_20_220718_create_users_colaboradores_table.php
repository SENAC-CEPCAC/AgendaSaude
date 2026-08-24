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
        Schema::create('users_colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('matricula', 30)->unique(); // Login do colaborador
            $table->string('nome', 150);
            $table->string('email', 100)->unique()->nullable();
            $table->string('password'); // Senha criptografada
            $table->unsignedTinyInteger('nivel')->default(2); // Nível de acesso (1: N1/Recepção, 2: Médico/Enfermeiro, 4: Admin)
            $table->string('cargo_funcao', 50)->nullable();
            $table->string('registro_profissional', 30)->nullable(); // CRM, COREN, etc.
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_colaboradores');
    }
};
