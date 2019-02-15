@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endsection

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

            <button  data-toggle="modal" data-target="#modal-place{{ $loop->index }}" class="js-open-modal">{{ __('Info')}}</button>

            <div style="display: none">
                {{ $place->description }}
            </div>

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




@foreach($places as $place)

<!-- Modal -->
    <div class="modal" id="modal-place{{ $loop->index }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $place->title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                @include('place.popup', ['place' => $place])
        </div>
        </div>
    </div>
    </div>


@endforeach



@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#poitable').DataTable({
                "pageLength": 50
            });
        } );
    </script>
@endsection
