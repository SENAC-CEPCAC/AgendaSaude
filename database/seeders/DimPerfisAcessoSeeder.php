<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimPerfisAcessoSeeder extends Seeder
{
    /**
     * PSEUDOCÓDIGO DE EXECUÇÃO:
     * 1. LIMPE OU INSIRA OS PERFIS PADRÃO DO SISTEMA.
     * 2. INSIRA 'Administrador' COM ACESSO TOTAL.
     * 3. INSIRA 'Enfermeiro' E 'Médico' COM ACESSO À ANAMNESE.
     * 4. INSIRA 'Atendente' SEM ACESSO À ANAMNESE.
     */
    public function run(): void
    {
        DB::table('dim_perfis_acesso')->insert([
            ['id_perfil' => 1, 'nome_perfil' => 'Administrador', 'pode_ver_anamnese' => true, 'created_at' => now()],
            ['id_perfil' => 2, 'nome_perfil' => 'Médico', 'pode_ver_anamnese' => true, 'created_at' => now()],
            ['id_perfil' => 3, 'nome_perfil' => 'Enfermeiro', 'pode_ver_anamnese' => true, 'created_at' => now()],
            ['id_perfil' => 4, 'nome_perfil' => 'Atendente', 'pode_ver_anamnese' => false, 'created_at' => now()],
        ]);
    }
}
