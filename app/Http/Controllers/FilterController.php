<?php

namespace App\Http\Controllers;

use App\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class FilterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['sharedmap']);
        $this->authorizeResource(Filter::class, 'filter');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = Filter::where('user_id', Auth::id())->get();

        return view('filter.index', [
            'filters' => $filters,
        ]);
    }

    public function map(Filter $filter)
    {
        $places = $filter->places();

        return view('place.map', [
            'places' => $places,
        ]);
    }

    public function sharedmap(Request $request, $uuid)
    {
        $filter = Filter::where('uuid', $uuid)->firstOrFail();
        $places = $filter->places();

        return view('place.map', [
            'places' => $places,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('filter.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filter = new Filter();
        $filter->user_id = Auth::id();

        $filter->title = $request->title;
        $filter->description = $request->description;

        $filter->options = [
            'filter_operator' => $request->filter_operator,
            'filters' => $request->filters
        ];

        if ($request->visibility === 'visible_by_link') {
            $filter->mode = 'visible_by_link';
            $filter->uuid = Uuid::generate(4);
        } else {
            $filter->mode = 'private';
            $filter->uuid = null;
        }

        $filter->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function show(Filter $filter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function edit(Filter $filter)
    {
        return view('filter.edit', [
            'filter' => $filter
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filter $filter)
    {
        $filter->title = $request->title;
        $filter->description = $request->description;

        $filter->options = [
            'filter_operator' => $request->filter_operator,
            'filters' => $request->filters
        ];

        if ($request->visibility === 'visible_by_link') {
            if (is_null($filter->uuid)) {
                $filter->mode = 'visible_by_link';
                $filter->uuid = Uuid::generate(4);
            }
        } else {
            $filter->mode = 'private';
            $filter->uuid = null;
        }

        $filter->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filter $filter)
    {
        $filter->delete();
        return redirect()->route('filter.index');
    }
}
