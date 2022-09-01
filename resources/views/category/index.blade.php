@extends('layouts.app')

@section('content')
<header class="m-contentheader d-sm-flex justify-content-between">
    <h1 class="h2">{{ __('Categories') }}</h1>

    <div>
        <a class="btn btn-sm btn-primary" href="{{ route('user_category.create', []) }}">{{ __('Add new category') }}</a>
    </div>
</header>

<table id="user_category_table" class="table table-sm table-hover">

    <thead>
        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Places')}}</th>
            <th>{{ __('Order')}}</th>
            <th class="no-sort text-end">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>

    @foreach($categories as $category)

    <tr>
        <td>
            @include('category.badge', ['user_category' => $category])
        </td>

        <td>
            {{ $category->places->count() }}
        </td>

        <td>
            {{ $category->order }}
        </td>

        <td>
            <div class="d-flex justify-content-end">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('user_category.edit', [$category->id]) }}">{{ __('Edit') }}</a>
            </div>
        </td>
    </tr>

    @endforeach
    </tbody>

</table>
@endsection

@section('script')
@include('javascript.datatable', ['el' => '#user_category_table', 'opts' => [
    'info' => false,
    'paging' => false,
    'searching' => false,
]])
@endsection
