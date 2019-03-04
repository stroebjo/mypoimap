<div class="m-popup">

    <h4 class="m-popup-title">
        @if ($place->url != '')
        <a href="{{$place->url}}">
        @endif
        {{ $place->title }}
        @if ($place->url != '')
        </a>
        @endif
    </h4>

    <small>
        <a href="{!! $place->google_maps_details_link !!}" rel="noreferrer">{{ __('Maps') }}</a> |
        <a href="{!! $place->google_maps_directions_link !!}" rel="noreferrer">{{ __('Directions') }}</a> |
        {{ $place->getLatLng() }} |
        Prio: {{ $place->priority }}
    </small>

    @if ($place->tags->count() > 0)
        <ul style="list-style: none; padding: 0; margin: 0 0 1rem" class="d-flex">
        @foreach($place->tags as $tag)
            <li class="mr-2">
                <a rel="tag" class="" href="#">
                    #{{ $tag->name }}
                </a>
            </li>
        @endforeach
        </ul>
    @endif

    <div class="m-popup-description">
    {!! $place->getHTMLDescription() !!}
    </div>

    @if(count($place->getMedia('images')) > 0 )
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
        {!! $place->getHTMLReview() !!}
        </div>


    @endif

    <hr>

    <small>
        <!-- <a href="{{ route('place.show', ['id' => $place->id]) }}">{{ __('Details')}}</a> -->
        <a href="{{ route('place.edit', ['id' => $place->id]) }}">{{ __('Edit')}}</a>
    </small>

</div>
