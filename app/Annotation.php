<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Annotation extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    public function journeys()
    {
        return $this->morphedByMany(Journey::class, 'annotatable');
    }

    public function places()
    {
        return $this->morphedByMany(Place::class, 'annotatable');
    }



    public function getOpacityAttribute()
    {
        if (empty($this->options['opacity'])) {
            return 1;
        }

        return $this->options['opacity'];
    }

    public function getImageBoundsAttribute()
    {
        if (empty($this->options['imageBounds'])) {
            return [[0, 0], [20, 20]];
        }

        return $this->options['imageBounds'];
    }

    public function getVarnameAttribute() {
        return "annotation{$this->id}";
    }

    public function getUrlAttribute() {
        $url = Storage::disk('annotations')->url($this->upload_path);
        return $url;
    }
}
