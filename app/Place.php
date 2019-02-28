<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Place extends Model
{
    use SpatialTrait;
    use \Spatie\Tags\HasTags;

    protected $spatialFields = [
        'location',
    ];

    public function user_category()
    {
        return $this->belongsTo('App\UserCategory');
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
