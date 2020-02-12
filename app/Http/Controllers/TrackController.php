<?php

namespace App\Http\Controllers;

use App\Track;
use App\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Track::class, 'track');
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
        $journey = Journey::findOrFail(request()->journey_id);

        if ($journey->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('track.create', [
            'journey' => $journey,
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
        // Allow visit only to own places
        $journey = Journey::findOrFail($request->journey_id);
        if ($journey->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $track = new Track();
        $track->user_id = Auth::id();
        $track->journey_id = $journey->id;

        $track->name = $request->name;
        $track->description = $request->description;
        $track->order = $request->order;

        $file = $request->file('file');

        $track->file_name = $file->getClientOriginalName();
        $track->file_extension = $file->getClientOriginalExtension();
        $track->mime_type = $file->getMimeType();
        $track->size = $file->getSize();

        $track->save();

        $directory = 'track/'.$track->id;

        $path = Storage::putFileAs(
            $directory, $file, $file->getClientOriginalName()
        );

        return redirect()->route('journey.show', ['journey' => $journey->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function show(Track $track)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track)
    {
        return view('track.edit', [
            'track' => $track,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Track $track)
    {
        $track->name = $request->name;
        $track->description = $request->description;
        $track->order = $request->order;

        $track->save();

        return redirect()->route('journey.show', ['journey' => $track->journey_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        $journey_id = $track->journey_id;

        $directory = 'track/'.$track->id.'/';
        Storage::deleteDirectory($directory);

        $track->delete();
        return redirect()->route('journey.show', [$journey_id]);

    }
}
