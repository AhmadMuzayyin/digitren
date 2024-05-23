@props(['id', 'name', 'value', 'label', 'attribute'])
<div>
    <label for="{{ $id ?? '' }}">{{ $label ?? '' }}</label>
    <textarea name="{{ $name ?? '' }}" id="{{ $id ?? '' }}" class="form-control @error($name) is-invalid @enderror"
        cols="30" rows="10" {{ $attribute ?? '' }}>{{ $value ?? '' }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
