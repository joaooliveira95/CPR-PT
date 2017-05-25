<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurmaAluno extends Model
{
     protected $fillable = [
        'idUser', 'idTurma'
    ];

    public function idUser(){
	    return $this->belongsTo(User::class);
	}

	public function idTurma(){
	    return $this->belongsTo(Turma::class);
	}
}
