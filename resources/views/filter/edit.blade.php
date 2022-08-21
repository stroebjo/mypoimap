@extends('layouts.app')

@section('head')
@vite('resources/js/vue.js')
<script>
    const filter_edit = {
        id: {{ $filter->id }},
        title: '{{ $filter->title }}',
        visibility: '{{ $filter->mode }}',
        filter_operator: '{{ $filter->options['filter_operator'] }}',
        filters: {!! json_encode($filter->options['filters']) !!}
    };
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Filter') }}</div>

                <div class="card-body">

                    <filter-component></filter-component>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
