@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Place') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('place.update', [$place]) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $place->title) }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                                <label for="user_category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                                <div class="col-md-6">

                                    <select id="user_category_id" class="form-select{{ $errors->has('user_category_id') ? ' is-invalid' : '' }}"  name="user_category_id" required>
                                    @foreach($categories as $category)
                                        <option {{ old('user_category_id', $place->user_category_id ) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name}}</option>
                                    @endforeach
                                    </select>

                                    @if ($errors->has('user_category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user_category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        <div class="mb-3 row">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('Website') }}</label>

                            <div class="col-md-6">
                                <input id="url" type="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ old('url', $place->url) }}">

                                @if ($errors->has('url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="wikipedia_url" class="col-md-4 col-form-label text-md-right">{{ __('Wikipedia') }}</label>

                            <div class="col-md-6">
                                <input id="wikipedia_url" type="url" class="form-control{{ $errors->has('wikipedia_url') ? ' is-invalid' : '' }}" name="wikipedia_url" value="{{ old('wikipedia_url', $place->wikipedia_url) }}">

                                @if ($errors->has('wikipedia_url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('wikipedia_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Priority') }}</label>

                            <div class="col-md-6">
                                <input id="priority" type="number" min="0" max="5" step="1" class="form-control{{ $errors->has('priority') ? ' is-invalid' : '' }}" name="priority" value="{{ old('priority', $place->priority) }}" required>
                                <small class="form-text text-muted">{{ __('A value between 0 and 5, where 5 is a must see and 0 is not important.') }}</small>

                                @if ($errors->has('priority'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Tags') }}</label>

                            <div class="col-md-6">
                                <input id="tags" type="text" class="form-control{{ $errors->has('tags') ? ' is-invalid' : '' }}" name="tags" value="{{ old('tags', $place->getTagsAsString()) }}">

                                <small class="form-text text-muted">{{ __('Seperated by commas.') }}</small>


                                @if ($errors->has('tags'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tags') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="description" class="">{{ __('Description') }}</label>
                            <textarea rows="8" id="description"  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description', $place->description) }}</textarea>
                            <small class="form-text text-muted">{{ __('You can use Markdown.') }}</small>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-4 text-md-right">
                                <label for="lat" class="col-form-label">{{ __('Lat') }}</label> /
                                <label for="lng" class="col-form-label">{{ __('Lng') }}</label>
                            </div>

                            <div class="col-md-6">

                                <div class="mb-3 row">
                                    <div class="col-6">
                                        <input id="lat" type="text" class="form-control{{ $errors->has('lat') ? ' is-invalid' : '' }}" name="lat" value="{{ old('lat', $place->location->latitude) }}" required>

                                        @if ($errors->has('lat'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lat') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-6">
                                        <input id="lng" type="text" class="form-control{{ $errors->has('lng') ? ' is-invalid' : '' }}" name="lng" value="{{ old('lng', $place->location->longitude) }}" required>

                                        @if ($errors->has('lng'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lng') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label for="plus_code" class="col-md-4 col-form-label col-form-label-sm text-md-right">{{ __('Plus Code') }}</label>

                            <div class="col-md-6">
                                <input id="plus_code" type="text" class="form-control form-control-sm{{ $errors->has('plus_code') ? ' is-invalid' : '' }}" name="plus_code" value="{{ old('plus_code') }}">

                                @if ($errors->has('plus_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('plus_code') }}</strong>
                                    </span>
                                @endif

                                <div class="small js-plus_code_feedback"></div>

                                <small class="text-muted">{{ __('Derive Lat/Lng by Googles Plus Code.') }}</small>


                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-4 text-md-right">

                                <span class="col-form-label">
                                    <label for="google_place_id" class=" col-form-label">{{ __('Google Place ID') }}</label>

                                    <button type="button" class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#modal_google_place_id">
                                        @svg('question')
                                    </button>
                                </span>
                            </div>


                            <div class="col-md-6">
                                <input id="google_place_id" type="text" class="form-control{{ $errors->has('google_place_id') ? ' is-invalid' : '' }}" name="google_place_id" value="{{ old('google_place_id', $place->google_place_id) }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">

                                <small class="form-text text-muted"><a href="https://developers.google.com/places/place-id" rel="noreferrer" target="_blank">{{ __('Google Place ID finder.') }}</a></small>


                                @if ($errors->has('google_place_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('google_place_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="google_place_id_date" name="google_place_id_date">
                                    <label class="form-check-label" for="google_place_id_date">
                                        {{ __('Is the ID up-to-date?') }}
                                    </label>
                                    <small class="form-text text-muted">See <a href="{{ route('settings.place_ids') }}">here</a> for more information.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="unesco_world_heritage" class="col-md-4 col-form-label text-md-right">{{ __('UNESCO World Heritage ID') }}</label>

                            <div class="col-md-6">
                                <input id="unesco_world_heritage" type="text" class="form-control{{ $errors->has('unesco_world_heritage') ? ' is-invalid' : '' }}" name="unesco_world_heritage" value="{{ old('unesco_world_heritage', $place->unesco_world_heritage) }}">

                                <small class="form-text text-muted">Get the ID from the URL of the <a href="https://whc.unesco.org/en/list/" rel="noreferrer" target="_blank">World Heritage List</a> item.</small>

                                @if ($errors->has('unesco_world_heritage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('unesco_world_heritage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>



                        @foreach ($place->getMedia('images') as $media)

                        <div class="row">
                            <div class="col-2">

                                <input type="hidden" name="media_images[{{$loop->index}}][id]" value="{{ $media->id }}">

                                <figure>
                                    <img class="img-fluid" src="{{ $media->getUrl('thumb') }}" alt="" width="100" height="100">
                                </figure>
                            </div>

                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input"  name="media_images[{{$loop->index}}][delete]" type="checkbox" value="1" id="media_images_{{$loop->index}}_delete">
                                    <label class="form-check-label" for="media_images_{{$loop->index}}_delete">
                                        {{ __('Delete media') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach


                        <div class="mb-3 row">
                            <label for="images" class="col-md-4 col-form-label text-md-right">{{ __('Images') }}</label>

                            <div class="col-md-6">
                                <input id="images" type="file" multiple="multiple" class="form-control{{ $errors->has('images') ? ' is-invalid' : '' }}" name="images[]" value="{{ old('images') }}">

                                @if ($errors->has('images'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('images') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route('place.show', [$place]) }}">{{ __('Cancel') }}</a>

                                <button type="submit" class="ms-3 btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>

                    </form>

                    <form class="card-form-delete" method="POST" action="{{ route('place.destroy', [$place->id]) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="btn btn-outline-danger" type="submit">{{ __('Delete') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@include('place.google_place_id_modal')

@endsection

@section('script')
<script src="{{ asset('js/openlocationcode.min.js') }}"></script>
<script src="{{ asset('js/pluscode2latlng.js') }}"></script>

@include('javascript.easymde', ['id' => 'description']);

@endsection
