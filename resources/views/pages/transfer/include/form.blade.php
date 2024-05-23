<div class="form-group">
    <x-select-option id="pengirim_id" name="pengirim_id" label="Pengirim" attribute="required">
        <option value="">-- Pilih Pengirim --</option>
        @foreach ($santris as $val)
            <option value="{{ $val->id }}">{{ $val->user->name }}</option>
        @endforeach
    </x-select-option>
</div>
<div class="form-group mt-3">
    <x-select-option id="penerima_id" name="penerima_id" label="Penerima" attribute="required">
        <option value="">-- Pilih Penerima --</option>
        @foreach ($santris as $item)
            <option value="{{ $item->id }}">{{ $item->user->name }}</option>
        @endforeach
    </x-select-option>
</div>
<div class="form-group mt-3">
    <x-input id="nominal" name="nominal" label="Nominal" type="number" attribute="required">
    </x-input>
</div>
<div class="form-group mt-3">
    <x-textarea id="keterangan" name="keterangan" label="Keterangan">
    </x-textarea>
</div>
