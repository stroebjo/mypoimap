<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;

class Visit extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $dates = [
        'visited_at',
    ];


    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 150, 75)
            ->optimize();

        $this->addMediaConversion('gallery')
            ->fit(Manipulations::FIT_CROP, 1200, 800)
            ->optimize();

    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function journey()
    {
        return $this->belongsTo('App\Journey');
    }
}
