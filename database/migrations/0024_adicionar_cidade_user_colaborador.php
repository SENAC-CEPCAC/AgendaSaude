<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        Schema::table('users_colaboradores', function (Blueprint $table) {
            $table->dropColumn('cidade');
        });
    }
    public function up(): void
    {
        Schema::table('dim_pacientes', function (Blueprint $table) {
            $table->string('cartao_sus', 18)->nullable()->change();
        });
    }

<<<<<<<< HEAD:database/migrations/0016_alter_cartao_sus_to_18_digits.php
    public function down(): void
    {
        Schema::table('dim_pacientes', function (Blueprint $table) {
            $table->string('cartao_sus', 15)->nullable()->change();
        });
    }
};
========
};
>>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c:database/migrations/0024_adicionar_cidade_user_colaborador.php
