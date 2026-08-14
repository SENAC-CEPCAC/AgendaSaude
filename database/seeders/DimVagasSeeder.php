<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimVagasSeeder extends Seeder
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. INSIRA OS TIPOS DE EXAMES PADRÃO OFERECIDOS (SISCOLO / SISMAMA).
     */
    public function run(): void
    {
        DB::table('dim_vagas')->insert([
            ['id_vagas' => 1, 'tipo_exame' => 'Preventivo (Siscolo)', 'created_at' => now()],
            ['id_vagas' => 2, 'tipo_exame' => 'Mamografia (Sismama)', 'created_at' => now()],
        ]);
    }
}
