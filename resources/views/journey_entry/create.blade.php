@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('journey.show', [$journey]) }}">{{ $journey->title }}</a> /
            {{ __('Journey Entry') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('journey_entry.store') }}">
                @csrf

                <input type="hidden" name="journey_id" value="{{ old('journey_id', $journey->id)}}">

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" min="{{ $journey->start->toDateString() }}" max="{{ $journey->end->toDateString() }}" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date', request()->date) }}" required>

                                @if ($errors->has('date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="">{{ __('Description') }}</label>

                    <textarea rows="30" id="description"  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
                    <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <div></div>

                    <div>
                        <a class="btn btn-outline-secondary" href="{{ route('journey.show', [$journey]) }}">{{ __('Cancel') }}</a>

                        <button type="submit" class="ml-3 btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

