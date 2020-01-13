<table id="poitable" class="table table-hover table-sm table-vertical-align-middle">
    <thead>
        <tr>
            @if(!empty($number) && $number === true)
            <th class="all">#</th>
            @endif
            <th class="all">{{ __('Name')}}</th>
            <th class="all">{{ __('Prio')}}</th>
            <th class="desktop">{{ __('Category')}}</th>
            <th class="all no-sort text-right">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>
    @foreach($places as $place)
    <tr class="js-poitablesm-row" data-index="{{ $loop->index }}">

        @if(!empty($number) && $number === true)
        <td class="text-right">{{ $loop->iteration }}</td>
        @endif

        <td>
            {{ $place->title }}

            @if ($place->url != '')
            <a class="ml-2" href="{{$place->url}}">
                @svg('link-external', 'icon--currentColor')
            </a>
            @endif

            {{-- Description in hidden container so DataTables can search in description... --}}
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
            <div class="d-flex justify-content-end">

                <a href="{!! $place->google_maps_details_link !!}" rel="noreferrer" aria-label="{{ __('Open in Google Maps') }}"
                    class="ml-1 btn btn-sm btn-outline-primary">
                    @svg('google-maps')
                </a>
                <a href="{!! $place->google_maps_directions_link !!}" rel="noreferrer" aria-label="{{ __('Directions') }}"
                    class="ml-1 btn btn-sm btn-outline-primary">@svg('directions')
                </a>

                <button  data-toggle="modal" data-target="#modal-place{{ $loop->index }}" class="ml-2 btn btn-sm btn-outline-primary js-open-modal">{{ __('Info')}}</button>

                @if(!empty($edit) && $edit === true)
                <a class="ml-1 d-none d-sm-inline btn btn-sm btn-outline-secondary" href="{{ route('place.edit', [$place]) }}">{{ __('Edit')}}</a>
                @endif

                @if(!empty($delete) && $delete === true)
                <form class="ml-1 d-none d-sm-inline" method="POST" action="{{ route('place.destroy', [$place->id]) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('Delete') }}</button>
                </form>
                @endif

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
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @include('place.popup', [
                    'place' => $place,
                    'title' => false,
                    'controls' => false,
                ])
            </div>


            <div class="modal-footer">
                @auth
                <a class="btn btn-sm btn-outline-primary" href="{{ route('place.edit', ['place' => $place->id]) }}">{{ __('Edit')}}</a>
                @endauth

                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>


        </div>
    </div>
</div>
@endforeach
