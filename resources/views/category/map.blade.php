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

    var map = L.map('map').setView([33.7834477, 10.8641857], 12).addLayer(osm);

    // fetch user location button
    L.control.locate().addTo(map);

    @foreach($categories as $category)


    /* var icon{{ $category->id}} = L.icon.fontAwesome({
		iconClasses: 'fa fa-hotel', // you _could_ add other icon classes, not tested.
		markerColor: '{{ $category->color }}',
		iconColor: '#FFF'
    }); */


    const icon{{ $category->id}} = L.icon.customColorMarker({
        color: '{{ $category->color }}',
        unique_id: '{{ $category->id}}',
    });

    @endforeach


    @foreach($places as $place)

    L.marker([{{ $place->location->getLat() }}, {{ $place->location->getLng()}}], {
        //icon: icon{{ $place->user_category_id}},
        icon: L.icon.customColorMarker({
            color: '{{ $place->user_category->color }}',
            unique_id: '{{ $place->id}}',
            visited: {{ !is_null($place->visited_at) ? 'true' : 'false' }}
        }),
        //icon: {{ $place->user_category->color }}Icon,
        //opacity: {{ $place->getVisitedOpacity() }},
        title: '{{ $place->title }}'
    })
        .addTo(map)
        .bindPopup(`@include('place.popup', ['place' => $place])`)
        /*.openPopup()*/;

    @endforeach

</script>
@endsection
