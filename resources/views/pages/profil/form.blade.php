<div class="tab-pane fade show active" id="Edit-Profile">
    <div class="card shadow-none border mb-0 radius-15">
        <div class="card-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-12 col-lg-5 border-right">
                        <h5 class="fw-bold">Pengaturan Akun</h5>
                        <form class="row g-3" action="{{ route('profil.account', $user->id) }}" method="POST">
                            @csrf
                            <div class="col-12">
                                <x-input type='text' label='Nama Lengkap' id="name" name='name'
                                    placeholder="Nama Lengkap"
                                    value="{{ old('name') ?? (old('name') ? old('name') : $user->name) }}"></x-input>
                            </div>
                            <div class="col-12">
                                <x-input type='email' label='Email' id="email" name='email' placeholder="Email"
                                    value="{{ old('email') ?? (old('email') ? old('email') : $user->email) }}"></x-input>
                            </div>
                            <div class="col-6">
                                <x-input type='password' label='Password' id="password" name='password'
                                    placeholder="Password"></x-input>
                            </div>
                            <div class="col-6">
                                <x-input type='password' label='Konfirmasi Password' id="password_confirmation"
                                    name='password_confirmation' placeholder="Konfirmasi Password"></x-input>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-7">
                        @if (Auth::user()->roles->first()->name !== 'Administrator' && Auth::user()->roles->first()->name != 'Keuangan')
                            <h5 class="fw-bold">Pengaturan Biodata</h5>
                            <form class="row g-3" action="{{ route('profil.biodata', $user->id) }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <p class="mb-0">Tempat/Tanggal Lahir</p>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <x-input type='text' label='Tempat Lahir' id="tempat_lahir" name='tempat_lahir'
                                        placeholder="tempat_lahir"
                                        value="{{ old('tempat_lahir') ?? (old('tempat_lahir') ? old('tempat_lahir') : $user->santri->tempat_lahir) }}"></x-input>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <x-input type='date' label='Tanggal Lahir' id="tanggal_lahir"
                                        name='tanggal_lahir' placeholder="tanggal_lahir"
                                        value="{{ old('tanggal_lahir') ?? (old('tanggal_lahir') ? old('tanggal_lahir') : $user->santri->tanggal_lahir) }}"></x-input>
                                </div>
                                <div class="col-6">
                                    <x-select-option label='Jenis Kelamin' id="jenis_kelamin" name='jenis_kelamin'
                                        attribute="required">
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="Laki-Laki"
                                            {{ old('jenis_kelamin') != null ? (old('jenis_kelamin') === 'Laki-Laki' ? 'selected' : '') : ($user->santri->jenis_kelamin === 'Laki-Laki' ? 'selected' : '') }}>
                                            Laki-Laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin') != null ? (old('jenis_kelamin') === 'Perempuan' ? 'selected' : '') : ($user->santri->jenis_kelamin === 'Perempuan' ? 'selected' : '') }}>
                                            Perempuan</option>
                                    </x-select-option>
                                </div>
                                <div class="col-6">
                                    <x-input type='number' label='Whatsapp' id="whatsapp" name='whatsapp'
                                        placeholder="whatsapp"
                                        value="{{ old('whatsapp') ?? (old('whatsapp') ? old('whatsapp') : $user->santri->whatsapp) }}"></x-input>
                                </div>
                                <div class="col-4">
                                    <x-select-option name='provinsi_id' id="provinsi_id" label='Provinsi'>
                                    </x-select-option>
                                </div>
                                <div class="col-4">
                                    <x-select-option name='kabupaten_id' id="kabupaten_id" label='Kabupaten'>
                                    </x-select-option>
                                </div>
                                <div class="col-4">
                                    <x-select-option name='kecamatan_id' id="kecamatan_id" label='Kecamatan'>
                                    </x-select-option>
                                </div>
                                <div class="col-6">
                                    <x-select-option name='kelurahan_id' id="kelurahan_id" label='Desa/Kelurahan'>
                                    </x-select-option>
                                </div>
                                <div class="col-6">
                                    <x-input type='text' label='Dusun' id="dusun" name='dusun'
                                        placeholder="dusun"
                                        value="{{ old('dusun') ?? (old('dusun') ? old('dusun') : $user->santri->alamat_santri->dusun) }}"></x-input>
                                </div>
                                <div class="col-6">
                                    <x-input type='number' label='NIK' id="nik" name='nik'
                                        placeholder="nik"
                                        value="{{ old('nik') ?? (old('nik') ? old('nik') : $user->santri->nik) }}"></x-input>
                                </div>
                                <div class="col-6">
                                    <x-input type='number' label='KK' id="kk" name='kk'
                                        placeholder="kk"
                                        value="{{ old('kk') ?? (old('kk') ? old('kk') : $user->santri->kk) }}"></x-input>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tahun Masuk Masehi</label>
                                    <input type="date" class="form-control"
                                        value="{{ $user->santri->tahun_masuk }}" readonly>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tahun Masuk Hijriyah</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->santri->tahun_masuk_hijriyah }}" readonly>
                                </div>
                                @if ($user->santri->status == 'Santri Alumni')
                                    <div class="col-6">
                                        <label class="form-label">Tanggal Boyong Masehi</label>
                                        <input type="date" class="form-control"
                                            value="{{ $user->santri->tanggal_boyong }}" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Tanggal Boyong Hijriyah</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->santri->tanggal_boyong_hijriyah }}" readonly>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <x-input type='file' label='Foto' id="foto" name='foto'></x-input>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    @if (Auth::user()->roles->first()->name !== 'Administrator' && Auth::user()->roles->first()->name != 'Keuangan')
        <script>
            $(document).ready(function() {
                var provinsiData = {!! json_encode($provinsi) !!};
                $("#provinsi_id").empty();
                $("#provinsi_id").append(
                    '<option value="" selected disabled>Pilih Provinsi</option>');
                var prov = "{{ $user->santri->alamat_santri->provinsi->id }}";
                $.each(provinsiData, function(key, value) {
                    var option = $('<option value="' + value.id + '">' + value
                        .name + '</option>');
                    if (value.id == prov) {
                        option.attr('selected', 'selected');
                    }
                    $("#provinsi_id").append(option);
                });
                var kab = "{{ $user->santri->alamat_santri->kabupaten->id }}";
                $.ajax({
                    url: "{{ route('alamat.kabupaten') }}",
                    method: 'GET',
                    data: {
                        provinsi_id: prov
                    },
                    success: function(data) {
                        $("#kabupaten_id").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == kab) {
                                option.attr('selected', 'selected');
                            }
                            $("#kabupaten_id").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
                var kec = "{{ $user->santri->alamat_santri->kecamatan->id }}";
                $.ajax({
                    url: "{{ route('alamat.kecamatan') }}",
                    method: 'GET',
                    data: {
                        kabupaten_id: kab
                    },
                    success: function(data) {
                        $("#kecamatan_id").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == kec) {
                                option.attr('selected', 'selected');
                            }
                            $("#kecamatan_id").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
                var kel = "{{ $user->santri->alamat_santri->kelurahan->id }}";
                $.ajax({
                    url: "{{ route('alamat.kelurahan') }}",
                    method: 'GET',
                    data: {
                        kecamatan_id: kec
                    },
                    success: function(data) {
                        $("#kelurahan_id").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == kel) {
                                option.attr('selected', 'selected');
                            }
                            $("#kelurahan_id").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });

                $("#provinsi_id").change(function() {
                    var selectedProvinsi = $(this).val();
                    var selectedKabupaten = "{{ $user->santri->alamat_santri->kabupaten->id }}";
                    $.ajax({
                        url: "{{ route('alamat.kabupaten') }}",
                        method: 'GET',
                        data: {
                            provinsi_id: selectedProvinsi
                        },
                        success: function(data) {
                            $("#kabupaten_id").empty();
                            $.each(data, function(key, value) {
                                var option = $('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                                if (value.id == selectedKabupaten) {
                                    option.attr('selected', 'selected');
                                }
                                $("#kabupaten_id").append(option);
                            });
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                })
                $("#kabupaten_id").change(function() {
                    var kabupaten_id = $(this).val();
                    var selectedKecamatan = "{{ $user->santri->alamat_santri->kabupaten->id }}";
                    $.ajax({
                        url: "{{ route('alamat.kecamatan') }}",
                        method: 'GET',
                        data: {
                            kabupaten_id: kabupaten_id
                        },
                        success: function(data) {
                            $("#kecamatan_id").empty();
                            $.each(data, function(key, value) {
                                var option = $('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                                if (value.id == selectedKecamatan) {
                                    option.attr('selected', 'selected');
                                }
                                $("#kecamatan_id").append(option);
                            });
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                })
                $("#kecamatan_id").change(function() {
                    var kecamatan_id = $(this).val();
                    var selectedKelurahan = "{{ $user->santri->alamat_santri->kelurahan->id }}";
                    $.ajax({
                        url: "{{ route('alamat.kelurahan') }}",
                        method: 'GET',
                        data: {
                            kecamatan_id: kecamatan_id
                        },
                        success: function(data) {
                            $("#kelurahan_id").empty();
                            $.each(data, function(key, value) {
                                var option = $('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                                if (value.id == selectedKelurahan) {
                                    option.attr('selected', 'selected');
                                }
                                $("#kelurahan_id").append(option);
                            });
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                })
            })
        </script>
    @endif
@endpush
