<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;

class Visit extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $casts = [
        'visited_at' => 'date',
    ];


    public function registerMediaConversions(Media $media = null) : void
    {
        // fixed size, smaller images would by resized to match
        $this->addMediaConversion('thumb')
            ->crop(150, 100)
            ->optimize();

        // max 1200x800 but will not upscale smaller images
        $this->addMediaConversion('gallery')
            ->fit(Fit::Max, 1200, 800)
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
