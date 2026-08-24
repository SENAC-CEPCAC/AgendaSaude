<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserColaborador extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tabela associada ao model.
     */
    protected $table = 'users_colaboradores';

    /**
     * Atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'matricula',
        'nome',
        'email',
        'password',
        'nivel',
        'cargo_funcao',
        'registro_profissional',
    ];

    /**
     * Atributos que devem ser ocultados para serialização.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de tipos de dados.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'nivel' => 'integer',
        ];
    }
}
