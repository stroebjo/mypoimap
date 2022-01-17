@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Category') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user_category.update', [$category]) }}">
                        @csrf
                        {{ method_field('PATCH') }}

                        <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $category->name) }}" required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="order" class="col-md-4 col-form-label text-md-right">{{ __('Order') }}</label>

                                <div class="col-md-6">
                                    <input id="order" type="number" step="1" class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" name="order" value="{{ old('order', $category->order) }}" required>

                                    <small class="form-text text-muted">{{ __('Categories are order by this value, beginnging with the lowest.') }}</small>


                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="color" class="col-md-4 col-form-label text-md-right">{{ __('Color') }}</label>

                                <div class="col-md-6">
                                    <input id="color" type="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" name="color" value="{{ old('color', $category->color) }}" required>

                                    @if ($errors->has('color'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('color') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        <div class="d-flex justify-content-between">
                            <div>{{-- for justify-content-between --}}</div>

                            <div>
                                <a class="btn btn-outline-secondary" href="{{ route('user_category.index') }}">{{ __('Cancel') }}</a>

                                <button type="submit" class="ms-3 btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>


                    <form class="card-form-delete" method="POST" action="{{ route('user_category.destroy', [$category->id]) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="btn btn-outline-danger{{ (($category->places->count() > 0) ? ' js-category-not_empty disabled' : '') }}" type="submit">{{ __('Delete') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.js-category-not_empty').on('click', function(e) {
        e.preventDefault();
        alert('{{ __('You can not delete a category that has places.') }}');
    });
</script>
@endsection
