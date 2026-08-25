<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimPerfisAcessoSeeder extends Seeder
{
    /**
     * Insere ou atualiza os perfis padrão do sistema.
     */
    public function run(): void
    {
        $perfis = [
            ['id_perfil' => 1, 'nome_perfil' => 'Administrador', 'pode_ver_anamnese' => true],
            ['id_perfil' => 2, 'nome_perfil' => 'Médico', 'pode_ver_anamnese' => true],
            ['id_perfil' => 3, 'nome_perfil' => 'Enfermeiro', 'pode_ver_anamnese' => true],
            ['id_perfil' => 4, 'nome_perfil' => 'Atendente', 'pode_ver_anamnese' => false],
        ];

        foreach ($perfis as $perfil) {
            DB::table('dim_perfis_acesso')->updateOrInsert(
                ['id_perfil' => $perfil['id_perfil']],
                [
                    'nome_perfil' => $perfil['nome_perfil'],
                    'pode_ver_anamnese' => $perfil['pode_ver_anamnese'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
