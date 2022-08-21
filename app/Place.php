<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;

class Place extends Model implements HasMedia
{
    use \Spatie\Tags\HasTags;
    use InteractsWithMedia;

    protected $fillable = [
        'location',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'google_place_id_date' => 'datetime:Y-m-d',
        'location' => Point::class,
    ];

    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    public function user_category()
    {
        return $this->belongsTo('App\UserCategory');
    }

    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }


    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 150, 100)
            ->optimize();

        $this->addMediaConversion('gallery')
            ->fit(Manipulations::FIT_MAX, 1200, 800)
            ->optimize();

    }

    public function isVisited()
    {
        return $this->visits()->count() > 0;
    }

    public function getTagsAsArray()
    {
        $tag_names = [];

        foreach($this->tags as $tag) {
            $tag_names[] = $tag->name;
        }

        return $tag_names;
    }

    public function getTagsAsString()
    {
        return implode(', ', $this->getTagsAsArray());
    }

    /**
     * Prints lat/lng with given glue.
     *
     * @param string $glue - string to combine lat/lng
     * @param null|int $decimals - if not null lat/lng will be rounded to $decimal places
     * @return string
     */
    public function getLatLng($glue = ', ', $decimals = null)
    {
        $lat = $this->location->latitude;
        $lng = $this->location->longitude;

        if (!is_null($decimals)) {
            $lat = number_format($lat, $decimals);
            $lng = number_format($lng, $decimals);
        }

        return sprintf('%s%s%s', $lat, $glue, $lng);
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

    public static function fetchGooglePlaceIdStatus($places)
    {
        $place_url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=%s&fields=place_id&key=%s';
        $key = env('GOOGLE_MAPS_API_KEY');

        $results = [];

        foreach($places as $place) {

            if (is_null($place->google_place_id)) {
                continue;
            }

            $place_id = $place->google_place_id;
            $url = sprintf($place_url, $place_id, $key);

            $error_message = null;
            $status = null;

            $ch = curl_init();
            // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
            // in most cases, you should set it to true
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_message = curl_error($ch);
                $status = 'CURL_ERROR';
            }
            curl_close($ch);

            if (is_null($status)) {
                $response = json_decode($result);

                if ($response->status == 'OK') {
                    $place->google_place_id_date = date('Y-m-d');
                    $place->save();
                    $status = $response->status;
                } else {
                    $status = $response->status;

                    if (property_exists($response, 'error_message')) {
                        $error_message = $response->error_message;
                    }
                }
            }

            $results[] = (object) [
                'place' => $place,
                'status' => $status,
                'error_message' => $error_message
            ];
        }

        return $results;
    }
}

