@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ __('Settings') }}</h1>

        <div>
        </div>
    </header>

    <div>

        <ul>
            <li><a href="{{ route('settings.place_ids') }}">{{ __('Refresh Google place_id\'s') }}</a></li>

        </ul>

    </div>


</div>

@endsection
