@extends('layouts.app')

@section('content')



<div id="map"></div>

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

var map = L.map('map').setView([33.7834477, 10.8641857], 12).addLayer(osm);

/*
L.marker([51.504, -0.159])
    .addTo(map)
    .bindPopup('A pretty CSS3 popup.<br />Easily customizable.')
    .openPopup();
    */

@foreach($places as $place)

L.marker([{{ $place->location->getLat() }}, {{ $place->location->getLng()}}])
    .addTo(map)
    .bindPopup(`@include('place.popup', ['place' => $place])`)
    /*.openPopup()*/;

@endforeach

</script>

@endsection
