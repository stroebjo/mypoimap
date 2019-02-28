<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{

    public function places()
    {
        return $this->hasMany('App\Place');
    }
}
