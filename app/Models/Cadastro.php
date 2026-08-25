<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    protected $table = 'dim_pacientes';

    protected $primaryKey = 'cpf_paciente';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'cartao_sus',
        'cpf_paciente',
        'nome_completo',
        'nome_mae',
        'apelido',
        'data_nascimento',
        'sexo',
        'raca_cor',
        'escolaridade',
        'termo_lgpd_aceito',
        'data_cadastro',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_cadastro' => 'datetime',
        'termo_lgpd_aceito' => 'boolean',
    ];
}