<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    
    protected $fillable = [
        'idSession', 'time', 'recoil', 'compressions', 'hand_position'
    ];

    protected $hidden = [
        'remember_token'
    ];

    public function idSession(){
	    return $this->belongsTo(Session::class);
	}
}
