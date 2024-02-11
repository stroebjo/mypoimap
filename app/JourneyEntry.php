<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JourneyEntry extends Model
{

    protected $casts = [
        'date' => 'date',
    ];

    public function journey()
    {
        return $this->belongsTo('App\Journey');
    }
}
