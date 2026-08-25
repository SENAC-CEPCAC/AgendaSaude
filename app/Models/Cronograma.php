<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'fato_cronogramas';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_agenda';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'id_cnes_unidade',
        'Vagas_id_vagas',
        'Turno_id_turno',
        'data_atendimento',
        'municipio_atendimento',
        'qnt_oferecidas_vagas',
        'prenchida_vagas',
    ];

    /**
     * Casts de tipos.
     */
    protected $casts = [
        'data_atendimento' => 'date',
        'qnt_oferecidas_vagas' => 'integer',
        'prenchida_vagas' => 'integer',
    ];

    /**
     * Relacionamento com a Unidade Móvel (CNES).
     */
    public function unidade()
    {
        return $this->belongsTo(CnesUnidade::class, 'id_cnes_unidade', 'id_cnes_unidade');
    }

    /**
     * Relacionamento com o Tipo de Vaga / Exame (Siscolo, Sismama).
     */
    public function vaga()
    {
        return $this->belongsTo(Vaga::class, 'Vagas_id_vagas', 'id_vagas');
    }

    /**
     * Relacionamento com o Turno (Manhã, Tarde, Integral).
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'Turno_id_turno', 'id_turno');
    }

    /**
     * Relacionamento com os prontuários agendados neste cronograma.
     */
    public function prontuarios()
    {
        return $this->hasMany(Prontuario::class, 'id_agenda', 'id_agenda');
    }

    /**
     * Verifica se ainda há vagas disponíveis no cronograma.
     */
    public function getTemVagasAttribute(): bool
    {
        return $this->prenchida_vagas < $this->qnt_oferecidas_vagas;
    }

    /**
     * Retorna a quantidade de vagas restantes.
     */
    public function getVagasRestantesAttribute(): int
    {
        $restantes = $this->qnt_oferecidas_vagas - $this->prenchida_vagas;
        return max(0, $restantes);
    }
}
