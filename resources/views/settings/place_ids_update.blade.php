@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ __('Google place_id\'s') }}</h1>

        <div>
        </div>
    </header>

    <div>

        <p>
            The following results where obtained from the Google Maps API. Results with anoter status than <code>OK</code> you need to update manually.
        </p>

        <p>
            <a href="{{ route('settings.place_ids') }}">Back to overview</a>
        </p>

        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>{{ __('Place')}}</th>
                    <th>{{ __('place_id')}}</th>
                    <th>{{ __('Status')}}</th>
                    <th>{{ __('Message')}}</th>
                </tr>
            </thead>

            <tbody>
            @foreach($results as $result)
            <tr class="{{ ($result->status !== 'OK') ? 'table-danger' : '' }}">
                <td>
                    <a href="{{route('place.show', [$result->place]) }}">
                        {{ $result->place->title }}
                    </a>
                </td>

                <td class="text-nowrap">
                    <code>{{ $result->place->google_place_id }}</code>
                    <a class="ml-2" href="{!! $result->place->google_maps_details_link !!}" target="_blank">
                        @svg('link-external', 'icon--currentColor')
                    </a>
                </td>
                <td><code>{{ $result->status}}</code></td>
                <td>
                    {{ $result->error_message}}
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>

    </div>


</div>

@endsection
