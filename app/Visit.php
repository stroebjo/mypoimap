<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $dates = [
        'visited_at',
    ];

    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function journey()
    {
        return $this->belongsTo('App\Journey');
    }
}
