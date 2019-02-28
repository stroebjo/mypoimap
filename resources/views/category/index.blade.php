@extends('layouts.app')

@section('content')
<table class="table">

    <thead>
        <tr>
            <th>{{ __('Name')}}</th>
            <th>{{ __('Places')}}</th>
            <th>{{ __('Actions')}}</th>
        </tr>
    </thead>

    <tbody>

    @foreach($categories as $category)

    <tr>
        <td>
            {{ $category->name }}
            <span style="display: inline-block; width: 1em; height: 1em; background: {{ $category->color }}"></span>
        </td>

        <td>
            {{ $category->places->count() }}
        </td>

        <td>
            <a href="{{ route('user_category.edit', [$category->id]) }}">{{ __('Edit') }}</a> |

            <form method="POST" action="{{ route('user_category.destroy', [$category->id]) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit">{{ __('Delete') }}</button>
            </form>
        </td>
    </tr>

    @endforeach
    </tbody>

</table>

<a href="{{ route('user_category.create', []) }}">{{ __('Add new category') }}</a>

@endsection


