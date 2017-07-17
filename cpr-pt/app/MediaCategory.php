<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{

    protected $fillable = [
        'name', 'description'
    ];
}
