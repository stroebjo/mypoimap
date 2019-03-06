@extends('layouts.app')

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


    /*
    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([51.5, -0.09]).addTo(map)
        .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
        .openPopup(); */



    var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});

    // Djerba: 33.7834477,10.8641857 12

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

    // fetch user location button
    L.control.locate().addTo(map);

    L.control.scale().addTo(map);

    L.control.startposition({ position: 'topleft' }).addTo(map);



    @foreach($places as $place)

    L.marker([{{ $place->location->getLat() }}, {{ $place->location->getLng()}}], {
        // unqie icon per place, so we can use visited / color settings
        // inside the CustomColorMarker class
        icon: L.icon.customColorMarker({
            color: '{{ !is_null($place->user_category) ? $place->user_category->color : '#000000' }}',
            unique_id: '{{ $place->id}}',
            visited: {{ !is_null($place->visited_at) ? 'true' : 'false' }}
        }),

        title: '{{ $place->title }}',
    })
        .addTo(map)
        .bindPopup(`@include('place.popup', ['place' => $place])`)
        .on('popupopen', function(e) {
            var marker = e.popup._source;

            // init photoswipe on popup
            initPhotoSwipeFromDOM('.my-gallery');
        });

    @endforeach

</script>
@endsection
