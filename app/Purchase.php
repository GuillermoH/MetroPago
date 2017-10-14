<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function store(){
        return $this->belongsTo('App\User');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
