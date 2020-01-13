@extends('layouts.app')

@section('content')

<div class="container-fluid">

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
            <th class="no-sort text-right">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>

    @foreach($categories as $category)

    <tr>
        <td>
            <span class="badge" style="display: inline-block; width: 1em; height: 1em; background: {{ $category->color }}"></span>
            {{ $category->name }}
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

            <form class="ml-1" method="POST" action="{{ route('user_category.destroy', [$category->id]) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="btn btn-sm btn-outline-danger{{ (($category->places->count() > 0) ? ' js-category-not_empty disabled' : '') }}" type="submit">{{ __('Delete') }}</button>
            </form>

        </div>
        </td>
    </tr>

    @endforeach
    </tbody>

</table>

</div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#user_category_table').DataTable({
                "pageLength": 50,

                "info": false,
                "paging": false,
                "searching": false,

                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ]
            });
        } );


        $('.js-category-not_empty').on('click', function(e) {
            e.preventDefault();
            alert('{{ __('You can not delete a category that has places.') }}');
        });
    </script>
@endsection



