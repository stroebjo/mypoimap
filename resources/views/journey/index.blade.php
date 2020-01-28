@extends('layouts.app')

@section('content')

<div class="container-fluid">
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
                    @if ($journey->mode == 'visible_by_link')
                        <a class="ml-1 btn btn-sm btn-outline-secondary" href="{{ route('shared.journey', [$journey->uuid]) }}">
                            {{ __('Public link')}} @svg('link-external')
                        </a>
                    @endif

                    <a class="ml-1 btn btn-sm btn-outline-secondary" href="{{ route('journey.edit', [$journey]) }}">{{ __('Edit')}}</a>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')

@include('javascript.datatable', ['el' => '#journeystable'])

@endsection
