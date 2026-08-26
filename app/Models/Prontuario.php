<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prontuario extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'fato_prontuario';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_prontuario';

    /**
     * Atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'cpf_paciente',
        'id_agenda',
        'horario_agendamento',
        'status_comparecimento',
        'status_agendamento',
        'status_documentos',
        'numero_sequencial',
        'caminho_documento_rg_cpf',
        'caminho_documento_requisicao',
        'status_documento',
        'motivo_rejeicao_documento',
    ];

    /**
     * Relacionamento com o paciente associado.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'cpf_paciente', 'cpf_paciente');
    }

    /**
     * Relacionamento com o cronograma da unidade móvel.
     */
    public function cronograma()
    {
        return $this->belongsTo(Cronograma::class, 'id_agenda', 'id_agenda');
    }

    /**
     * Relacionamento com a anamnese realizada (se houver).
     */
    public function anamnese()
    {
        return $this->hasOne(FatoAnamnese::class, 'id_prontuario', 'id_prontuario');
    }

    /**
     * Relacionamento com a pesquisa de satisfação/feedback.
     */
    public function feedback()
    {
        return $this->hasOne(FatoFeedback::class, 'fato_prontuario_id_prontuario', 'id_prontuario');
    }
}
