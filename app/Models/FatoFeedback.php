<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FatoFeedback extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao model.
     */
    protected $table = 'fato_feedback';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_feedback';

    /**
     * Timestamps gerenciados pelo Laravel.
     */
    public $timestamps = true;

    /**
     * Campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'fato_prontuario_id_prontuario',
        'avaliacao',
        'tempo_espera',
        'atendimento_equipe',
        'clareza_informacoes',
        'facilidade_agendamento',
        'comentario',
    ];

    /**
     * Casts de tipos de dados.
     */
    protected $casts = [
        'avaliacao' => 'integer',
    ];

    /**
     * Relacionamento: cada feedback pertence a um prontuário.
     */
    public function prontuario()
    {
        return $this->belongsTo(Prontuario::class, 'fato_prontuario_id_prontuario', 'id_prontuario');
    }
}
