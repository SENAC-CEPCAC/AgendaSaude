<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnamneseColo extends Model
{
    protected $table = 'anamnese_siscolo';
    protected $primaryKey = 'id_siscolo';

    public $timestamps = false;

    protected $fillable = [
        'id_fato_anamnese',
        'motivo_exame',
        'fez_preventivo_anterior',
        'ano_ultimo_preventivo',
        'usa_diu',
        'esta_gravida',
        'usa_pilula',
        'usa_hormonio_menopausa',
        'ja_fez_radioterapia',
        'data_ultima_menstruacao',
        'sangramento_apos_relacao',
        'sangramento_apos_menopausa',
        'inspecao_colo',
        'sinais_dst',
    ];

    protected $casts = [
        'data_ultima_menstruacao' => 'date',
    ];

   
    public function fatoAnamnese()
    {
        return $this->belongsTo(FatoAnamnese::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }
}