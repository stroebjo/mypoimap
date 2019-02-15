@extends('layouts.app')

@section('content')


<table id="poitable" class="table">

    <thead>

        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Location')}}</th>
            <th>{{ __('Priority')}}</th>

        </tr>


    </thead>

    <tbody>

    @foreach($places as $place)

    <tr>

        <td>
            @if ($place->url != '')
            <a href="{{$place->url}}">
            @endif
            {{ $place->title }}
            @if ($place->url != '')
            </a>
            @endif
        </td>

        <td>
            <a href="https://www.google.com/maps/search/?api=1&query={{ $place->location->getLat() }},{{ $place->location->getLng() }}">{{ __('Maps') }}</a> |
            <a href="http://maps.google.com/maps?f=d&daddr={{ $place->location->getLat() }},{{ $place->location->getLng() }}">{{ __('Directions') }}</a>
        </td>

        <td>
            {{ $place->priority }}
        </td>

    </tr>

    @endforeach
    </tbody>

</table>



<script>
$(document).ready(function() {
    $('#poitable').DataTable({
        "pageLength": 50
    });
} );
</script>


@endsection
