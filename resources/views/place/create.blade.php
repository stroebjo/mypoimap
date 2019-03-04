@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Place') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('place.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="user_category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                            <div class="col-md-6">

                                <select id="user_category_id" class="form-control{{ $errors->has('user_category_id') ? ' is-invalid' : '' }}"  name="user_category_id" required>
                                @foreach($categories as $category)
                                    <option {{ old('user_category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name}}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('user_category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('Website') }}</label>

                            <div class="col-md-6">
                                <input id="url" type="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ old('url') }}">

                                @if ($errors->has('url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Priority') }}</label>

                            <div class="col-md-6">
                                <input id="priority" type="number" min="0" max="5" step="1" class="form-control{{ $errors->has('priority') ? ' is-invalid' : '' }}" name="priority" value="{{ old('priority') }}" required>
                                <small class="form-text text-muted">{{ __('A value between 0 and 5, where 5 is a must see and 0 is not important.') }}</small>

                                @if ($errors->has('priority'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Tags') }}</label>

                            <div class="col-md-6">
                                <input id="tags" type="text" class="form-control{{ $errors->has('tags') ? ' is-invalid' : '' }}" name="tags" value="{{ old('tags') }}" required>

                                <small class="form-text text-muted">{{ __('Seperated by commas.') }}</small>


                                @if ($errors->has('tags'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tags') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">

                                <textarea rows="8" id="description"  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('lng') }}</textarea>
                                <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lat" class="col-md-4 col-form-label text-md-right">{{ __('Lat') }}</label>

                            <div class="col-md-6">
                                <input id="lat" type="text" class="form-control{{ $errors->has('lat') ? ' is-invalid' : '' }}" name="lat" value="{{ old('lat') }}" required>

                                @if ($errors->has('lat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lng" class="col-md-4 col-form-label text-md-right">{{ __('Lng') }}</label>

                            <div class="col-md-6">
                                <input id="lng" type="text" class="form-control{{ $errors->has('lng') ? ' is-invalid' : '' }}" name="lng" value="{{ old('title') }}" required>

                                @if ($errors->has('lng'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lng') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">

                            <div class="col-md-4 text-md-right">

                                <span class="col-form-label">
                                    <label for="google_place_id" class=" col-form-label">{{ __('Google Place ID') }}</label>

                                    <button type="button" class="" data-toggle="modal" data-target="#modal_google_place_id">
                                        ?
                                    </button>
                                </span>
                            </div>


                            <div class="col-md-6">
                                <input id="google_place_id" type="text" class="form-control{{ $errors->has('google_place_id') ? ' is-invalid' : '' }}" name="google_place_id" value="{{ old('google_place_id') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">

                                <small class="form-text text-muted"><a href="https://developers.google.com/places/place-id" rel="noreferrer" target="_blank">{{ __('Google Place ID finder.') }}</a></small>


                                @if ($errors->has('google_place_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('google_place_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@include('place.google_place_id_modal')

@endsection
