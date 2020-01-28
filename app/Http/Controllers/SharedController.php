<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Journey;

class SharedController extends Controller
{
    public function journey(Request $request, $uuid)
    {
        $journey = Journey::where('uuid', $uuid)->firstOrFail();

        return view('journey.show', [
            'journey' => $journey,
            'shared' => true
        ]);
    }

    public function journey_gpx(Request $request, $uuid)
    {
        $journey = Journey::where('uuid', $uuid)->firstOrFail();

        $gpx_file = $journey->getGtx();
        $file_name = $journey->getFileName();
        $gpx_xml = $gpx_file->toXML()->saveXML();

        return response($gpx_xml, 200, [
            'Content-Type'        => 'application/gpx+xml',
            'Content-disposition' => sprintf('attachment; filename="%s.gpx"', $file_name),
            'Content-length'      => strlen($gpx_xml),
        ]);
    }

}
