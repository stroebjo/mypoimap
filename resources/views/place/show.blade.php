@extends('layouts.app')

@section('title', $place->title)

@section('content')

<div class="container-fluid">

    <article>

        <header class="m-contentheader d-sm-flex justify-content-between">
            <h1 class="h2">{{ $place->title }}</h1>

            <div>
                @auth
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('visit.create', ['place_id' => $place->id]) }}">{{ __('Add visit')}}</a>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('place.edit', [$place]) }}">{{ __('Edit') }}</a>
                @endauth
            </div>
        </header>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="mb-3">

                    @include('place.popup.meta', ['place' => $place])

                    @parsedown($place->description)
                </div>

                @if($place->visits()->count() > 0)
                    @foreach($place->visits as $visit)
                    <div class="mb-3">
                        <div class="m-contentheader d-sm-flex justify-content-between">
                            <h5 class="">
                                {{__('Visited at :date', ['date' => $visit->visited_at->toDateString()]) }}
                                @if($visit->journey_id)
                                    <small><a href="{{ route('journey.show', [$visit->journey_id]) }}">{{ $visit->journey->title }}</a></small>
                                @endif
                            </h5>
                            <div class="mb-1">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('visit.edit', ['visit' => $visit]) }}">{{ __('Edit')}}</a>
                            </div>
                        </div>
                        <small class="text-muted">{{ __('Rating: :rating', ['rating' => $visit->rating ?? '-'])}}</small>
                        @parsedown($visit->review)
                    </div>
                    @endforeach
                @endif

            </div>

            <div class="col-12 col-lg-4">
                <div style="position: sticky; top: 15px; z-index: 20;">
                    <div id="map" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>

    </article>
</div>
@endsection

@section('script')

@include('javascript.leaflet', [
    'id' => 'map',
    'places' => [$place],
])

<script>
    initPhotoSwipeFromDOM('.js-gallery-visit');
</script>
@endsection
