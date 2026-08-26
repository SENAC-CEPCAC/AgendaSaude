<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatoAnamnese extends Model
{
    protected $table = 'fato_anamnese';
    protected $primaryKey = 'id_fato_anamnese';

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
     * Relação com a anamnese de mama
     */
    public function anamneseMama()
    {
        return $this->hasOne(AnamneseMama::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }

    /**
     * Relação com a anamnese de colo de útero
     */
    public function anamneseColo()
    {
        return $this->hasOne(AnamneseColo::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }

    /**
     * Relação com o prontuário
     */
    public function prontuario()
    {
        return $this->belongsTo(Prontuario::class, 'id_prontuario', 'id_prontuario');
    }
}
