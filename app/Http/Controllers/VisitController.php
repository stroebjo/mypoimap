<?php

namespace App\Http\Controllers;

use App\Visit;
use App\Place;
use App\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

        $journeys = Journey::where('user_id', Auth::id())->get();

        return view('visit.create', [
            'place' => $place,
            'journeys' => $journeys,
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

        // media
        if ($request->hasFile('images')) {
            $fileAdders = $visit
            ->addMultipleMediaFromRequest(['images'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('images');
            });
        }


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
        $journeys = Journey::where('user_id', Auth::id())->get();

        return view('visit.edit', [
            'visit' => $visit,
            'place' => $visit->place,
            'journeys' => $journeys,
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

        // media
        if ($request->hasFile('images')) {
            $fileAdders = $visit
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
                if ($mediaItem->model_id != $visit->id) {
                    continue;
                }

                if (isset($row['delete']) && $row['delete'] == '1') {
                    $mediaItem->delete();
                    continue;
                }
            }
        }

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
        $place_id = $visit->place_id;
        $visit->delete();
        return redirect()->route('place.show', [$place_id]);
    }
}
