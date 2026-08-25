<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users_colaboradores', 'cidade')) {
            Schema::table('users_colaboradores', function (Blueprint $table) {
                $table->string('cidade')->nullable()->after('matricula');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users_colaboradores', 'cidade')) {
            Schema::table('users_colaboradores', function (Blueprint $table) {
                $table->dropColumn('cidade');
            });
        }
    }
};
