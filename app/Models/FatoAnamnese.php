<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatoAnamnese extends Model
{
    protected $table = 'fato_anamnese';
    protected $primaryKey = 'id_fato_anamnese';

<<<<<<< HEAD
    public $timestamps = false;

=======
>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c
    protected $fillable = [
        'id_prontuario',
        'id_profissional',
        'tipo_anamnese',
        'data_realizacao',
<<<<<<< HEAD
        'criado_em',
=======
>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c
    ];

    protected $casts = [
        'data_realizacao' => 'date',
<<<<<<< HEAD
        'criado_em' => 'datetime',
    ];

    /**
     * Relação com a anamnese de mama
     */
=======
    ];

>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c
    public function anamneseMama()
    {
        return $this->hasOne(AnamneseMama::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }

<<<<<<< HEAD
    /**
     * Relação com a anamnese de colo de útero
     */
=======
>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c
    public function anamneseColo()
    {
        return $this->hasOne(AnamneseColo::class, 'id_fato_anamnese', 'id_fato_anamnese');
    }

<<<<<<< HEAD
    /**
     * Relação com o prontuário
     */
=======
>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c
    public function prontuario()
    {
        return $this->belongsTo(Prontuario::class, 'id_prontuario', 'id_prontuario');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 3f2461e4e166b0d76aa9cee9f8b393e50fb72e9c
