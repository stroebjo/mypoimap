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

    public function getLatLng($seperator = ', ')
    {
        return sprintf('%s%s%s', $this->location->getLat(), $seperator, $this->location->getLng());
    }

    /**
     * Create Google Maps Details link (lat, lng + palce id).
     *
     * @see https://developers.google.com/maps/documentation/urls/guide
     * @return string
     */
    public function getGoogleMapsDetailsLinkAttribute()
    {
        $query = [
            'api'   => 1,
            'query' => $this->getLatLng(','),
        ];

        if (!is_null($this->google_place_id)) {
            $query['query_place_id'] = $this->google_place_id;
        }

        return 'https://www.google.com/maps/search/?' . http_build_query($query);
    }
    public function getGoogleMapsDirectionsLinkAttribute()
    {
        $query = [
            'api'         => 1,
            'destination' => $this->getLatLng(','),
        ];

        if (!is_null($this->google_place_id)) {
            $query['destination_place_id'] = $this->google_place_id;
        }

        return 'https://www.google.com/maps/dir/?' . http_build_query($query);
    }

    public function getunescoWorldHeritageLinkAttribute()
    {
        return 'https://whc.unesco.org/en/list/' . $this->unesco_world_heritage;
    }


    /**
     * Create geo URI scheme
     *
     * @see https://en.wikipedia.org/wiki/Geo_URI_scheme
     * @return string
     */
    public function getGeoUriAttribute()
    {
        return 'geo:' . $this->getLatLng(',');
    }
}
