<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users_colaboradores', function (Blueprint $table) {
            $table->string('nome')->after('id');
            $table->string('email')->unique()->after('nome');
            $table->string('password')->after('email');
            $table->string('matricula', 100)->after('password');
            $table->string('cidade')->after('matricula');
            $table->unsignedTinyInteger('permissao')->after('matricula');
            $table->boolean('ativo')->default(true)->after('permissao');
        });
    }

    public function down(): void
    {
        Schema::table('users_colaboradores', function (Blueprint $table) {
            $table->dropColumn([
                'nome',
                'email',
                'matricula',
                'cidade',
                'permissao',
                'password',                
                'ativo',
            ]);
        });
    }
};
