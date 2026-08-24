<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserColaborador extends Authenticatable
{
    protected $table = 'users_colaboradores';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'matricula',
        'cidade',
        'permissao',
        'ativo',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'permissao' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    public function getNivelAttribute(): int
    {
        return (int) $this->permissao;
    }
}
