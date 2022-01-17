@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('journey.show', [$track->journey_id]) }}">{{ $track->journey->title }}</a> /
                    {{ __('Track') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('track.update', [$track]) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $track->name) }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="description" class="">{{ __('Description') }}</label>

                            <textarea rows="8" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description', $track->description) }}</textarea>
                            <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="order" class="col-md-4 col-form-label text-md-right">{{ __('Order') }}</label>

                            <div class="col-md-6">
                                <input id="order" type="number" step="1" class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" name="order" value="{{ old('order', $track->order) }}" required>

                                <small class="form-text text-muted">{{ __('Tracks are order by this value, beginnging with the lowest.') }}</small>


                                @if ($errors->has('order'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <small>{{ __('To change the track file, please delete this and create a new one.')}}</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route('journey.show', [$track->journey_id]) }}">{{ __('Cancel') }}</a>

                                <button type="submit" class="ms-3 btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>


                    <form class="card-form-delete" method="POST" action="{{ route('track.destroy', [$track->id]) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="btn btn-outline-danger" type="submit">{{ __('Delete') }}</button>
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
