@extends('layouts.app')

@section('title', $annotation->name)

@section('content')
<article>

    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ $annotation->name }}</h1>

        <div>
            <a class="btn btn-sm btn-outline-secondary me-1" download="{{ $annotation->file_name }}." href="{{ $annotation->url }}">{{ __('Download')}} @svg('desktop-download')</a>

            @auth
                <a class="btn btn-sm btn-outline-primary" href="{{ route('annotation.edit', [$annotation]) }}">{{ __('Edit') }}</a>
            @endauth
        </div>
    </header>

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="mb-3">
                @parsedown($annotation->description)
            </div>

            <table class="table table-sm">
                <caption>{{ __('Entries this annotation is linked to') }}</caption>
                <thead>
                    <tr>
                        <th>{{ __('Type')}}</th>
                        <th>{{ __('Name')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($annotation->places as $place)
                <tr>
                    <td>
                        {{ __('Place')}}
                    </td>
                    <td>
                        <a href="{{ route('place.show', [$place->id]) }}">
                            {{ $place->title }}
                        </a>
                    </td>
                </tr>
                @endforeach

                @foreach($annotation->journeys as $journey)
                <tr>
                    <td>
                        {{ __('Journey')}}
                    </td>
                    <td>
                        <a href="{{ route('journey.show', [$journey->id]) }}">
                            {{ $journey->title }}
                        </a>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>

        </div>

        <div class="col-12 col-lg-4">
            <div style="position: sticky; top: 15px; z-index: 20;">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
        </div>
    </div>
</article>
@endsection

@section('script')

@include('javascript.leaflet', [
    'id' => 'map',
    'annotations' => [$annotation],
])

<script>
window.addEventListener("load", function() {

});
</script>
@endsection
