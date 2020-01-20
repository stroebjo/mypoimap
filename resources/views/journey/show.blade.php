@extends('layouts.app')

@section('title', $journey->title)

@section('content')

<div class="container-fluid">

    <article>

        <header class="m-contentheader d-sm-flex justify-content-between">
            <h1 class="h2">{{ $journey->title }}</h1>

            <div>
                @auth

                @if ($journey->mode == 'visible_by_link')
                    <a class="btn btn-sm btn-outline-secondary mr-1" target="_blank" href="{{ route('shared.journey', [$journey->uuid]) }}">{{ __('Public link')}} @svg('link-external')</a>
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

        <div class="m-journey-description">
            {{-- @parsedown($journey->description) --}}
        </div>


        <div class="mb-2">
            <button type="button" class="js-days-open-all btn btn-sm btn-outline-secondary">{{ __('Open all')}}</button>
            <button type="button" class="js-days-hide-all btn btn-sm btn-outline-secondary">{{ __('Close all')}}</button>
            <button type="button" class="js-days-open-only-today btn btn-sm btn-outline-secondary">{{ __('Open only today')}}</button>
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
                                <a class="m-accordion-item-top-trigger" data-toggle="collapse" href="#journey-day-{{ $i }}" role="button" aria-expanded="{{ $aria_expanded }}" aria-controls="journey-day-{{ $i }}">
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
                        'places' => $journey->getAllPOIsInArea()]
                    )
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="m-journey-map" style="position: sticky; top: 15px; z-index: 20;">
                    <div id="map" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>

    </article>
</div>


@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#poitable').DataTable({
            "pageLength": 50,

            responsive: true,
            bAutoWidth: false,

            columnDefs: [
                { targets: 'no-sort', orderable: false }
            ]

        });
    });

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

<script>

function lsTest(){
    var test = 'test';
    try {
        localStorage.setItem(test, test);
        localStorage.removeItem(test);
        return true;
    } catch(e) {
        return false;
    }
}

    var osmUrl    = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
    var osm       = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});

    var map_position = {lat: 0, lng: 0, zoom: 3};

    var map = L.map('map', {
        preferCanvas: true
    }).setView([map_position.lat, map_position.lng], map_position.zoom).addLayer(osm);

    // Leafleat plugins, buttons, etc.
    L.control.locate({
        icon: 'my-icon my-marker',
        iconLoading: 'my-icon my-spinner',

        // spinner svg: https://fontawesome.com/icons/spinner?style=solid
        // marker svg: https://fontawesome.com/icons/map-marker-alt?style=solid
        createButtonCallback: function(container, options) {
            var link = L.DomUtil.create('a', 'leaflet-bar-part leaflet-bar-part-single', container);
            link.title = options.strings.title;
            var icon = L.DomUtil.create(options.iconElementTag, options.icon, link);

            icon.innerHTML = `<svg class="marker" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path></svg>
<svg class="spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>
`;

            return { link: link, icon: icon };
        }

    }).addTo(map); // fetch user location button
    L.control.scale().addTo(map); // km/mile scale at bottom/left

    map.addControl(new L.Control.Fullscreen({
        position: 'topright',
        pseudoFullscreen: true // if true, fullscreen to page width and height
    }));

    var markers = [];

    @foreach($journey->getAllPOIsInArea() as $place)

    var marker = L.marker([{{ $place->location->getLat() }}, {{ $place->location->getLng()}}], {
        // unique icon per place, so we can use visited / color settings
        // inside the CustomColorMarker class
        icon: L.icon.customColorMarker({
            color: '{{ !is_null($place->user_category) ? $place->user_category->color : '#000000' }}',
            unique_id: '{{ $place->id}}',
            visited: {{ !is_null($place->visited_at) ? 'true' : 'false' }},
            number: {{ $loop->iteration }}
        }),
        title: '{{ $place->title }}',
    })
        //.addTo(map)
        .bindPopup(`@include('place.popup', ['title' => true, 'controls' => true, 'place' => $place])`)
        .on('popupopen', function(e) {
            var marker = e.popup._source;

            // init photoswipe on popup
            initPhotoSwipeFromDOM('.my-gallery');
        });
        markers.push(marker);

    @endforeach

    var group = L.featureGroup(markers).addTo(map);
    map.fitBounds(group.getBounds());

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


/**
 * Small inline function to set dynamicalle viewport height on mobile.
 * Prevents vh + mobile issue with scrolling.
 *
 */
const appHeight = () => {
    const doc = document.documentElement;
    // set global css variable
    doc.style.setProperty('--app-height', `${window.innerHeight - document.getElementById('navbar').offsetHeight}px`);
}
window.addEventListener('resize', appHeight)
appHeight()





</script>
@endsection
