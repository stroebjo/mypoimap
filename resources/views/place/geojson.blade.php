{
    "type": "FeatureCollection",
    "features": [
        @foreach($places as $place)
        {
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [{{ $place->location->longitude }}, {{ $place->location->latitude }}]
            },
            "properties": {
                "name": "{{ $place->title }}"
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
