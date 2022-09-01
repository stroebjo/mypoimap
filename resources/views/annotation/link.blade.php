@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Link annotation') }}
                </div>

                <div class="card-body">
                    <form method="POST" class="js-form" action="{{ route('annotation.updateLink', []) }}">
                        @csrf

                        <input id="annotatable_type" type="hidden" name="annotatable_type" value="{{ get_class($annotatable) }}">
                        <input id="annotatable_id" type="hidden" name="annotatable_id" value="{{ $annotatable->id }}">

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Annotatable') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" disabled value="{{ $annotatable->title }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="annotation_id" class="col-md-4 col-form-label text-md-end">{{ __('Annotation') }}</label>

                            <div class="col-md-6">

                                <select id="annotation_id" class="form-select{{ $errors->has('annotation_id') ? ' is-invalid' : '' }}"  name="annotation_id" required>
                                @foreach($annotations as $annotation)
                                    <option {{ old('annotation_id') == $annotation->id ? 'selected' : '' }} {{ in_array($annotation->id, $linked_annotations) ? " disabled " : '' }} value="{{ $annotation->id }}">{{ $annotation->name}}</option>
                                @endforeach
                                </select>

                                @if ($errors->has('annotation_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('annotation_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route($cancel_route, [$annotatable->id]) }}">{{ __('Cancel') }}</a>

                                <button type="submit" class="ms-3 btn btn-primary">
                                    {{ __('Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
