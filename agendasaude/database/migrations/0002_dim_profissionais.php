<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. CRIE A TABELA 'dim_profissionais'.
     * 2. DEFINA 'id_profissional' COMO CHAVE PRIMÁRIA (INT).
     * 3. VINCULE A CHAVE ESTRANGEIRA 'id_perfil' COM 'dim_perfis_acesso'.
     * 4. ADICIONE 'nome' (VARCHAR 150), 'registro_profissional' (VARCHAR 30), 'cargo_funcao' (VARCHAR 50) E 'email_corporativo' (VARCHAR 100).
     */
    public function up(): void
    {
        Schema::create('dim_profissionais', function (Blueprint $table) {

            $table->increments('id_profissional');
            
            $table->unsignedInteger('id_perfil');

            $table->foreign('id_perfil')
                    ->references('id_perfil')
                    ->on('dim_perfis_acesso')
                    ->onDelete('cascade');
            // DADOS PESSOais
            $table->string('nome', 150);
            $table->string('registro_profissional', 30)->nullable();
            $table->string('cargo_funcao', 50);
            $table->string('email_corporativo', 100)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_profissionais');
    }
};
