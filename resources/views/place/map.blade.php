@extends('layouts.app')

@section('mainclass', '')


@section('content')
<noscript>
    <div class="alert alert-warning">{{ __('You need JavaScript enabled for map features.')}}</div>
</noscript>

<div id="map"></div>
@endsection

@section('script')
@include('javascript.leaflet', [
    'places' => $places,
    'cluster' => true,
    'check_for_saved_location' => true,
    'check_for_query_location' => true,
])
@endsection
