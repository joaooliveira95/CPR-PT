<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
        protected $fillable = [
        'idUser', 'idSession', 'comment'
    ];

    protected $hidden = [
        'remember_token'
    ];

}
