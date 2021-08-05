@extends('layouts.app')

@section('content')

<header class="m-contentheader d-sm-flex justify-content-between">
    <h1 class="h2">{{ __('Google place_id\'s') }}</h1>

    <div>
    </div>
</header>

<div>

    <p>
        Google <code>place_id</code>s are used to directly link to a place inside Google Maps. Google <a href="https://developers.google.com/maps/documentation/places/web-service/place-id#save-id">recommends</a> to refresh them at least every 12 months.
    </p>

    <p>
        The following <b>{{ count($places) }}</b> places have <code>place_id</code>s older than 12 months. Refreshing them now will validate the die ID and update their date. If an ID is no longer valid you need to update them by hand and search with the <a href="https://developers.google.com/maps/documentation/places/web-service/place-id">place ID tool</a> for the new IDs.
    </p>

    <p>
        <a href="https://developers.google.com/maps/documentation/places/web-service/place-id#refresh-id">Refreshing <code>place_id</code>s</a> is provided free of chrage by Google. You still need to have a Google Maps API Key with billing though. If you not have a API key you can always check the IDs yourself with the place ID tool.
    </p>

    @if(empty(env('GOOGLE_MAPS_API_KEY')))
        <div class="alert alert-danger">There is no Google Maps API key defined in your <code>.env</code> file. Please set the <code>GOOGLE_MAPS_API_KEY</code> variable first.</div>
    @endif

    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>{{ __('Place')}}</th>
                <th>{{ __('place_id')}}</th>
                <th>{{ __('Date')}}</th>
            </tr>
        </thead>

        <tbody>
        @foreach($places as $place)
        <tr>
            <td>
                <a href="{{route('place.show', [$place]) }}">
                    {{ $place->title }}
                </a>
            </td>
            <td class="text-nowrap">
                <code>{{ $place->google_place_id }}</code>
                <a class="ml-2" href="{!! $place->google_maps_details_link !!}" target="_blank">
                    @svg('link-external', 'icon--currentColor')
                </a>
            </td>
            <td>
                {{ $place->google_place_id_date->format('Y-m-d') }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('settings.update_place_ids') }}">
        @csrf

        <div class="d-flex justify-content-between">
            <div>{{-- for justify-content-between --}}</div>

            <div>
                <button type="submit" class="ml-3 btn btn-primary">
                    {{ __('Check place_id\'s') }}
                </button>
            </div>
        </div>
    </form>

</div>

@endsection
