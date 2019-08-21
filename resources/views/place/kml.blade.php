@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>

@foreach($places as $place)
    <Placemark>
        <name>{{ $place->title }}</name>
        <description><![CDATA[{!! $place->getHTMLDescription() !!}]]></description>
        <Point>
            <coordinates>{{ $place->location->getLng() }},{{ $place->location->getLat() }}</coordinates>
        </Point>
    </Placemark>
@endforeach

</Document>
</kml>
