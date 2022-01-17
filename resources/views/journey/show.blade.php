@extends('layouts.app')

@section('title', $journey->title)

@section('content')
<article>
    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ $journey->title }}</h1>

        <div>
            @php
            // determine routes
            $route_gpx = (!empty($shared) && $shared === true) ?
                route('shared_journey.gpx', ['uuid' => $journey->uuid]) :
                route('journey.gpx', ['journey' => $journey->id]);

            @endphp

            <a class="btn btn-sm btn-outline-secondary me-1" href="{{ $route_gpx }}">{{ __('GPX')}} @svg('desktop-download')</a>

            @auth

            @if ($journey->mode == 'visible_by_link')
                <a class="btn btn-sm btn-outline-secondary me-1" target="_blank" href="{{ route('shared_journey.show', [$journey->uuid]) }}">{{ __('Public link')}} @svg('link-external')</a>
            @endif

            <a class="btn btn-sm btn-outline-primary" href="{{ route('journey.edit', [$journey]) }}">{{ __('Edit') }}</a>

            @endauth
        </div>
    </header>

    <div class="m-journey-meta">
        <p>{{ __('Journey from :start to :end (:nights nights).', [
            'start'  => $journey->start->format('Y-m-d'),
            'end'    => $journey->end->format('Y-m-d'),
            'nights' => $journey->nights,
        ]) }}</p>
    </div>

    <div class="m-journey-description mb-3">
        @parsedown($journey->description)
    </div>

    <div class="mb-2">
        <button type="button" class="js-days-open-all btn btn-sm btn-outline-secondary">{{ __('Open all')}}</button>
        <button type="button" class="js-days-hide-all btn btn-sm btn-outline-secondary">{{ __('Close all')}}</button>

        @if (Carbon\Carbon::now() >= $journey->start && Carbon\Carbon::now() <= $journey->end)
        <button type="button" class="js-days-open-only-today btn btn-sm btn-outline-secondary">{{ __('Open only today')}}</button>
        @endif
    </div>

    <div class="m-journey-days">
        {{-- @foreach($journey->journey_entries as $entry) --}}

        <div class="m-accordion">
        @for ($i = 0; $i <= $journey->nights; $i++)
@php
$date = $journey->start->addDays($i);
$entry = $journey->journey_entries()->where('date', '=', $date)->first();
$trigger_text = __('Day :day (:date)', [
'day' => $i+1,
'date' => $date->format('l, j.n.'),
]);

$is_today = $date->isToday();
$is_passed = $date->isPast();
$is_empty = !(bool) ($entry);

$is_hidden = ($is_passed or $is_empty);
$aria_expanded = ($is_hidden) ? "false" : "true";
@endphp
            <div id="day{{$i}}" class="m-accordion-item @if($is_empty) m-accordion-item--empty @endif @if($is_passed) m-accordion-item--muted @endif @if($is_today) m-accordion-item--highlighted @endif">
                <div class="m-accordion-item-top">
                    <div>
                        @if($is_empty)
                            <span class="m-accordion-item-top-trigger">
                                {{ $trigger_text }}
                            </span>
                        @else {{ __('')}}
                            <a class="m-accordion-item-top-trigger" data-bs-toggle="collapse" href="#journey-day-{{ $i }}" role="button" aria-expanded="{{ $aria_expanded }}" aria-controls="journey-day-{{ $i }}">
                                {{ $trigger_text }}
                            </a>
                        @endif

                        @include('misc.lunarphase', ['date' => $date])
                    </div>
                    <div>
                        @auth
                            @if($is_empty)
                                <a href="{{ route('journey_entry.create', [
                                    'journey' => $journey->id,
                                    'date' => $date->toDateString()
                                ]) }}" class="btn btn-sm btn-outline-secondary">{{ __('Create')}}</a>
                            @else {{ __('')}}
                                <a href="{{ route('journey_entry.edit', [
                                    'journey_entry' => $entry->id,
                                ]) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit')}}</a>
                            @endif
                        @endauth
                    </div>
                </div>

                @if(!$is_empty)
                    <div class="collapse multi-collapse @if(!$is_hidden) show @endif" id="journey-day-{{ $i }}">
                        <div class="m-accordion-item-content">
                            @parsedown($entry->description)
                        </div>
                    </div>
                @endif
            </div>
            @endfor
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-8">
            <div class="m-journey-places">
                @include('place.table', [
                    'number' => true,
                    'places' => $journey->getAllPOIsInArea(),
                    'journey' => $journey, // auto prefill journey_id in visit link
                ])
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="m-journey-map mb-3" style="position: sticky; top: 15px; z-index: 20;">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>

            <section>

                <header class="m-contentheader d-sm-flex justify-content-between">
                    <h5 class="">{{ __('Tracks') }}</h1>

                    <div class="mb-1">
                        @auth
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('track.create', ['journey_id' => $journey->id]) }}">{{ __('Add track')}}</a>
                        @endauth
                    </div>
                </header>

                <div>

                    @if(count($journey->tracks))
                    <ul>
                    @foreach($journey->tracks as $track)
                        <li>{{ $track->name }} @auth | <a href="{{ route('track.edit', [$track]) }}">{{ __('Edit') }}</a> @endauth </li>
                    @endforeach
                    </ul>
                    @else
                        <small class="text-muted">{{ __('No tracks uploaded yet.')}}</small>
                    @endif
                </div>
            </section>
        </div>
    </div>
</article>
@endsection

@section('script')

@include('javascript.datatable', ['el' => '#poitable'])

<script>
    $('.js-days-open-only-today').on('click', function() {
        $(".m-accordion-item:not('.m-accordion-item--highlighted')").each(function() {
            $(this).children('.collapse').collapse('hide');
        });

        $('.m-accordion-item--highlighted .collapse').collapse('show');
    });

    $('.js-days-open-all').on('click', function() {
        $(".m-accordion-item").each(function() {
            $(this).children('.collapse').collapse('show');
        });
    });

    $('.js-days-hide-all').on('click', function() {
        $(".m-accordion-item").each(function() {
            $(this).children('.collapse').collapse('hide');
        });
    });

</script>

@include('javascript.leaflet', [
    'places' => $journey->getAllPOIsInArea(),
    'show_number' => true,
    'layer_control' => true,
])

{{-- Put all uploaded track files in the HTML (yes it's larke, but also not
b/c of gzip). Nevertheless this is a "interesting" solution, but solves the
issue to provide a download warpper for the files. --}}
<script>
const parser = new DOMParser();

@foreach($journey->tracks as $track)
@switch($track->file_extension)
@case('kml')

    const kml{{ $loop->iteration }} = parser.parseFromString({!! json_encode($track->content) !!}, 'text/xml');
    const track{{ $loop->iteration }} = new L.KML(kml{{ $loop->iteration }});
    layerControl.addOverlay(track{{ $loop->iteration }}, '{{ $track->name }}');
@break

@case('gpx')
    var gpx{{ $loop->iteration }} = {!! json_encode($track->content) !!}; // URL to your GPX file or the GPX itself
    var gpxlayer{{ $loop->iteration }} = new L.GPX(gpx{{ $loop->iteration }}, {async: true});
    layerControl.addOverlay(gpxlayer{{ $loop->iteration }}, '{{ $track->name }}');
@break

@endswitch
@endforeach
</script>

{{-- Make click on table row highlight map marker --}}
<script>
var lastClickedIndex = false;

$('.js-poitablesm-row').on('click', function() {
    var $row = $(this);
    var index = $row.data('index');

    if (lastClickedIndex !== false) {
        markers[lastClickedIndex].setZIndexOffset(0);
        $(markers[lastClickedIndex]._icon).removeClass('custom-color-marker--highlighted');
    }
    lastClickedIndex = index;
    markers[index].setZIndexOffset(1000);


    $(markers[index]._icon).addClass('custom-color-marker--highlighted');

});
</script>


<script>
    initPhotoSwipeFromDOM('.js-gallery-poup');
</script>

@endsection
