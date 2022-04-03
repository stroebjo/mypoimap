<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;

use phpGPX\Models\GpxFile;
use phpGPX\Models\Link;
use phpGPX\Models\Person;
use phpGPX\Models\Metadata;
use phpGPX\Models\Point as GpxPoint;

class Journey extends Model
{

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start',
        'end',
    ];

    protected $casts = [
        'origin' => Point::class,
    ];

    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }

    public function journey_entries()
    {
        return $this->hasMany('App\JourneyEntry');
    }

    public function tracks()
    {
        return $this->hasMany('App\Track')->orderBy('order', 'ASC');
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

    /**
     * Return a filename WITHOUT extension derived from the title.
     *
     * @return string
     */
    public function getFileName()
    {
        return preg_replace('/[^a-z0-9]+/', '-', strtolower($this->title));
    }

    /**
     * Generate .gpx file with all POIs in the given journey as waypoint.
     *
     * WikiVoyage has the same for it's articles!
     *
     * @return \phpGPX\Models\GpxFile
     */
    public function getGtx()
    {
        $link       = new Link();
        $link->href = route('journey.show', $this);
        $link->text = $this->title;

        $person = new Person();
        $person->name = config('app.name');
        $person->links[] = $link;

        $gpx_file = new GpxFile();

        $gpx_file->metadata = new Metadata();
        $gpx_file->metadata->time = new \DateTime();
        $gpx_file->metadata->name = $this->title;
        $gpx_file->metadata->description = $this->description;
        $gpx_file->metadata->author = $person;

        foreach($this->getAllPOIsInArea() as $place) {
            $point = new GpxPoint(GpxPoint::WAYPOINT);

            $point->name = $place->title;
            $point->description = $place->description;

            if ($place->url) {
                $link = new Link();
                $link->text = 'Website';
                $link->href = $place->url;
                $point->links[] = $link;
            }

            if ($place->wikipedia_url) {
                $link = new Link();
                $link->text = 'Wikipedia';
                $link->href = $place->wikipedia_url;
                $point->links[] = $link;
            }

            if ($place->unesco_world_heritage) {
                $link = new Link();
                $link->text = 'UNESCO';
                $link->href = $place->unesco_world_heritage_link;
                $point->links[] = $link;
            }

            $point->latitude  = $place->location->latitude;
	        $point->longitude = $place->location->longitude;

            $gpx_file->waypoints[] = $point;
        }

        return $gpx_file;
    }
}
