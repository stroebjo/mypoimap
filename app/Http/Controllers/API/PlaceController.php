<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Place;
use Illuminate\Support\Facades\Auth;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\PlaceCollection;

use App\Http\Requests\StorePlace;

class PlaceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Place::class, 'place');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PlaceCollection(Place::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlace $request)
    {
        $place = new Place();

        $place->user_id = Auth::id();
        $place->user_category_id = $request->user_category_id;
        $place->title = $request->title;
        $place->url = $request->url;
        $place->wikipedia_url = $request->wikipedia_url;
        $place->priority = $request->priority;
        $place->description = $request->description;

        $place->location = new Point($request->lat, $request->lng);	// (lat, lng)
        $place->google_place_id = $request->google_place_id;
        $place->unesco_world_heritage = $request->unesco_world_heritage;

        $place->save();

        $tags = array_filter(array_map('trim', explode(',', $request->tags)));
        $place->syncTags($tags); // all other tags on this model will be detached
        $place->save();

        return new PlaceResource($place);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        $place->title = $request->title;
        $place->user_category_id = $request->user_category_id;
        $place->url = $request->url;
        $place->wikipedia_url = $request->wikipedia_url;
        $place->priority = $request->priority;
        $place->description = $request->description;

        $place->location = new Point($request->lat, $request->lng);	// (lat, lng)
        $place->google_place_id = $request->google_place_id;
        $place->unesco_world_heritage = $request->unesco_world_heritage;

        $place->save();

        // tags
        $tags = array_filter(array_map('trim', explode(',', $request->tags)));
        $place->syncTags($tags); // all other tags on this model will be detached
        $place->save();

        return response()->json(null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json(null);
    }
}
