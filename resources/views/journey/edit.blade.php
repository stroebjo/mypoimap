@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Journey') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('journey.update', [$journey]) }}">
                @csrf
                {{ method_field('PATCH') }}

                <div class="mb-3 row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $journey->title) }}" required>

                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Start') }}</label>

                    <div class="col-md-6">
                        <input id="start" type="date" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" value="{{ old('start', $journey->start->toDateString()) }}" required>

                        @if ($errors->has('start'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('start') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('End') }}</label>

                    <div class="col-md-6">
                        <input id="end" type="date" class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}" name="end" value="{{ old('end', $journey->end->toDateString()) }}" required>

                        @if ($errors->has('end'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('end') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-4 text-md-right">
                        Origin
                        <label for="lat" class="col-form-label">{{ __('Lat') }}</label> /
                        <label for="lng" class="col-form-label">{{ __('Lng') }}</label>
                    </div>

                    <div class="col-md-6">

                        <div class="mb-3 row">
                            <div class="col-6">
                                <input id="lat" type="text" class="form-control{{ $errors->has('lat') ? ' is-invalid' : '' }}" name="lat" value="{{ old('lat', ($journey->origin ? $journey->origin->latitude : '')) }}">

                                @if ($errors->has('lat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lat') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-6">
                                <input id="lng" type="text" class="form-control{{ $errors->has('lng') ? ' is-invalid' : '' }}" name="lng" value="{{ old('lng', ($journey->origin ? $journey->origin->longitude : '')) }}">

                                @if ($errors->has('lng'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lng') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="area" class="col-md-4 col-form-label text-md-right">{{ __('Area') }}</label>

                    <div class="col-md-6">
                        <input id="area" type="text" class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}" name="area" value="{{ old('area', $journey->area) }}">

                        <small class="text-muted">See this <a href="https://clydedacruz.github.io/openstreetmap-wkt-playground/" target="_blank">WKT editor</a> for creating polygons.</small>

                        @if ($errors->has('area'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('area') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="">{{ __('Description') }}</label>

                    <textarea rows="30" id="description"  class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description', $journey->description) }}</textarea>
                    <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="mb-3 row">
                    <label for="visibility" class="col-md-4 col-form-label text-md-right">Visibility</label>

                    <div class="col-md-6">

                        <select id="visibility" class="form-select" name="visibility">
                            <option {{ old('visibility', $journey->mode) == 'private' ? 'selected' : '' }} value="private">Private</option>
                            <option {{ old('visibility', $journey->mode) == 'visible_by_link' ? 'selected' : '' }} value="visible_by_link">Public (unlisted)</option>
                        </select>

                        @if ($errors->has('visibility'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('visibility') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>{{-- for justify-content-between --}}</div>

                    <div>
                        <a class="btn btn-outline-secondary" href="{{ route('journey.show', [$journey]) }}">{{ __('Cancel') }}</a>

                        <button type="submit" class="ms-3 btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>

            <form class="card-form-delete" method="POST" action="{{ route('journey.destroy', [$journey->id]) }}">
                @csrf
                {{ method_field('DELETE') }}
                <button class="btn btn-outline-danger" type="submit">{{ __('Delete') }}</button>
            </form>

        </div>
    </div>
</div>
@endsection

@section('script')

@include('javascript.easymde', ['id' => 'description']);

@endsection
