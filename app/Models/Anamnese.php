<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatoAnamnese extends Model
{
    protected $table = 'fato_anamnese';
    protected $primaryKey = 'id_fato_anamnese';

    protected $fillable = [
        'id_prontuario',
        'id_profissional',
        'tipo_anamnese',
        'data_realizacao',
    ];

    protected $casts = [
        'data_realizacao' => 'date',
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

    /**
     * Relação: o prontuário ao qual essa anamnese pertence
     */
    public function prontuario()
    {
        return $this->belongsTo(Prontuario::class, 'id_prontuario', 'id_prontuario');
    }
}