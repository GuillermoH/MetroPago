<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uid extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}
