@props(['id', 'name', 'label', 'attribute'])
<label class="form-label">{{ $label }}</label>
<select class="form-select @error($name) is-invalid @enderror" id="{{ $id }}" name="{{ $name }}"
    {{ $attribute ?? '' }}>
    {{ $slot }}
</select>
@error($name)
    <div id="{{ $id }}" class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
