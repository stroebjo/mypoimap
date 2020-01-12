<table id="poitablesm" class="table table-hover table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Prio')}}</th>
            <th>{{ __('Category')}}</th>
            <th class="no-sort">{{ __('Location')}}</th>
            <th class="no-sort text-right">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>
    @foreach($places as $place)
    <tr class="js-poitablesm-row" data-index="{{ $loop->index }}">
        <td>{{ $loop->iteration }}</td>
        <td>
            @if ($place->url != '')
            <a href="{{$place->url}}">
            @endif
            {{ $place->title }}
            @if ($place->url != '')
            </a>
            @endif

            <div style="display: none">
                {{ $place->description }}
            </div>
        </td>

        <td>
            {{ $place->priority }}
        </td>

        <td>
            <span class="badge" style="display: inline-block; width: 1em; height: 1em; background: {{ $place->user_category->color }}"></span>
            {{ $place->user_category->name }}
        </td>

        <td>
            <a href="{!! $place->google_maps_details_link !!}" rel="noreferrer">{{ __('Maps') }}</a> |
            <a href="{!! $place->google_maps_directions_link !!}" rel="noreferrer">{{ __('Directions') }}</a>
        </td>

        <td>
            <div class="d-flex justify-content-end">
                <button  data-toggle="modal" data-target="#modal-place{{ $loop->index }}" class="btn btn-sm btn-primary js-open-modal">{{ __('Info')}}</button>
            </div>
        </td>
    </tr>

    @endforeach
    </tbody>

</table>


@foreach($places as $place)

<!-- Modal -->
    <div class="modal" id="modal-place{{ $loop->index }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $place->title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                @include('place.popup', ['place' => $place])
        </div>
        </div>
    </div>
    </div>
@endforeach
