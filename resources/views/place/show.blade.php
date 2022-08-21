@extends('layouts.app')

@section('title', $place->title)

@section('content')
<article>

    <header class="m-contentheader d-sm-flex justify-content-between">
        <h1 class="h2">{{ $place->title }}</h1>

        <div>
            @auth
                <a class="btn btn-sm btn-outline-primary me-1" href="{{ route('visit.create', ['place_id' => $place->id]) }}">{{ __('Add visit')}}</a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('place.edit', [$place]) }}">{{ __('Edit') }}</a>
            @endauth
        </div>
    </header>

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="mb-3">

                @include('place.popup.meta', ['place' => $place])

                @parsedown($place->description)


                @if(count($place->getMedia('images')) > 0)
                <div class="m-thumbgallery mb-2">
                    <div class="m-thumbgallery-inner js-gallery-visit" style="width: {{ count($place->getMedia('images')) * 151 }}px;" itemscope itemtype="http://schema.org/ImageGallery">
                        @foreach($place->getMedia('images') as $media)

                        @php
                        $info = getimagesize($media->getPath('gallery'));
                        $width = $info[0];
                        $height = $info[1];
                        @endphp

                        <figure class="mb-0" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                            <a href="{{ $media->getUrl('gallery') }}" data-pswp-height="{{ $height }}" data-pswp-width="{{ $width }}" itemprop="contentUrl">
                                <img src="{{ $media->getUrl('thumb') }}" itemprop="thumbnail" alt="Image description" />
                            </a>

                            @if ($media->hasCustomProperty('caption'))
                            <figcaption itemprop="caption description">{{ $media->getCustomProperty('caption') }}</figcaption>
                            @endif
                        </figure>

                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            @if($place->visits()->count() > 0)
                @foreach($place->visits as $visit)
                <div class="mb-3">
                    <div class="mb-2">
                        <div class="m-contentheader d-sm-flex justify-content-between mb-0">
                            <h5 class="">
                                {{__('Visited at :date', ['date' => $visit->visited_at->toDateString()]) }}
                                @if($visit->journey_id)
                                    <small><a href="{{ route('journey.show', [$visit->journey_id]) }}">{{ $visit->journey->title }}</a></small>
                                @endif
                            </h5>
                            <div class="mb-1">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('visit.edit', ['visit' => $visit]) }}">{{ __('Edit')}}</a>
                            </div>
                        </div>
                        <small class="text-muted">{{ __('Rating: :rating', ['rating' => $visit->rating ?? '-'])}}</small>
                    </div>

                    @if(count($visit->getMedia('images')) > 0)
                    <div class="m-thumbgallery mb-2">
                        <div class="m-thumbgallery-inner js-gallery-visit" style="width: {{ count($visit->getMedia('images')) * 151 }}px;" itemscope itemtype="http://schema.org/ImageGallery">
                            @foreach($visit->getMedia('images') as $media)

                            @php
                            $info = getimagesize($media->getPath('gallery'));
                            $width = $info[0];
                            $height = $info[1];
                            @endphp

                            <figure class="mb-0" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                <a href="{{ $media->getUrl('gallery') }}" data-pswp-height="{{ $height }}" data-pswp-width="{{ $width }}" itemprop="contentUrl">
                                    <img src="{{ $media->getUrl('thumb') }}" itemprop="thumbnail" alt="Image description" />
                                </a>

                                @if ($media->hasCustomProperty('caption'))
                                <figcaption itemprop="caption description">{{ $media->getCustomProperty('caption') }}</figcaption>
                                @endif
                            </figure>

                            @endforeach
                        </div>
                    </div>
                    @endif

                    @parsedown($visit->review)
                </div>
                @endforeach
            @endif

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
    'places' => [$place],
])

<script>
window.addEventListener("load", function() {
    const lightbox = new PhotoSwipeLightbox({
    gallery: '.js-gallery-visit',
    children: 'a',
    pswpModule: PhotoSwipe
    });
    lightbox.init();
});
</script>
@endsection
