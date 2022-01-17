@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('place.show', [$journey]) }}">{{ $journey->title }}</a> /
                    {{ __('Track') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('track.store') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="journey_id" value="{{ old('journey_id', $journey->id)}}">


                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="">{{ __('description') }}</label>

                            <textarea rows="8" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
                            <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="mb-3 row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Track file') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" accept=".gpx,.kml" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ old('file') }}" required>

                                <small class="form-text text-muted">{{ __('.gpx, .kml') }}</small>

                                @if ($errors->has('file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="order" class="col-md-4 col-form-label text-md-right">{{ __('Order') }}</label>

                            <div class="col-md-6">
                                <input id="order" type="number" step="1" class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" name="order" value="{{ old('order', 0) }}" required>

                                <small class="form-text text-muted">{{ __('Tracks are order by this value, beginnging with the lowest.') }}</small>


                                @if ($errors->has('order'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route('journey.show', [$journey]) }}">{{ __('Cancel') }}</a>

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
