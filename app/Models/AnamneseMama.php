<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnamneseMama extends Model
{
    protected $table = 'anamnese_sismama';
    protected $primaryKey = 'id_sismama';

    public $timestamps = false;

    protected $fillable = [
        'id_fato_anamnese',
        'nodulo_mama_direita',
        'nodulo_mama_esquerda',
        'risco_elevado_cancer',
        'mamas_examinadas_anteriormente',
        'fez_mamografia_anterior',
        'ano_ultima_mamografia',
        'fez_radioterapia_mama',
        'fez_cirurgia_mama',
        'tipo_mamografia',
        'achado_descarga_papilar_dir',
        'achado_descarga_papilar_esq',
        'achado_nodulo_localizacao_dir',
        'achado_nodulo_localizacao_esq',
        'achado_linfonodo_palpavel_dir',
        'achado_linfonodo_palpavel_esq',
    ];

    public function fatoAnamnese()
    {
        return $this->belongsTo(FatoAnamnese::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }
}