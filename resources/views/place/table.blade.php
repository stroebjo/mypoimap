@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endsection

@section('content')

<div class="container">

        <div class="card">
            <div class="card-body">


<table id="poitable" class="table">

    <thead>

        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Priority')}}</th>
            <th class="no-sort">{{ __('Location')}}</th>
            <th class="no-sort text-right">{{ __('Actions')}}</th>
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

            <div style="display: none">
                {{ $place->description }}
            </div>

        </td>


        <td>
            {{ $place->priority }}
        </td>


        <td>
            <a href="{!! $place->google_maps_details_link !!}" rel="noreferrer">{{ __('Maps') }}</a> |
            <a href="{!! $place->google_maps_directions_link !!}" rel="noreferrer">{{ __('Directions') }}</a>
        </td>

        <td>
                <div class="d-flex justify-content-end">

            <button  data-toggle="modal" data-target="#modal-place{{ $loop->index }}" class="btn btn-sm btn-primary js-open-modal">{{ __('Info')}}</button>
            <a class="ml-1 btn btn-sm btn-secondary" href="{{ route('place.edit', [$place]) }}">{{ __('Edit')}}</a>

            <form class="ml-1" method="POST" action="{{ route('place.destroy', [$place->id]) }}">
                @csrf
                {{ method_field('DELETE') }}
                <button class="btn btn-sm btn-danger" type="submit">{{ __('Delete') }}</button>
            </form>
        </div>

        </td>

    </tr>

    @endforeach
    </tbody>

</table>


</div>

</div>
</div>


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
                "pageLength": 50,

                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ]

            });
        } );
    </script>
@endsection
