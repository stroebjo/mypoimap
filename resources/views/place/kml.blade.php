@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>

@foreach($places as $place)
    <Placemark>
        <name>{{ $place->title }}</name>
        <description><![CDATA[@parsedown($place->description)]]></description>
        <Point>
            <coordinates>{{ $place->location->longitude }},{{ $place->location->latitude }}</coordinates>
        </Point>
    </Placemark>
@endforeach

</Document>
</kml>
