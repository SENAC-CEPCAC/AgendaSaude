<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'dim_pacientes';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_paciente';

    /**
     * Atributos preenchíveis em massa.
     */
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

    /**
     * Casts de tipos.
     */
    protected $casts = [
        'data_nascimento' => 'date',
        'termo_lgpd_aceito' => 'boolean',
        'data_cadastro' => 'datetime',
    ];

    /**
     * Relacionamento com os prontuários/agendamentos do paciente.
     */
    public function prontuarios()
    {
        return $this->hasMany(Prontuario::class, 'id_paciente', 'id_paciente');
    }

    /**
     * Relacionamento com o endereço do paciente.
     */
    public function endereco()
    {
        return $this->hasOne(EnderecoPaciente::class, 'id_paciente', 'id_paciente');
    }

    /**
     * Relacionamento com os telefones do paciente.
     */
    public function telefones()
    {
        return $this->hasMany(TelefonePaciente::class, 'id_paciente', 'id_paciente');
    }
}
