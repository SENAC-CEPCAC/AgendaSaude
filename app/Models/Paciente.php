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
    protected $primaryKey = 'cpf_paciente';

    /**
     * Indica se os IDs são auto-incrementáveis.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * O tipo da chave primária.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'cpf_paciente',
        'cartao_sus',
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
     * Accessor para compatibilidade com $paciente->cpf.
     */
    public function getCpfAttribute(): ?string
    {
        return $this->attributes['cpf_paciente'] ?? null;
    }

    /**
     * Accessor para compatibilidade com $paciente->id_paciente.
     */
    public function getIdPacienteAttribute(): ?string
    {
        return $this->attributes['cpf_paciente'] ?? null;
    }

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
        return $this->hasMany(Prontuario::class, 'cpf_paciente', 'cpf_paciente');
    }

    /**
     * Relacionamento com o endereço do paciente.
     */
    public function endereco()
    {
        return $this->hasOne(EnderecoPaciente::class, 'cpf_paciente', 'cpf_paciente');
    }

    /**
     * Relacionamento com os telefones do paciente.
     */
    public function telefones()
    {
        return $this->hasMany(TelefonePaciente::class, 'cpf_paciente', 'cpf_paciente');
    }

     public function user(): HasOne
    {
        return $this->hasOne(
            User::class,
            'cpf_paciente',
            'cpf_paciente'
        );
    }
}
