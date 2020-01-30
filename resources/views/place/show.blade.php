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
<script>
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

    var marker = L.marker([{{ $place->location->getLat() }}, {{ $place->location->getLng()}}], {
        // unique icon per place, so we can use visited / color settings
        // inside the CustomColorMarker class
        icon: L.icon.customColorMarker({
            color: '{{ !is_null($place->user_category) ? $place->user_category->color : '#000000' }}',
            unique_id: '{{ $place->id}}',
            visited: {{ !is_null($place->isVisited()) ? 'true' : 'false' }}
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

    var group = L.featureGroup(markers).addTo(map);
    map.fitBounds(group.getBounds());


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
