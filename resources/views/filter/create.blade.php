@extends('layouts.app')

@section('head')
@vite('resources/js/vue.js')
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

