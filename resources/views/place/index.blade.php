@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ __('Places') }}</h1>

        <div>
            <a class="btn btn-sm btn-primary" href="{{ route('place.create', []) }}">{{ __('Add new place') }}</a>
        </div>
    </header>

    @include('place.table', [
        'places' => $places,
        'number' => false,
        'delete' => true,
        'edit'   => true,
    ])

</div>
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
