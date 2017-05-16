<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
        protected $fillable = [
        'idFrom', 'idTo', 'idSession', 'comment', 'mark'
    ];

    protected $hidden = [
        'remember_token'
    ];

    public function idUser(){
	    return $this->belongsTo(User::class);
	}

	public function idSession(){
	    return $this->belongsTo(Session::class);
	}

}
