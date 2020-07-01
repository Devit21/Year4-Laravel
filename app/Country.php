<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function posts(){
        return $this->hasManyThrough('App\Model\post', 'App\user');
    }
}
