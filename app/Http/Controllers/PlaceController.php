<?php

namespace App\Http\Controllers;

use App\Place;
use App\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use App\Http\Requests\StorePlace;


use Spatie\Tags\Tag;

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
        $places = Place::where('user_id', Auth::id())->get();
        return view('place.index', ['places' => $places]);
    }

    public function map()
    {
        $places = Place::where('user_id', Auth::id())->get();
        $categories =  UserCategory::where('user_id', Auth::id())->orderBy('order', 'ASC')->get();

        return view('place.map', [
            'places' => $places,
            'categories' => $categories,
        ]);
    }


    public function kml()
    {
        $places = Place::where('user_id', Auth::id())->get();
        $categories =  UserCategory::where('user_id', Auth::id())->orderBy('order', 'ASC')->get();

        return view('place.kml', [
            'places' => $places,
        ]);
    }

    public function geojson()
    {
        $places = Place::where('user_id', Auth::id())->get();
        $categories =  UserCategory::where('user_id', Auth::id())->orderBy('order', 'ASC')->get();

        return view('place.geojson', [
            'places' => $places,
        ]);
    }

    public function tags(Request $request)
    {
        $q = !empty($request->q) ? $request->q : '';
        $tags = Tag::containing($q)->get();
        $tag_names = [];

        foreach($tags as $tag) {
            $tag_names[] = $tag->name;
        }

        return response()->json($tag_names);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = UserCategory::where('user_id', Auth::id())->orderBy('order', 'ASC')->get();

        return view('place.create', [
            'categories' => $categories,
        ]);
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

        if (!empty($place->google_place_id)) {
            $place->google_place_id_date = date('Y-m-d');
        }

        $place->save();

        // media
        if ($request->hasFile('images')) {
            $fileAdders = $place
            ->addMultipleMediaFromRequest(['images'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('images');
            });
        }

        $tags = array_filter(array_map('trim', explode(',', $request->tags)));
        $place->syncTags($tags); // all other tags on this model will be detached
        $place->save();

        return redirect()->route('place.map', [
            'lat' => $place->location->latitude,
            'lng' => $place->location->longitude,
            'zoom' => 12
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        return view('place.show', [
            'place' => $place,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $categories = UserCategory::where('user_id', Auth::id())->get();

        return view('place.edit', [
            'place' => $place,
            'categories' => $categories,
        ]);
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
        $old_place_id = $place->google_place_id;
        $place->google_place_id = $request->google_place_id;
        $place->unesco_world_heritage = $request->unesco_world_heritage;

        if (empty($place->google_place_id)) {
            // has no id
            $place->google_place_id_date = null;
        } else if ($request->has('google_place_id_date')) {
            // user says it's valid
            $place->google_place_id_date = date('Y-m-d');
        } else if (!empty($place->google_place_id) && $old_place_id !== $place->google_place_id) {
            // user entered a new id
            $place->google_place_id_date = date('Y-m-d');
        }

        $place->save();

        // tags
        $tags = array_filter(array_map('trim', explode(',', $request->tags)));
        $place->syncTags($tags); // all other tags on this model will be detached
        $place->save();

        //$place->addMediaFromRequest('images')->toMediaCollection('media');

        // media
        if ($request->hasFile('images')) {
            $fileAdders = $place
            ->addMultipleMediaFromRequest(['images'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('images');
            });
        }

        // update existing images
        if ($request->media_images) {
            foreach($request->media_images as $row) {
                $mediaItem = Media::find($row['id']);

                // is this the thing we edited?
                if ($mediaItem->model_id != $place->id) {
                    continue;
                }

                if (isset($row['delete']) && $row['delete'] == '1') {
                    $mediaItem->delete();
                    continue;
                }
            }
        }


        return redirect()->route('place.map', [
            'lat' => $place->location->latitude,
            'lng' => $place->location->longitude,
            'zoom' => 12
        ]);
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
        return redirect()->route('place.index');
    }
}
