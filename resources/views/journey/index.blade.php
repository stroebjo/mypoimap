@extends('layouts.app')

@section('content')

<div class="container">
    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ __('Journeys') }}</h1>

        <div>
            <a class="btn btn-sm btn-primary" href="{{ route('journey.create', []) }}">{{ __('Add new journey') }}</a>
        </div>
    </header>

    <table id="journeystable" class="table">
        <thead>
            <tr>
                <th>{{ __('Name')}}</th>
                <th>{{ __('Start')}}</th>
                <th>{{ __('End')}}</th>
                <th>{{ __('Nights')}}</th>
                <th class="no-sort text-right">{{ __('Actions')}}</th>
            </tr>
        </thead>

        <tbody>

        @foreach($journeys as $journey)

        <tr>
            <td>
                <a class="" href="{{ route('journey.show', [$journey->id]) }}">{{ $journey->title }}</a>
            </td>

            <td>
                {{ $journey->start->toDateString() }}
            </td>
            <td>
                {{ $journey->end->toDateString() }}
            </td>
            <td>
                {{ $journey->nights }}
            </td>
            <td>
                <div class="d-flex justify-content-end">

                    <a class="ml-1 btn btn-sm btn-secondary" href="{{ route('journey.edit', [$journey]) }}">{{ __('Edit')}}</a>

                    <form class="ml-1" method="POST" action="{{ route('journey.destroy', [$journey->id]) }}">
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

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#journeystable').DataTable({
                "pageLength": 50,

                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ]

            });
        } );
    </script>
@endsection
