<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
     protected $fillable = [
        'idUser', 'title'
    ];

    protected $hidden = [
        'remember_token'
    ];

    public function idUser(){
	    return $this->belongsTo(User::class);
	}

   public function getIdAttribute(){
      $hashids = new \Hashids\Hashids(env('APP_KEY'),8);
      return  $hashids->encode($this->attributes['id']);
   }
}
