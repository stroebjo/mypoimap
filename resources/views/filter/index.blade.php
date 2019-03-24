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
                        <th>{{ __('Places')}}</th>
                        <th class="no-sort text-right">{{ __('Actions')}}</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($filters as $filter)

                <tr>
                    <td>
                        {{ $filter->title }}

                        <a class="" href="{{ route('filter.map', [$filter->id]) }}">{{ __('Map')}}</a>

                        @if ($filter->mode == 'visible_by_link')
                            <a class="" href="{{ route('filter.sahredmap', [$filter->uuid]) }}">{{ __('Public map')}}</a>
                        @endif
                    </td>

                    <td>
                        @foreach($filter->places() as $place)
                            {{ $place->title}} <br>
                        @endforeach
                    </td>

                    <td>
                        <div class="d-flex justify-content-end">

                            <a class="ml-1 btn btn-sm btn-secondary" href="{{ route('filter.edit', [$filter]) }}">{{ __('Edit')}}</a>

                            <form class="ml-1" method="POST" action="{{ route('filter.destroy', [$filter->id]) }}">
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

            <a class="btn btn-primary" href="{{ route('filter.create') }}">
                {{ __('Create new filter') }}
            </a>

        </div>
    </div>
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
