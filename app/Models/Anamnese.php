<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatoAnamnese extends Model
{
    protected $table = 'fato_anamnese';       // ajuste se o nome real for diferente
    protected $primaryKey = 'id_fato_anamnese';

    // essa tabela tem timestamp próprio (criado_em), não os padrões do Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_prontuario',
        'id_profissional',
        'tipo_anamnese',
        'data_realizacao',
        'criado_em',
    ];

    protected $casts = [
        'data_realizacao' => 'date',
        'criado_em' => 'datetime',
    ];

    /**
     * Relação: uma anamnese "fato" pode ter uma anamnese de mama associada
     */
    public function anamneseMama()
    {
        return $this->hasOne(AnamneseMama::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }

    /**
     * Relação: uma anamnese "fato" pode ter uma anamnese de colo associada
     */
    public function anamneseColo()
    {
        return $this->hasOne(AnamneseColo::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }
}