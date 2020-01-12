<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Journey;

class SharedController extends Controller
{
    public function journey(Request $request, $uuid)
    {
        $journey = Journey::where('uuid', $uuid)->firstOrFail();

        return view('journey.show', ['journey' => $journey]);
    }

}
