@php
$show_number = $show_number ?? false;
$ref_numbers = $ref_numbers ?? false;
$cluster = $cluster ?? false;
$journey = $journey ?? null;
$check_for_saved_location = $check_for_saved_location ?? false;
$check_for_query_location = $check_for_query_location ?? false;
$layer_control = $layer_control ?? false;
$tracks = $tracks ?? [];
$annotations = $annotations ?? [];
$places = $places ?? [];
@endphp
<script>
window.addEventListener("load", function() {

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

    @if($check_for_saved_location)
    // check for saved map area/zoom
    if(lsTest() === true) {
        if (localStorage.getItem("map_position") !== null) {
            map_position = JSON.parse(localStorage.getItem("map_position"));
        }
    }
    @endif

    @if($check_for_query_location)
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
    @endif

    var map = L.map('{{ $id ?? 'map'}}', {
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

    @if($check_for_saved_location)
    L.control.startposition({ position: 'topleft' }).addTo(map);
    @endif

    @if($cluster)
    var markers = L.markerClusterGroup({
        disableClusteringAtZoom: 9,
        spiderfyOnMaxZoom: false,
        animate: false
    });
    @else
    var markers = [];
    @endif

    map.addControl(new L.Control.Fullscreen({
        position: 'topright',
        pseudoFullscreen: true // if true, fullscreen to page width and height
    }));



    @foreach($places as $place)
    var marker = L.marker([{{ $place->location->latitude }}, {{ $place->location->longitude }}], {
        // unique icon per place, so we can use visited / color settings
        // inside the CustomColorMarker class
        icon: L.icon.customColorMarker({
            color: '{{ !is_null($place->user_category) ? $place->user_category->color : '#000000' }}',
            unique_id: '{{ $place->id}}',
            visited: {{ $place->isVisited() ? 'true' : 'false' }}

            @if($show_number)
            ,
            number: {{ $loop->iteration }}
            @endif

        }),
        title: '{{ $place->title }}',
    })
        //.addTo(map)
        .bindPopup(`@include('place.popup', ['title' => true, 'controls' => true, 'place' => $place, 'journey' => $journey])`)
        .on('popupopen', function(e) {
            var marker = e.popup._source;
        })
        @if($cluster)
        .addTo(markers);
        @else
        ;
    markers.push(marker);
    @endif

    @endforeach

    @if($cluster)
    map.addLayer(markers);
    @else
    if (markers.length > 0) {
        var group = L.featureGroup(markers).addTo(map);
        map.fitBounds(group.getBounds());
    }
    @endif

@if($layer_control)
var layerControl = L.control.layers().addTo(map);

layerControl.addBaseLayer(osm, 'OSM');
layerControl.addOverlay(group, 'POIs');
@endif


{{-- Make click on table row highlight map marker --}}
@if($ref_numbers)
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
@endif


@if(count($tracks) > 0)

{{-- Put all uploaded track files in the HTML (yes it's larke, but also not
b/c of gzip). Nevertheless this is a "interesting" solution, but solves the
issue to provide a download warpper for the files. --}}

const parser = new DOMParser();

@foreach($tracks as $track)
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
@endif

@foreach($annotations as $annotation)
var annotations = [];
@switch($annotation->type)
@case('geojson')

var {{$annotation->varname}} = new L.GeoJSON.AJAX('{{$annotation->url}}').bindPopup(`@include('annotation.popup', ['annotation' => $annotation])`);
if(typeof layerControl !== 'undefined') {
    layerControl.addOverlay({{$annotation->varname}}, '{{$annotation->name}}');
} else {
    {{$annotation->varname}}.addTo(map);

    {{$annotation->varname}}.on('data:loaded', function() {
       map.fitBounds({{$annotation->varname}}.getBounds())
   });

    //map.fitBounds({{$annotation->varname}}.getBounds());
}
@break
@case('image')
var {{$annotation->varname}} = L.imageOverlay('{{$annotation->url}}', {!! json_encode($annotation->image_bounds) !!}, {
    opacity: {{$annotation->opacity}},
    interactive: true
}).bindPopup(`@include('annotation.popup', ['annotation' => $annotation])`);

if(typeof layerControl !== 'undefined') {
    layerControl.addOverlay({{$annotation->varname}}, '{{$annotation->name}}');
} else {
    {{$annotation->varname}}.addTo(map);
    map.fitBounds({{$annotation->varname}}.getBounds());
}

@break

@endswitch
@endforeach



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
window.addEventListener('resize', appHeight);
appHeight();

});
</script>
