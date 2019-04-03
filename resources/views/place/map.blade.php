@extends('layouts.app')

@section('mainclass', '')


@section('content')



<div id="map"></div>

@endsection

@section('script')
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

    // check for saved map area/zoom
    var map_position = {lat: 0, lng: 0, zoom: 3};
    if(lsTest() === true) {
        if (localStorage.getItem("map_position") !== null) {
            map_position = JSON.parse(localStorage.getItem("map_position"));
        }
    }

    // get paramter is more important than local storage
    var url = new URL(window.location.href);
    if (url.searchParams.get('lat') && url.searchParams.get('lng') &&
     !isNaN(parseFloat(url.searchParams.get('lat'))) && !isNaN(parseFloat(url.searchParams.get('lng')))) {
        map_position.lat = parseFloat(url.searchParams.get('lat'));
        map_position.lng = parseFloat(url.searchParams.get('lng'));

        if (url.searchParams.get('zoom') && !isNaN(parseInt(url.searchParams.get('zoom')))) {
            map_position.zoom = parseInt(url.searchParams.get('zoom'));
        }
    }

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
    L.control.startposition({ position: 'topleft' }).addTo(map);


    var markers = L.markerClusterGroup({
        disableClusteringAtZoom: 9,
        spiderfyOnMaxZoom: false,
        animate: false
    });

    @foreach($places as $place)

    L.marker([{{ $place->location->getLat() }}, {{ $place->location->getLng()}}], {
        // unique icon per place, so we can use visited / color settings
        // inside the CustomColorMarker class
        icon: L.icon.customColorMarker({
            color: '{{ !is_null($place->user_category) ? $place->user_category->color : '#000000' }}',
            unique_id: '{{ $place->id}}',
            visited: {{ !is_null($place->visited_at) ? 'true' : 'false' }}
        }),
        title: '{{ $place->title }}',
    })
        .addTo(markers)
        .bindPopup(`@include('place.popup', ['place' => $place])`)
        .on('popupopen', function(e) {
            var marker = e.popup._source;

            // init photoswipe on popup
            initPhotoSwipeFromDOM('.my-gallery');
        });

    @endforeach

    map.addLayer(markers);


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
