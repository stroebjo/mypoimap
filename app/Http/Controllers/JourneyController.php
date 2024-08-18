<?php

namespace App\Http\Controllers;

use App\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;

class JourneyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Journey::class, 'journey');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journeys = Journey::where('user_id', Auth::id())->orderBy('start', 'desc')->get();
        return view('journey.index', ['journeys' => $journeys]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('journey.create', [
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
        $journey = new Journey();

        $journey->user_id = Auth::id();
        $journey->title = $request->title;
        $journey->description = $request->description;
        $journey->start = $request->start;
        $journey->end   = $request->end;
        $journey->area = $request->area;

        if ($request->lat && $request->lng) {
            $journey->origin = new Point($request->lat, $request->lng);	// (lat, lng)
        }

        if ($request->visibility === 'visible_by_link') {
            $journey->mode = 'visible_by_link';
            $journey->uuid = (string) Str::uuid();
        } else {
            $journey->mode = 'private';
            $journey->uuid = null;
        }

        $journey->save();

        return redirect()->route('journey.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function show(Journey $journey)
    {
        return view('journey.show', ['journey' => $journey]);
    }

    /**
     * Download .gpx file for given journey.
     *
     * @param  \App\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function gpx(Journey $journey)
    {
        $this->authorize('gpx', $journey);

        $gpx_file = $journey->getGtx();
        $file_name = $journey->getFileName();
        $gpx_xml = $gpx_file->toXML()->saveXML();

        return response($gpx_xml, 200, [
            'Content-Type'        => 'application/gpx+xml',
            'Content-disposition' => sprintf('attachment; filename="%s.gpx"', $file_name),
            'Content-length'      => strlen($gpx_xml),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function edit(Journey $journey)
    {
        return view('journey.edit', [
            'journey' => $journey,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journey $journey)
    {
        $journey->title = $request->title;
        $journey->description = $request->description;
        $journey->start = $request->start;
        $journey->end   = $request->end;
        $journey->area = $request->area;

        if ($request->lat && $request->lng) {
            $journey->origin = new Point($request->lat, $request->lng);	// (lat, lng)
        } else {
            $journey->origin = null;
        }

        if ($request->visibility === 'visible_by_link') {
            if (is_null($journey->uuid)) {
                $journey->mode = 'visible_by_link';
                $journey->uuid = (string) Str::uuid();
            }
        } else {
            $journey->mode = 'private';
            $journey->uuid = null;
        }

        $journey->save();

        return redirect()->route('journey.show', [$journey]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journey $journey)
    {
        $journey->delete();
        return redirect()->route('journey.index');
    }
}
