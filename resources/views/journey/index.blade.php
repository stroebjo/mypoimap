@extends('layouts.app')

@section('content')
<header class="m-contentheader d-sm-flex justify-content-between">
    <h1 class="h2">{{ __('Journeys') }}</h1>

    <div>
        <a class="btn btn-sm btn-primary" href="{{ route('journey.create', []) }}">{{ __('Add new journey') }}</a>
    </div>
</header>

<table id="journeystable" class="table table-sm">
    <thead>
        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Start')}}</th>
            <th>{{ __('End')}}</th>
            <th class="desktop">{{ __('Nights')}}</th>
            <th class="no-sort text-end">{{ __('Actions')}}</th>
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
                @if ($journey->mode == 'visible_by_link')
                    <a class="me-1 btn btn-sm btn-outline-secondary" href="{{ route('shared_journey.show', [$journey->uuid]) }}">
                        {{ __('Public link')}} @svg('link-external')
                    </a>
                @endif

                <a class="btn btn-sm btn-outline-secondary" href="{{ route('journey.edit', [$journey]) }}">{{ __('Edit')}}</a>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection

@section('script')

@include('javascript.datatable', ['el' => '#journeystable'])

@endsection
