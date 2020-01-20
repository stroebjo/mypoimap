<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JourneyEntry extends Model
{

    protected $dates = [
        'date',
    ];

    public function journey()
    {
        return $this->belongsTo('App\Journey');
    }
}
