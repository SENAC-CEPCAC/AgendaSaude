<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * A tabela associada ao model.
     */
    protected $table = 'users';

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf_paciente',
    ];

    /**
     * Atributos ocultos na serialização.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relacionamento com o paciente.
     *
     * users.cpf_paciente
     *        ↓
     * dim_pacientes.cpf_paciente
     */
    public function paciente()
    {
        return $this->belongsTo(
            DimPaciente::class,
            'cpf_paciente',
            'cpf_paciente'
        );
    }

    /**
     * Atributos convertidos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
