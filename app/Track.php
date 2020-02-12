<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Track extends Model
{

    public function journey()
    {
        return $this->belongsTo('App\Journey');
    }

    public function getContentAttribute()
    {
        return Storage::get('track/'.$this->id.'/'.$this->file_name);
    }
}
