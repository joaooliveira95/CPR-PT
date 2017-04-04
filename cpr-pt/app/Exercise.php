<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    
    protected $fillable = [
        'idSession', 'duracaoTotal', 'duracaoParcial', 'nmaosCorretas', 'nmaosIncorretas','ncompressoesCorretas', 'ncompressoesIncorretas', 'nrecoilCorreto', 'nrecoilIncorreto'
    ];

    protected $hidden = [
        'remember_token'
    ];
}
