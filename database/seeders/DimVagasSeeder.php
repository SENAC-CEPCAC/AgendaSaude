<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimVagasSeeder extends Seeder
{
    /**
     * Insere ou atualiza os tipos de exames/vagas (Siscolo / Sismama).
     */
    public function run(): void
    {
        $vagas = [
            ['id_vagas' => 1, 'tipo_exame' => 'Preventivo (Siscolo)'],
            ['id_vagas' => 2, 'tipo_exame' => 'Mamografia (Sismama)'],
        ];

        foreach ($vagas as $vaga) {
            DB::table('dim_vagas')->updateOrInsert(
                ['id_vagas' => $vaga['id_vagas']],
                [
                    'tipo_exame' => $vaga['tipo_exame'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
