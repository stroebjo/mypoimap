<div class="m-popup">

    @if(!empty($title) && $title === true)
    <h4 class="h5 m-popup-title">
        {{ $place->title }}
    </h4>
    @endif

    <div class="small mb-2">
        <span>Prio: {{ $place->priority }}</span> | 

        <span>
            <span class="badge" style="display: inline-block; width: 1em; height: 1em; background: {{ $place->user_category->color }}"></span>
            {{ $place->user_category->name }}
        </span>

        | <a href="{!! $place->geo_uri !!}" rel="noreferrer">{{ $place->getLatLng(',') }}</a>

        @if ($place->tags->count() > 0)
        | <div style="display: inline-block"><ul style="list-style: none; padding: 0; margin: 0" class="d-flex">
        @foreach($place->tags as $tag)
            <li class="mr-2">
                <a rel="tag" class="" href="#">
                    #{{ $tag->name }}
                </a>
            </li>
        @endforeach
        </ul></div>
        @endif
    </div>

    <div class="mb-2">

        @if ($place->url != '')
            <a class="btn btn-sm btn-outline-primary mr-1" href="{{$place->url}}" target="_blank" rel="noreferrer">@svg('link-external')</a>
        @endif

        @if ($place->wikipedia_url != '')
            <a class="btn btn-sm btn-outline-primary mr-1" href="{{$place->wikipedia_url}}" target="_blank" rel="noreferrer">@svg('wikipedia')</a>
        @endif

        @if (!empty($place->unesco_world_heritage))
            <a class="btn btn-sm btn-outline-primary mr-1" href="{!! $place->unesco_world_heritage_link !!}" target="_blank" rel="noreferrer">{{ __('UNESCO') }}</a>
        @endif

        <a class="btn btn-sm btn-outline-primary mr-1" href="{!! $place->google_maps_details_link !!}" target="_blank" rel="noreferrer">@svg('google-maps')</a>
        <a class="btn btn-sm btn-outline-primary mr-1" href="{!! $place->google_maps_directions_link !!}" target="_blank" rel="noreferrer">@svg('directions')</a>
    </div>

    <div class="m-popup-description">
        @parsedown($place->description)
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
        @parsedown($place->visit_review)
        </div>


    @endif


    @if(!empty($controls) && $controls === true)
    @auth
    <hr>

    <small>
        <!-- <a href="{{ route('place.show', ['place' => $place->id]) }}">{{ __('Details')}}</a> -->
        <a href="{{ route('place.edit', ['place' => $place->id]) }}">{{ __('Edit')}}</a>
    </small>
    @endauth
    @endif
</div>
