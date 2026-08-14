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
     * A tabela não possui created_at / updated_at.
     * Se você adicionar essas colunas na tabela, mude para true.
     */
    public $timestamps = false;

    /**
     * Campos que podem ser preenchidos em massa (mass assignment).
     */
    protected $fillable = [
        'avaliacao',
        'tempo_espera',
        'atendimento_equipe',
        'clareza_informacoes',
        'facilidade_agendamento',
        'comentario',
        'id_prontuario_id_prontuario',
    ];

    /**
     * Casts de tipos de dados.
     */
    protected $casts = [
        'avaliacao' => 'integer',
    ];

    /**
     * Relacionamento: cada feedback pertence a um prontuário.
     * Ajuste o nome do model 'Prontuario' e da chave se necessário.
     */
    public function prontuario()
    {
        return $this->belongsTo(Prontuario::class, 'id_prontuario_id_prontuario', 'id_prontuario');
    }
}