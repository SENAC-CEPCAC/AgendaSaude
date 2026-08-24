<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao modelo.
     */
    protected $table = 'dim_turno';

    /**
     * Chave primária da tabela.
     */
    protected $primaryKey = 'id_turno';

    /**
     * Atributos preenchíveis em massa.
     */
    protected $fillable = [
        'turno',
    ];

    /**
     * Relacionamento com os cronogramas associados a este turno.
     */
    public function cronogramas()
    {
        return $this->hasMany(Cronograma::class, 'Turno_id_turno', 'id_turno');
    }
}
