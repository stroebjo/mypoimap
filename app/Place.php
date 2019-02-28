<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;

class Place extends Model implements HasMedia
{
    use SpatialTrait;
    use \Spatie\Tags\HasTags;
    use HasMediaTrait;

    protected $spatialFields = [
        'location',
    ];

    public function user_category()
    {
        return $this->belongsTo('App\UserCategory');
    }


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 150, 75)
            ->optimize();

        $this->addMediaConversion('gallery')
            ->fit(Manipulations::FIT_CROP, 1200, 800)
            ->optimize();

    }


    public function getTagsAsString()
    {
        $tag_names = [];

        foreach($this->tags as $tag) {
            $tag_names[] = $tag->name;
        }

        return implode(', ', $tag_names);
    }

    public function getHTMLDescription()
    {
		$Parsedown = new \Parsedown();
		return $Parsedown->text($this->description);
    }

    public function getHTMLReview()
    {
		$Parsedown = new \Parsedown();
		return $Parsedown->text($this->visit_review);
    }

}
