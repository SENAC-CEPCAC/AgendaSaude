<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimTurnoSeeder extends Seeder
{
    /**
     * Insere ou atualiza os turnos de atendimento.
     */
    public function run(): void
    {
        $turnos = [
            ['id_turno' => 1, 'turno' => 'Manhã'],
            ['id_turno' => 2, 'turno' => 'Tarde'],
            ['id_turno' => 3, 'turno' => 'Integral'],
        ];

        foreach ($turnos as $turno) {
            DB::table('dim_turno')->updateOrInsert(
                ['id_turno' => $turno['id_turno']],
                [
                    'turno' => $turno['turno'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
