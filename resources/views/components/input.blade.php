@props(['type', 'name', 'id', 'value', 'label', 'placeholder', 'attribute', 'min', 'max'])
<label for="{{ $id }}" class="form-label">{{ $label }}</label>
<input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $id }}"
    name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" value="{{ $value ?? '' }}" {{ $attribute ?? '' }}
    min="{{ $min ?? '' }}" max="{{ $max ?? '' }}">

@error($name)
    <div id="{{ $id }}" class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
