<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'sobrenome')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('sobrenome')->nullable()->after('name');
            });
        }

        if (! Schema::hasColumn('users', 'cpf')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('cpf', 14)->nullable()->unique()->after('sobrenome');
            });
        }

        if (! Schema::hasColumn('users', 'telefone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('telefone', 20)->nullable()->after('cpf');
            });
        }

        if (! Schema::hasColumn('users', 'nivel')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('nivel')->default(1)->after('telefone');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'cpf')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['cpf']);
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $columns = array_filter(['sobrenome', 'cpf', 'telefone', 'nivel'], fn ($column) => Schema::hasColumn('users', $column));
            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
