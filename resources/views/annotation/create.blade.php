@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Annotation') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('annotation.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">

                                <select id="type" class="js-type form-select{{ $errors->has('type') ? ' is-invalid' : '' }}"  name="type">
                                    <option {{ old('type', app('request')->input('type')) == 'geojson' ? 'selected' : '' }} value="geojson">{{ __('GeoJSON') }}</option>
                                    <option {{ old('type', app('request')->input('type')) == 'image' ? 'selected' : '' }} value="image">{{ __('Image') }}</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @include('utilities.formrow', [
                            'title'    => __('Title'),
                            'name'     => 'name',
                            'required' => true,
                        ])

                        <div class="mb-3">
                            <label for="description" class="">{{ __('Description') }}</label>

                            <textarea rows="8" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
                            <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" accept=".geojson,.json,.gpx,.kml,.png" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ old('file') }}" required>

                                <small class="form-text text-muted">{{ __('GeoJSON, .gpx, .kml, .png') }}</small>

                                @if ($errors->has('file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="d-block text-center fst-italic">{{ __('- upload file or paste content below -') }}</small>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="">{{ __('Text') }}</label>

                            <textarea rows="4" id="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text">{{ old('text') }}</textarea>
                            <small class="form-text text-muted">{{ __('File contents (GeoJSON, WKT). If a file is set, this will be ignored.') }}</small>

                            @if ($errors->has('text'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <button type="submit" class="ms-3 btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@include('javascript.easymde', ['id' => 'description']);
@endsection
