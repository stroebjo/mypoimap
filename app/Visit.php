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
        // fixed size, smaller images would by resized to match
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 150, 100)
            ->optimize();

        // max 1200x800 but will nut upscale smaller images
        $this->addMediaConversion('gallery')
            ->fit(Manipulations::FIT_MAX, 1200, 800)
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
