<div>
    <div class="small mb-2">
        <span>Prio: {{ $place->priority }}</span> | 

        @include('category.badge', ['user_category' => $place->user_category])

        | <a href="{!! $place->geo_uri !!}" rel="noreferrer">{{ $place->getLatLng(', ', 5) }}</a>

        @if ($place->tags->count() > 0)
        | <div style="display: inline-block"><ul style="list-style: none; padding: 0; margin: 0" class="d-flex">
        @foreach($place->tags as $tag)
            <li class="me-2">
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
            <a class="btn btn-sm btn-outline-primary me-1" href="{{$place->url}}" target="_blank" rel="noreferrer">@svg('link-external')</a>
        @endif

        @if ($place->wikipedia_url != '')
            <a class="btn btn-sm btn-outline-primary me-1" href="{{$place->wikipedia_url}}" target="_blank" rel="noreferrer">@svg('wikipedia')</a>
        @endif

        @if (!empty($place->unesco_world_heritage))
            <a class="btn btn-sm btn-outline-primary me-1" href="{!! $place->unesco_world_heritage_link !!}" target="_blank" rel="noreferrer">{{ __('UNESCO') }}</a>
        @endif

        <a class="btn btn-sm btn-outline-primary me-1" href="{!! $place->google_maps_details_link !!}" target="_blank" rel="noreferrer">@svg('google-maps')</a>
        <a class="btn btn-sm btn-outline-primary me-1" href="{!! $place->google_maps_directions_link !!}" target="_blank" rel="noreferrer">@svg('directions')</a>
    </div>
</div>
