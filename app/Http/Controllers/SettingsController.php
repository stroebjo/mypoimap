<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('settings.index', []);
    }

    /**
     * GET page for showing currently used Google place_ids.
     *
     */
    public function place_ids()
    {
        $places = Place::where('user_id', Auth::id())->whereNotNull('google_place_id')
          ->whereDate('google_place_id_date', '<', Carbon::now()->subYear(1))->get();


        //$places2 = Place::fetchGooglePlaceIdStatus($places);

        return view('settings.place_ids_index', ['places' => $places]);
    }

    public function update_place_ids(Request $request)
    {
        $places = Place::where('user_id', Auth::id())->whereNotNull('google_place_id')
          ->whereDate('google_place_id_date', '<', Carbon::now()->subYear(1))->get();

        $results = Place::fetchGooglePlaceIdStatus($places);

        return view('settings.place_ids_update', ['results' => $results]);
    }


}
