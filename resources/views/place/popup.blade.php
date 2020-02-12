<div class="m-popup">

    @if(!empty($title) && $title === true)
    <h4 class="h5 m-popup-title">
        <a href="{{ route('place.show', [$place]) }}" class="invisible-link">{{ $place->title }}</a>
    </h4>
    @endif

    @include('place.popup.meta', ['place' => $place])

    <div class="m-popup-description">
        @parsedown($place->description)
    </div>


    @if($place->visits()->count() > 0)
    @foreach($place->visits as $visit)
    <div class="mb-3">
        <div class="mb-2">
            <div class="m-contentheader mb-0">
                <span class="">
                    {{__('Visited at :date', ['date' => $visit->visited_at->toDateString()]) }}
                    @if($visit->journey_id)
                        <small><a href="{{ route('journey.show', [$visit->journey_id]) }}">{{ $visit->journey->title }}</a></small>
                    @endif
                </span>
            </div>
            <small class="text-muted">{{ __('Rating: :rating', ['rating' => $visit->rating ?? '-'])}}</small>
        </div>

        @if(count($visit->getMedia('images')) > 0)
        <div class="m-thumbgallery mb-2">
            <div class="m-thumbgallery-inner js-gallery-poup" style="width: {{ count($visit->getMedia('images')) * 151 }}px;" itemscope itemtype="http://schema.org/ImageGallery">
                @foreach($visit->getMedia('images') as $media)

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

        @parsedown($visit->review)
    </div>
    @endforeach
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
                <a href="{{ route('place.edit', ['place' => $place->id]) }}">{{ __('Edit')}}</a> |
                <a href="{{ route('visit.create', ['place_id' => $place->id, 'journey_id' => ($journey->id ?? null)]) }}">{{ __('Add visit')}}</a>

            </small>
        @endauth
    @endif
</div>
