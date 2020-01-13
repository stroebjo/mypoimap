<?php

namespace App\Http\Controllers;

use App\Place;
use App\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Grimzy\LaravelMysqlSpatial\Types\Point;

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
    public function store(Request $request)
    {
        $place = new Place();

        $place->user_id = Auth::id();
        $place->user_category_id = $request->user_category_id;
        $place->title = $request->title;
        $place->url = $request->url;
        $place->priority = $request->priority;
        $place->description = $request->description;

        $place->location = new Point($request->lat, $request->lng);	// (lat, lng)
        $place->google_place_id = $request->google_place_id;
        $place->unesco_world_heritage = $request->unesco_world_heritage;

        $place->save();

        $tags = array_filter(array_map('trim', explode(',', $request->tags)));
        $place->syncTags($tags); // all other tags on this model will be detached
        $place->save();

        return redirect()->route('place.map', [
            'lat' => $place->location->getLat(),
            'lng' => $place->location->getLng(),
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
        //
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
        $place->priority = $request->priority;
        $place->description = $request->description;

        $place->location = new Point($request->lat, $request->lng);	// (lat, lng)
        $place->google_place_id = $request->google_place_id;
        $place->unesco_world_heritage = $request->unesco_world_heritage;

        $place->visited_at = $request->visited_at;
        $place->visit_review = $request->visit_review;

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

        return redirect()->route('place.map', [
            'lat' => $place->location->getLat(),
            'lng' => $place->location->getLng(),
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
        return redirect()->route('place.table');
    }
}
