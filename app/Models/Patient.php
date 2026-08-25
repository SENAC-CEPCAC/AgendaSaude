<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'dim_pacientes';

    protected $primaryKey = 'id_paciente';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'cartao_sus',
        'cpf',
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