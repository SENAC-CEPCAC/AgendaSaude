<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimTurnoSeeder extends Seeder
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. INSIRA OS TURNOS OPERACIONAIS DAS UNIDADES MÓVEIS (MANHÃ, TARDE, INTEGRAL).
     */
    public function run(): void
    {
        DB::table('dim_turno')->insert([
            ['id_turno' => 1, 'turno' => 'Manhã', 'created_at' => now()],
            ['id_turno' => 2, 'turno' => 'Tarde', 'created_at' => now()],
            ['id_turno' => 3, 'turno' => 'Integral', 'created_at' => now()],
        ]);
    }
}
