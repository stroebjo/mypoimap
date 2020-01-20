<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


class Journey extends Model
{
    use SpatialTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start',
        'end',
    ];

    protected $spatialFields = [
        'origin',
    ];


    public function journey_entries()
    {
        return $this->hasMany('App\JourneyEntry');
    }

    public function getNightsAttribute()
    {
        return $this->start->diffInDays($this->end);
    }

    /**
     * Get all available POIs for this journey.
     *
     * @todo: reuse Filters?
     *
     */
    public function getAllPOIsInArea()
    {
        if (empty($this->area)) {
            return [];
        }

        $query = Place::query();
        $query->where('user_id', '=', $this->user_id);
        $query->whereRaw('ST_WITHIN(location, ST_GeomFromText(?))', [$this->area]);

        return $query->get();
    }
}
