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
        <a href="https://www.google.com/maps/search/?api=1&query={{ $place->location->getLat() }},{{ $place->location->getLng() }}">{{ __('Maps') }}</a> |
        <a href="http://maps.google.com/maps?f=d&daddr={{ $place->location->getLat() }},{{ $place->location->getLng() }}">{{ __('Directions') }}</a> |
        {{ $place->location->getLat() }}, {{ $place->location->getLng()}} |
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

</div>
