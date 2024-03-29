@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('place.show', [$place]) }}">{{ $place->title }}</a> /
                    {{ __('Visit') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('visit.store') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="place_id" value="{{ old('place_id', $place->id)}}">

                        <div class="mb-3 row">
                            <label for="visited_at" class="col-md-4 col-form-label text-md-right">{{ __('Visited at') }}</label>

                            <div class="col-md-6">
                                <input id="visited_at" type="date" class="js-visited_at form-control{{ $errors->has('visited_at') ? ' is-invalid' : '' }}" name="visited_at" value="{{ old('visited_at') }}" required>

                                @if ($errors->has('visited_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('visited_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="journey_id" class="col-md-4 col-form-label text-md-right">{{ __('Journey') }}</label>

                            <div class="col-md-6">

                                <select id="journey_id" class="js-journey_id form-select{{ $errors->has('journey_id') ? ' is-invalid' : '' }}"  name="journey_id">
                                    <option value="">{{ __('- No Journey -')}}</option>
                                @foreach($journeys as $journey)
                                    <option {{ old('journey_id', app('request')->input('journey_id')) == $journey->id ? 'selected' : '' }} value="{{ $journey->id }}">{{ $journey->title}}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('journey_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('journey_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="review" class="">{{ __('Review') }}</label>

                            <textarea rows="8" id="review" class="form-control{{ $errors->has('review') ? ' is-invalid' : '' }}" name="review">{{ old('review') }}</textarea>
                            <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                            @if ($errors->has('review'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('review') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="mb-3 row">
                            <label for="rating" class="col-md-4 col-form-label text-md-right">{{ __('Rating') }}</label>

                            <div class="col-md-6">
                                <input id="rating" type="number" min="0" max="5" step="1" class="form-control{{ $errors->has('rating') ? ' is-invalid' : '' }}" name="rating" value="{{ old('rating') }}">
                                <small class="form-text text-muted">{{ __('A value between 0 and 5, where 5 is great see and 0 is bad.') }}</small>

                                @if ($errors->has('rating'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rating') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="images" class="col-md-4 col-form-label text-md-right">{{ __('Images') }}</label>

                            <div class="col-md-6">
                                <input id="images" type="file" multiple="multiple" class="form-control{{ $errors->has('images') ? ' is-invalid' : '' }}" name="images[]" value="{{ old('images') }}">

                                @if ($errors->has('images'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('images') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route('place.show', [$place]) }}">{{ __('Cancel') }}</a>

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
<script>
    const journey_durations = {
        @foreach($journeys as $journey)
            {{ $journey->id}}: {
                'start': '{{ $journey->start->toDateString() }}',
                'end': '{{ $journey->end->toDateString() }}',
            },
        @endforeach
    };

    window.addEventListener("load", function() {
        $('.js-journey_id').on('change', function() {
            let journey_id = $(this).val();

            if(journey_id && typeof journey_durations[journey_id] !== 'undefined') {
                $('.js-visited_at').attr('min', journey_durations[journey_id]['start']).attr('max', journey_durations[journey_id]['end']);
            } else {
                $('.js-visited_at').attr('min', '').attr('max', '');
            }
        }).trigger('change');
    });
</script>

@include('javascript.easymde', ['id' => 'review']);
@endsection
