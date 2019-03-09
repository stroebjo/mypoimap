@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endsection

@section('content')

<div class="container">

<div class="card">
    <div class="card-body">

<table id="user_category_table" class="table table-sm table-hover">

    <thead>
        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Places')}}</th>
            <th class="no-sort text-right">{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>

    @foreach($categories as $category)

    <tr>
        <td>
            {{ $category->name }}
            <span class="badge" style="display: inline-block; width: 1em; height: 1em; background: {{ $category->color }}"></span>
        </td>

        <td>
            {{ $category->places->count() }}
        </td>

        <td>

            <div class="d-flex justify-content-end">

            <a class="btn btn-sm btn-secondary" href="{{ route('user_category.edit', [$category->id]) }}">{{ __('Edit') }}</a>

            <form class="ml-1" method="POST" action="{{ route('user_category.destroy', [$category->id]) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="btn btn-sm btn-danger{{ (($category->places->count() > 0) ? ' js-category-not_empty disabled' : '') }}" type="submit">{{ __('Delete') }}</button>
            </form>

        </div>
        </td>
    </tr>

    @endforeach
    </tbody>

</table>

<hr>

<a class="btn btn-primary" href="{{ route('user_category.create', []) }}">{{ __('Add new category') }}</a>

</div>

</div>
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



