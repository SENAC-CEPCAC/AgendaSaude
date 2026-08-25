<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoPaciente extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'dim_enderecos_pacientes';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_endereco';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'cpf_paciente',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'municipio',
        'uf',
        'cep',
        'ponto_referencia',
    ];

    /**
     * Relacionamento com o paciente.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'cpf_paciente', 'cpf_paciente');
    }
}
