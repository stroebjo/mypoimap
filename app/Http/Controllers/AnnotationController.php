<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Journey;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnotationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Annotation::class, 'annotation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $annotations = Annotation::where('user_id', Auth::id())->get();
        return view('annotation.index', ['annotations' => $annotations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('annotation.create', [
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
        $annotation = new Annotation();
        $annotation->user_id = Auth::id();

        $annotation->type = $request->type;
        $annotation->name = $request->name;
        $annotation->description = $request->description;
        $annotation->options = null;

        $file = $request->file('file');

        if ($file) {
            $path = $file->store('/', 'annotations');

            $annotation->upload_path = $path;
            $annotation->file_name = $file->getClientOriginalName();
            $annotation->file_extension = $file->getClientOriginalExtension();
            $annotation->mime_type = $file->getMimeType();
            $annotation->size = $file->getSize();
        } else {
            $annotation->text = $request->text;
        }

        $annotation->save();

        return redirect()->route('annotation.show', ['annotation' => $annotation->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function show(Annotation $annotation)
    {
        return view('annotation.show', [
            'annotation' => $annotation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Annotation $annotation)
    {
        return view('annotation.edit', [
            'annotation' => $annotation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Annotation $annotation)
    {
        $annotation->name = $request->name;
        $annotation->description = $request->description;

        if ($annotation->type == 'image') {
            $annotation->options = json_decode($request->options);
        }

        $annotation->save();

        return redirect()->route('annotation.show', ['annotation' => $annotation->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annotation $annotation)
    {
        try {
            $annotation->delete();
            Storage::disk('annotations')->delete($annotation->upload_path);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('annotation.show', [$annotation])->with('error', __('The annotation can\'t be deleted while it is still linked to other entries.'));
        }

        return redirect()->route('annotation.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function link()
    {
        if (!empty(request()->journey_id)) {
            $annotatable = Journey::findOrFail(request()->journey_id);
            $cancel_route = 'journey.show';
            if ($annotatable->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        } else if (!empty(request()->place_id)) {
            $annotatable = Place::findOrFail(request()->place_id);
            $cancel_route = 'place.show';
            if ($annotatable->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }

        $linked = $annotatable->annotations->pluck('id')->toArray();

        return view('annotation.link', [
            'annotatable' => $annotatable,
            'annotations' => Annotation::where('user_id', Auth::id())->get(),
            'linked_annotations' => $linked,
            'cancel_route' => $cancel_route,
        ]);
    }

    public function updateLink(Request $request)
    {
        $annotatable_type = $request->annotatable_type;

        $annotation = Annotation::findOrFail($request->annotation_id);
        if ($annotation->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if($annotatable_type == Place::class) {
            $annotatable = Place::findOrFail($request->annotatable_id);
            if ($annotatable->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            $annotatable->annotations()->save($annotation);
            return redirect()->route('place.show', ['place' => $annotatable->id]);
        } else if ($annotatable_type == Journey::class) {
            $annotatable = Journey::findOrFail($request->annotatable_id);
            if ($annotatable->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            $annotatable->annotations()->save($annotation);
            return redirect()->route('journey.show', ['journey' => $annotatable->id]);
        }

        abort(403, 'Unauthorized action.');
    }


    public function destroyLink(Request $request)
    {
        $annotatable_type = $request->annotatable_type;
        $annotation = Annotation::findOrFail($request->annotation_id);
        if ($annotation->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if($annotatable_type == Place::class) {
            $annotatable = Place::findOrFail($request->annotatable_id);
            if ($annotatable->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            $annotatable->annotations()->detach($annotation);
            return redirect()->route('place.show', ['place' => $annotatable->id]);
        } else if ($annotatable_type == Journey::class) {
            $annotatable = Journey::findOrFail($request->annotatable_id);
            if ($annotatable->user_id != Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            $annotatable->annotations()->detach($annotation);

            return redirect()->route('journey.show', ['journey' => $annotatable->id]);
        }

        abort(403, 'Unauthorized action.');
    }
}
