@extends('layouts.app')

@section('title', __('Annotations'))


@section('content')

<header class="m-contentheader d-sm-flex justify-content-between">
    <h1 class="h2">{{ __('Annotations') }}</h1>

    <div>
        <a class="btn btn-sm btn-primary" href="{{ route('annotation.create') }}">{{ __('Add new annotation') }}</a>
    </div>
</header>

<table id="annotationtable" class="table table-hover table-sm table-vertical-align-middle">
    <thead>
        <tr>
            <th class="all">{{ __('Name')}}</th>
            <th class="all no-sort text-end">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>
    @foreach($annotations as $annotation)
    <tr>
        <td>
            <a href="{{ route('annotation.show', $annotation->id) }}">{{ $annotation->name }}</a>
        </td>

        <td>
            <div class="d-flex justify-content-end">
                <a class="ms-1 d-none d-sm-inline btn btn-sm btn-outline-secondary" href="{{ route('annotation.edit', [$annotation]) }}">{{ __('Edit')}}</a>
            </div>
        </td>
    </tr>

    @endforeach
    </tbody>

</table>
@endsection

@section('script')
@include('javascript.datatable', ['el' => '#annotationtable'])
@endsection
