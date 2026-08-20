<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonePaciente extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'dim_telefones_paciente';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_telefone';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'cpf_paciente',
        'numero',
        'tipo',
    ];

    /**
     * Relacionamento com o paciente.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'cpf_paciente', 'cpf_paciente');
    }
}
