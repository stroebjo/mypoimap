<?php

namespace App\Http\Controllers;

use App\Place;
use App\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::where('user_id', Auth::id())->get();
        return view('place.table', ['places' => $places]);
    }

    public function map()
    {
        $places = Place::where('user_id', Auth::id())->get();
        $categories = UserCategory::where('user_id', Auth::id())->get();

        return view('place.map', [
            'places' => $places,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = UserCategory::where('user_id', Auth::id())->get();

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
        $p = new Place();

        $p->user_id = Auth::id();
        $p->title = $request->title;
        $p->url = $request->url;
        $p->priority = $request->priority;
        $p->description = $request->description;
        $p->location = new Point($request->lat, $request->lng);	// (lat, lng)

        $p->save();

        $tags = array_map('trim', explode(',', $request->tags));
        $p->syncTags($tags); // all other tags on this model will be detached
        $p->save();

        return redirect('/');
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
        if ($place->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $place->title = $request->title;
        $place->url = $request->url;
        $place->priority = $request->priority;
        $place->description = $request->description;
        $place->location = new Point($request->lat, $request->lng);	// (lat, lng)

        $place->visited_at = $request->visited_at;
        $place->visit_review = $request->visit_review;

        $place->save();

        $tags = array_filter(array_map('trim', explode(',', $request->tags)));
        $place->syncTags($tags); // all other tags on this model will be detached
        $place->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
