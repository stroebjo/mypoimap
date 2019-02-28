@extends('layouts.app')

@section('content')



<div id="map"></div>

@endsection

@section('script')
<script>

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

    // Djerba: 33.7834477,10.8641857

    var map = L.map('map', {
        preferCanvas: true
    }).setView([33.7834477, 10.8641857], 12).addLayer(osm);

    // fetch user location button
    L.control.locate().addTo(map);

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
