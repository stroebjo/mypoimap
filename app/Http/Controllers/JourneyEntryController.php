<?php

namespace App\Http\Controllers;

use App\JourneyEntry;
use App\Journey;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class JourneyEntryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(JourneyEntry::class, 'journey_entry');
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
        $journey_id = request()->journey;

        if (!$journey_id) {
            abort(403, 'Unauthorized action.');
        }

        $journey = Journey::findOrFail($journey_id);

        if ($journey->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('journey_entry.create', [
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
        $journeyEntry = new JourneyEntry();

        $journeyEntry->user_id = Auth::id();
        $journeyEntry->journey_id = $request->journey_id;
        $journeyEntry->title = $request->title;
        $journeyEntry->description = $request->description;
        $journeyEntry->date = $request->date;
        $journeyEntry->save();

        return redirect()->route('journey.show', ['journey' => $request->journey_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JourneyEntry  $journeyEntry
     * @return \Illuminate\Http\Response
     */
    public function show(JourneyEntry $journeyEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JourneyEntry  $journeyEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(JourneyEntry $journeyEntry)
    {
        return view('journey_entry.edit', [
            'journeyEntry' => $journeyEntry,
            'journey' => $journeyEntry->journey,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JourneyEntry  $journeyEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JourneyEntry $journeyEntry)
    {
        $journeyEntry->title = $request->title;
        $journeyEntry->description = $request->description;
        $journeyEntry->date = $request->date;

        $journeyEntry->save();

        return redirect()->route('journey.show', [$journeyEntry->journey_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JourneyEntry  $journeyEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(JourneyEntry $journeyEntry)
    {
        $journey_id = $journeyEntry->journey_id;
        $journeyEntry->delete();
        return redirect()->route('journey.show', [$journey_id]);
    }
}
