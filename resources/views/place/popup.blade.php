<div class="m-popup">

    @if(!empty($title) && $title === true)
    <h4 class="h5 m-popup-title">
        {{ $place->title }}
    </h4>
    @endif

    @include('place.popup.meta', ['place' => $place])

    <div class="m-popup-description">
        @parsedown($place->description)
    </div>

    @if(count($place->getMedia('images')) > 0)
    <div class="m-thumbgallery">
        <div class="m-thumbgallery-inner my-gallery" style="width: {{ count($place->getMedia('images')) * 151 }}px;" itemscope itemtype="http://schema.org/ImageGallery">
            @foreach($place->getMedia('images') as $media)

            <figure class="mb-0" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                <a href="{{ $media->getUrl('gallery') }}" itemprop="contentUrl" data-size="1200x800">
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

    @if (!is_null($place->visited_at))
        <div class="m-popup-review">
        <hr>
        <b>{{ __('was there at :date:', ['date' => $place->visited_at]) }}</b><br>
        @parsedown($place->visit_review)
        </div>
    @endif

    @if(!empty($controls) && $controls === true)
        @auth
            <hr>
            <small>
                <a href="{{ route('place.show', ['place' => $place->id]) }}">{{ __('Details')}}</a> |
                <a href="{{ route('place.edit', ['place' => $place->id]) }}">{{ __('Edit')}}</a>
            </small>
        @endauth
    @endif
</div>
