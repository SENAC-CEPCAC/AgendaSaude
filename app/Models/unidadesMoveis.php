<?php
// app/Models/CnesUnidade.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CnesUnidade extends Model
{
    use HasFactory;

    // Nome da tabela (o Laravel, por padrão, tentaria adivinhar "cnes_unidades",
    // então precisamos informar o nome real usado na migration).
    protected $table = 'dim_cnes_unidades';

    // A migration usa 'id_cnes_unidade' em vez do padrão 'id',
    // então é obrigatório declarar isso aqui.
    protected $primaryKey = 'id_cnes_unidade';

    // increments() gera um inteiro autoincrementável comum (não é UUID nem string)
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'codigo_cnes',
        'nome_unidade',
    ];

    /**
     * Scope de busca por código CNES ou nome da unidade.
     * Uso: CnesUnidade::buscar('123')->get();
     */
    public function scopeBuscar(Builder $query, ?string $termo): Builder
    {
        if (! $termo) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($termo) {
            $q->where('codigo_cnes', 'like', "%{$termo}%")
              ->orWhere('nome_unidade', 'like', "%{$termo}%");
        });
    }
}