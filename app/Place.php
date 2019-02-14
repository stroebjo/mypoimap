<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Place extends Model
{
    use SpatialTrait;

    protected $spatialFields = [
        'location',
    ];

    public function getHTMLDescription()
    {
		$Parsedown = new \Parsedown();
		return $Parsedown->text($this->description);
    }
}
