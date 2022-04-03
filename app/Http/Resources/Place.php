<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Place extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'user_category_id' => $this->user_category_id,

            'location' => [
                'lat' => $this->location->latitude,
                'lng' => $this->location->longitude,
            ],

            'url' => $this->url,
            'wikipedia_url' => $this->wikipedia_url,
            'google_place_id' => $this->google_place_id,
            'unesco_world_heritage' => $this->unesco_world_heritage,
            'source' => $this->source,

            'tags' => $this->getTagsAsArray(),

            '_url' => route('place.show', [$this->id]),
        ];
    }
}
