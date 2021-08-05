@extends('layouts.app')

@section('content')
<header class="m-contentheader d-sm-flex justify-content-between">
    <h1 class="h2">{{ __('Filters') }}</h1>

    <div>
        <a class="btn btn-sm btn-primary" href="{{ route('filter.create', []) }}">{{ __('Add new filter') }}</a>
    </div>
</header>

<table id="poitable" class="table table-sm">
    <thead>
        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Places')}}</th>
            <th class="no-sort text-right">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>

    @foreach($filters as $filter)

    <tr>
        <td>
            {{ $filter->title }}

            <a class="" href="{{ route('filter.map', [$filter->id]) }}">{{ __('Map')}}</a>
        </td>

        <td>
            {{ $filter->places()->count() }}
        </td>

        <td>
            <div class="d-flex justify-content-end">

                @if ($filter->mode == 'visible_by_link')
                    <a class="ml-1 btn btn-sm btn-outline-secondary" href="{{ route('filter.sahredmap', [$filter->uuid]) }}">
                        {{ __('Public map')}} @svg('link-external')
                    </a>
                @endif

                <a class="ml-1 btn btn-sm btn-outline-secondary" href="{{ route('filter.edit', [$filter]) }}">{{ __('Edit')}}</a>

                <form class="ml-1" method="POST" action="{{ route('filter.destroy', [$filter->id]) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('Delete') }}</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection

@section('script')

@include('javascript.datatable', ['el' => '#poitable'])

@endsection
