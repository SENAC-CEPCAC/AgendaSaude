<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnesUnidade extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'dim_cnes_unidades';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_cnes_unidade';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'codigo_cnes',
        'nome_unidade',
    ];

    /**
     * Relacionamento com os cronogramas da unidade.
     */
    public function cronogramas()
    {
        return $this->hasMany(Cronograma::class, 'id_cnes_unidade', 'id_cnes_unidade');
    }
}
