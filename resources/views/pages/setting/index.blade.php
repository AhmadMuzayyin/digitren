@extends('layouts.app')

@section('title', 'Setting | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('setting.index') }}" attribute="required" path='Setting'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            @if (isset($setting))
                                <form action="{{ route('setting.update', $setting->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group mt-3">
                                        @isset($setting)
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <img src="{{ url('/storage/uploads/setting/', $setting->logo) }}"
                                                        alt="logo" width="50" class="img-fluid">
                                                </div>
                                            </div>
                                        @endisset
                                        <x-input type="file" id="logo" name="logo" label="Logo" />
                                    </div>
                                    <div class="form-group mt-3">
                                        @isset($setting)
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <img src="{{ url('/storage/uploads/setting/', $setting->favicon) }}"
                                                        alt="favicon" width="50" class="img-fluid">
                                                </div>
                                            </div>
                                        @endisset
                                        <x-input type="file" id="favicon" name="favicon" label="Favicon" />
                                    </div>
                                    <div class="form-group mt-3">
                                        <x-input type="text" id="whatsapp_api_key" name="whatsapp_api_key"
                                            label="Whatsapp API Key"
                                            value="{{ isset($setting) ? $setting->whatsapp_api_key : old('whatsapp_api_key') }}" />
                                    </div>
                                    <div class="form-group mt-3">
                                        <x-input type="number" id="sender" name="sender" label="Nomor Pengirim Pesan"
                                            value="{{ isset($setting) ? $setting->sender : old('sender') }}" />
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="Aktif">Fitur Kirim Pesan Whatsapp</label>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="whatsapp_feature[]"
                                                id="Aktif" value="1"
                                                {{ isset($setting) ? ($setting->whatsapp_feature == true ? 'checked' : '') : '' }}>
                                            <label class="form-check-label" for="Aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="whatsapp_feature[]"
                                                id="Tidak Aktif" value="0"
                                                {{ isset($setting) ? ($setting->whatsapp_feature == false ? 'checked' : '') : '' }}>
                                            <label class="form-check-label" for="Tidak Aktif">Tidak Aktif</label>
                                        </div>
                                        <p class="text-danger">
                                            Pastikan nomor whatsapp santri semuanya terisi dengan benar
                                        </p>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="Aktif">Fitur Rekam Aktifitas Pengguna</label>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="log_activity[]"
                                                id="Aktif" value="1"
                                                {{ isset($setting) ? ($setting->log_activity == true ? 'checked' : '') : '' }}>
                                            <label class="form-check-label" for="Aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="log_activity[]"
                                                id="Tidak Aktif" value="0"
                                                {{ isset($setting) ? ($setting->log_activity == false ? 'checked' : '') : '' }}>
                                            <label class="form-check-label" for="Tidak Aktif">Tidak Aktif</label>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <button class="btn btn-info">Update</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <x-input type="file" id="logo" name="logo" label="Logo" />
                                    </div>
                                    <div class="form-group mt-3">
                                        <x-input type="file" id="favicon" name="favicon" label="Favicon" />
                                    </div>
                                    <div class="form-group mt-3">
                                        <x-input type="text" id="whatsapp_api_key" name="whatsapp_api_key"
                                            label="Whatsapp API Key"
                                            value="{{ isset($setting) ? $setting->whatsapp_api_key : old('whatsapp_api_key') }}" />
                                    </div>
                                    <div class="form-group mt-2">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                    {{-- custom message whatsapp --}}
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('setting.whatsapp') }}" method="POST">
                                @csrf
                                <div class="form-group mt-3">
                                    <label for="pesan_tarik_tunai" class="form-label">Pesan Tarik Tunai</label>
                                    <textarea class="form-control @error('pesan_tarik_tunai') is-invalid @enderror" id="pesan_tarik_tunai"
                                        name="pesan_tarik_tunai" rows="5" required>{{ isset($whatsapp) ? $whatsapp->pesan_tarik_tunai : old('pesan_tarik_tunai') }}</textarea>
                                    <p class="text-danger">
                                        <strong>Variable:</strong> <br>
                                        {nama} = Nama <br>
                                        {nominal} = Nominal <br>
                                        {tujuan} = Tujuan <br>
                                        {tanggal} = Tanggal <br>
                                        {waktu} = Waktu
                                    </p>
                                    @error('pesan_tarik_tunai')
                                        <div id="{{ $id }}" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="pesan_setor_tunai" class="form-label">Pesan Setor Tunai</label>
                                    <textarea class="form-control @error('pesan_setor_tunai') is-invalid @enderror" id="pesan_setor_tunai"
                                        name="pesan_setor_tunai" rows="5" required>{{ isset($whatsapp) ? $whatsapp->pesan_setor_tunai : old('pesan_setor_tunai') }}</textarea>
                                    <p class="text-danger">
                                        <strong>Variable:</strong> <br>
                                        {nama} = Nama <br>
                                        {nominal} = Nominal <br>
                                        {tanggal} = Tanggal <br>
                                        {waktu} = Waktu
                                    </p>
                                    @error('pesan_setor_tunai')
                                        <div id="{{ $id }}" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <button class="btn btn-{{ isset($whatsapp) ? 'info' : 'primary' }}">
                                        @if (isset($whatsapp))
                                            Update
                                        @else
                                            Submit
                                        @endif
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
