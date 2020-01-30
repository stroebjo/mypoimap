<?php

namespace App\Http\Controllers;

use App\Visit;
use App\Place;
use App\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Visit::class, 'visit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Allow visit only to own places
        $place = Place::findOrFail(request()->place_id);
        if ($place->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('visit.create', [
            'place' => $place,
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
        $visit = new Visit();
        $visit->user_id = Auth::id();
        $visit->visited_at = $request->visited_at;
        $visit->review = $request->review;
        $visit->rating = $request->rating;

        // Allow visit only to own places
        $place = Place::findOrFail($request->place_id);
        if ($place->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $visit->place_id = $place->id;

        // Allow visit only to own journey
        if ($request->journey_id) {
            $journey = Journey::findOrFail($request->journey_id);
            if ($journey->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $visit->journey_id = $journey->id;
        }

        $visit->save();

        if (!empty($journey)) {
            return redirect()->route('journey.show', ['journey' => $journey->id]);
        }

        return redirect()->route('place.show', ['place' => $place->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Visit $visit)
    {
        return view('visit.edit', [
            'visit' => $visit,
            'place' => $visit->place,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {
        $visit->visited_at = $request->visited_at;
        $visit->review = $request->review;
        $visit->rating = $request->rating;

        // Allow visit only to own journey
        if ($request->journey_id) {
            $journey = Journey::findOrFail($request->journey_id);
            if ($journey->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $visit->journey_id = $journey->id;
        } else {
            $visit->journey_id = null;
        }

        $visit->save();

        if (!empty($journey)) {
            return redirect()->route('journey.show', ['journey' => $journey->id]);
        }

        return redirect()->route('place.show', ['place' => $visit->place_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('place.index', []);
    }
}
