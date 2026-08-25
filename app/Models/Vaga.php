<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'dim_vagas';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_vagas';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'tipo_exame',
    ];

    /**
     * Relacionamento com os cronogramas desse tipo de exame.
     */
    public function cronogramas()
    {
        return $this->hasMany(Cronograma::class, 'Vagas_id_vagas', 'id_vagas');
    }
}
