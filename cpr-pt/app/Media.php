<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $fillable = [
        'title', 'idCategory', 'url', 'type'
    ];

    public function idCategory(){
	    return $this->belongsTo(MediaCategory::class);
	}
}
