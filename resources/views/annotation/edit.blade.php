@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Annotation') }}
                </div>

                <div class="card-body">
                    <form method="POST" class="js-form" action="{{ route('annotation.update', [$annotation]) }}">
                        @csrf
                        {{ method_field('PATCH') }}

                        <input id="options" type="hidden" name="options" value="">

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-right">Type</label>

                            <div class="col-md-6">
                                <input type="text" disabled class="form-control"  value="{{ $annotation->type }}">
                                <small class="form-text text-muted">{{ __('The type can\'t be changed.')}}</small>
                            </div>
                        </div>


                        @include('utilities.formrow', [
                            'title'    => __('Title'),
                            'name'     => 'name',
                            'required' => true,
                            'value'    => $annotation->name,
                        ])

                        <div class="mb-3">
                            <label for="description" class="">{{ __('Description') }}</label>

                            <textarea rows="8" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description', $annotation->description) }}</textarea>
                            <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="mb-3">
                            <small>{{ __('To change the file, please delete this and create a new one.')}}</small>
                        </div>


                        @if($annotation->type == 'image')

                        <div class="mb-3 row">
                            <label for="opacity" class="col-md-4 col-form-label text-md-right">{{ __('Opacity') }}</label>

                            <div class="col-md-6">
                                <input id="opacity" type="range" min="0" max="1" step="0.01" class="form-range{{ $errors->has('transparency') ? ' is-invalid' : '' }}" name="opacity" value="{{ old('opacity', $annotation->opacity) }}" required>

                                @if ($errors->has('transparency'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('transparency') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div id="map" style="height: 400px"></div>
                        </div>

                        @endif


                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route('annotation.show', [$annotation->id]) }}">{{ __('Cancel') }}</a>

                                <button type="submit" class="ms-3 btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>


                    <form class="card-form-delete" method="POST" action="{{ route('annotation.destroy', [$annotation->id]) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="btn btn-outline-danger" type="submit">{{ __('Delete') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@if($annotation->type == 'image')
<script>
window.addEventListener("load", function() {

    var osmUrl    = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
var osm       = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});

var map_position = {lat: 0, lng: 0, zoom: 3};


var map = L.map('map', {
    preferCanvas: true
}).setView([map_position.lat, map_position.lng], map_position.zoom).addLayer(osm);

map.addControl(new L.Control.Fullscreen({
    position: 'topright',
    pseudoFullscreen: true // if true, fullscreen to page width and height
}));

function latlngvec(p1, p2) {
    var lat = p1.lat - p2.lat;
    var lng = p1.lng - p2.lng;

    return L.latLng(lat, lng);
}

function addvec(p1, vec) {
    return L.latLng(p1.lat + vec.lat, p1.lng + vec.lng);
}

var imageUrl = '{{ $annotation->url }}';
//var imageBounds = [[38.03664062118279, 27.248152500929713], [37.925213592153504, 27.415904404809474]];
var imageBounds = {!! json_encode($annotation->image_bounds) !!};
var bound = L.latLngBounds(imageBounds)

var overlay = L.imageOverlay(imageUrl, imageBounds, {
    opacity: parseFloat($('#opacity').val()),
    interactive: true
}).addTo(map);

map.fitBounds(overlay.getBounds());

var marker0 = new L.marker(bound.getCenter(), {
    draggable: true,
    autoPan: true
}).addTo(map);


var marker1 = new L.marker(imageBounds[0],{
    draggable: true,
    autoPan: true
}).addTo(map);

var marker2 = new L.marker(imageBounds[1],{
    draggable: true,
    autoPan: true
}).addTo(map);

marker0.on('drag', function(event) {
    var old = bound.getCenter();
    var latlng = event.target.getLatLng();

    var vec = latlngvec(latlng, old);

    console.log('center');
    console.log(vec);

    //imageBounds[0] = [latlng.lat, latlng.lng];

    marker1.setLatLng(addvec(marker1.getLatLng(), vec));
    marker2.setLatLng(addvec(marker2.getLatLng(), vec));

    imageBounds = [
        [marker1.getLatLng().lat, marker1.getLatLng().lng],
        [marker2.getLatLng().lat, marker2.getLatLng().lng]
    ];

    bound = L.latLngBounds(imageBounds);
    overlay.setBounds(bound);
});


marker1.on('drag', function(event) {
  var latlng = event.target.getLatLng();
  //console.log(latlng.lat, latlng.lng)
  imageBounds[0] = [latlng.lat, latlng.lng];
  var bound2 = L.latLngBounds(imageBounds)

  console.log('top-left');


  overlay.setBounds(imageBounds);
  marker0.setLatLng(bound2.getCenter());
});

marker2.on('drag', function(event) {
  var latlng = event.target.getLatLng();
  //console.log(latlng.lat, latlng.lng)
  imageBounds[1] = [latlng.lat, latlng.lng];
  var bound2 = L.latLngBounds(imageBounds)
  overlay.setBounds(imageBounds);
  marker0.setLatLng(bound2.getCenter());

  console.log('bottom-right');

});

$('#opacity').on('input', function(e) {
    var val = $(this).val();
    overlay.setOpacity(parseFloat(val));
});


$('.js-form').on('submit', function(e) {
    var options = {
        'opacity': parseFloat($("#opacity").val()),
        'imageBounds': imageBounds,
    };

    $('#options').val(JSON.stringify(options));
});

});
</script>
@endif

@include('javascript.easymde', ['id' => 'description']);
@endsection
