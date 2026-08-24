<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmModel extends Model
{
    protected $table = 'adms';

    protected $fillable = [
        'nome',
        'permissao',
        'email',
        'cidade',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }
}
