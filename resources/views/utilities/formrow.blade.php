@php
$title = $title ?? throw new Exception('Missing title in template.');
$name = $name ?? throw new Exception('Missing name in template.');
$required = $required ?? false;
$value = $value ?? null;
@endphp

<div class="mb-3 row">
    <label for="{{ $name }}" class="col-md-4 col-form-label text-md-right">{{ $title }}</label>

    <div class="col-md-6">
        <input id="{{ $name }}" type="text" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" value="{{ old($name, $value) }}" @if($required) required @endif>

        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
