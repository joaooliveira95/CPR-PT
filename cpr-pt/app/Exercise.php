<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{

    protected $fillable = [
        'idSession', 'time', 'recoil', 'compressions', 'hand_position'
    ];


    public function idSession(){
	    return $this->belongsTo(Session::class);
	}

/*   public function getIdAttribute(){
      $hashids = new \Hashids\Hashids(env('APP_KEY'),8);
      return  $hashids->encode($this->attributes['id']);
   }*/

}
