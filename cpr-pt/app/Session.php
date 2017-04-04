<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
     protected $fillable = [
        'idUser'
    ];

    protected $hidden = [
        'remember_token'
    ];
}
