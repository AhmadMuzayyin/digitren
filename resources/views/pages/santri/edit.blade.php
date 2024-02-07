<div class="row mb-2">
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='no_induk' id="no_induk" label='No Induk' placeholder='No Induk'
                attribute='readonly' value="{{ $item->no_induk }}"></x-input>
        </div>
    </div>
    <div class="col">
        <div>
            <x-input type="date" label='Tahun masuk' id="tahun_masuk" name='tahun_masuk' placeholder='Tahun masuk'
                value="{{ old('tahun_masuk') ?? $item->tahun_masuk }}" attribute="required"></x-input>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='nama_lengkap' id="nama_lengkap" label='Nama Lengkap'
                placeholder='Nama Lengkap' value="{{ old('nama_lengkap') ?? $item->user->name }}"
                attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-select-option label='Jenis Kelamin' id="jenis_kelamin" name='jenis_kelamin' attribute="required">
                <option value="">Pilih jenis kelamin</option>
                <option value="Laki-Laki"
                    {{ old('jenis_kelamin') != null
                        ? (old('jenis_kelamin') === 'Laki-Laki'
                            ? 'selected'
                            : '')
                        : ($item->jenis_kelamin === 'Laki-Laki'
                            ? 'selected'
                            : '') }}>
                    Laki-Laki</option>
                <option value="Perempuan"
                    {{ old('jenis_kelamin') != null
                        ? ($item->jenis_kelamin === 'Perempuan'
                            ? 'selected'
                            : '')
                        : ($item->jenis_kelamin === 'Perempuan'
                            ? 'selected'
                            : '') }}>
                    Perempuan</option>
            </x-select-option>
        </div>
    </div>
</div>

<div class="row mb-2" id="edit_alamat">
    <div class="col">
        <div class="mb-2">
            <x-select-option name='provinsi_id' id="provinsi_id-{{ $item->id }}" label='Provinsi'>
            </x-select-option>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-select-option name='kabupaten_id' id="kabupaten_id-{{ $item->id }}" label='Kabupaten'>
            </x-select-option>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-select-option name='kecamatan_id' id="kecamatan_id-{{ $item->id }}" label='Kecamatan'>
            </x-select-option>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-select-option name='kelurahan_id' id="kelurahan_id-{{ $item->id }}" label='Desa / Kelurahan'>
            </x-select-option>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='dusun' id="dusun" label='Dusun' placeholder='Dusun'
                value="{{ old('dusun') ?? $item->alamat_santri->dusun }}"></x-input>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-6">
        <div class="mb-2">
            <x-input type='text' name='tempat_lahir' id="tempat_lahir" label='Tempat Lahir'
                placeholder='Tempat Lahir' value="{{ old('tempat_lahir') ?? $item->tempat_lahir }}"
                attribute="required"></x-input>
        </div>
    </div>
    <div class="col-6">
        <x-input type='date' name='tanggal_lahir' id="tanggal_lahir" label='tanggal Lahir'
            placeholder='Tanggal Lahir' value="{{ old('tanggal_lahir') ?? $item->tanggal_lahir }}"
            attribute="required"></x-input>
    </div>
</div>

<div class="row mb-2">
    <div class="col">
        <div class="mb-2">
            <x-input type='number' name='nik' id="nik" label='NIK' placeholder='NIK'
                value="{{ old('nik') ?? $item->nik }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type='number' name='kk' id="kk" label='KK' placeholder='KK'
                value="{{ old('kk') ?? $item->kk }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type='number' name='whatsapp' id="whatsapp" label='Nomor Whatsapp Aktif'
                placeholder='Nomor Whatsapp Aktif' value="{{ old('whatsapp') ?? $item->whatsapp }}"
                attribute="required"></x-input>
            <small class="text-muted" style="font-style: italic">mulai dari angka 8xxxxxx
                (85155353793)</small>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col">
        <x-input type='text' label='Nama Ayah' id="nama_ayah" name='nama_ayah' placeholder='Nama Ayah'
            value="{{ old('nama_ayah') ?? ($item->wali_santri ? $item->wali_santri->nama_ayah : '') }}"
            attribute="required"></x-input>
    </div>
    <div class="col">
        <x-input type='text' label='Nama Ibu' id="nama_ibu" name='nama_ibu' placeholder='Nama Ibu'
            value="{{ old('nama_ibu') ?? ($item->wali_santri ? $item->wali_santri->nama_ibu : '') }}"
            attribute="required"></x-input>
    </div>
</div>

<div class="row mb-2 mt-3">
    <div class="col">
        <div class="mb-2">
            <x-select-option name='kelas' id="kelas" label='Kelas'>
                @foreach ($kelas as $kls)
                    <option value="{{ $kls->id }}" attribute="required"
                        {{ old('kelas') != null
                            ? (old('kelas') === $kls->id
                                ? 'selected'
                                : '')
                            : ($item->kelas_id == $kls->id
                                ? 'selected'
                                : '') }}>
                        {{ $kls->tingkatan . ' - ' . $kls->kelas }}
                    </option>
                @endforeach
            </x-select-option>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-select-option name='kamar' id="kamar" label='Kamar'>
                @foreach ($kamar as $kmr)
                    <option value="{{ $kmr->id }}" attribute="required"
                        {{ old('kamar') != null
                            ? (old('kamar') === $kmr->id
                                ? 'selected'
                                : '')
                            : ($item->kamar_id == $kmr->id
                                ? 'selected'
                                : '') }}
                        {{ $kmr->jumlah_santri == $kmr->maksimal_santri ? 'disabled' : '' }}>
                        {{ $kmr->nama . ' - BLK ' . $kmr->blok . ' - ' . $kmr->jumlah_santri . ' SNTR' }}
                    </option>
                @endforeach
            </x-select-option>
            <small class="text-muted" style="font-style: italic">Disabled jika sudah full</small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <img src="{{ url('/storage/uploads/santri') . '/' . $item->foto }}" alt="santri" width="70px"
            class="img-fluid">
    </div>
    <div class="col"></div>
</div>
<div class="row mb-2">
    <div class="col">
        <div class="mb-3">
            <x-input type='file' label='Foto' id="foto" name='foto'></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type="date" label='Tanggal Boyong' id="tanggal_boyong" name='tanggal_boyong'
                placeholder='Tanggal Boyong' value="{{ old('tanggal_boyong') ?? $item->tanggal_boyong }}"></x-input>
            <small class="text-muted" style="font-style: italic">Hanya jika sudah boyong</small>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#editModal-' + "{{ $item->id }}").on('shown.bs.modal', function() {
            var provinsiData = {!! json_encode($provinsi) !!};
            $("#provinsi_id-{{ $item->id }}").empty();
            $("#provinsi_id-{{ $item->id }}").append(
                '<option value="" selected disabled>Pilih Provinsi</option>');
            var prov = "{{ $item->alamat_santri->provinsi->id }}";
            $.each(provinsiData, function(key, value) {
                var option = $('<option value="' + value.id + '">' + value
                    .name + '</option>');
                if (value.id == prov) {
                    option.attr('selected', 'selected');
                }
                $("#provinsi_id-{{ $item->id }}").append(option);
            });
            var kab = "{{ $item->alamat_santri->kabupaten->id }}";
            $.ajax({
                url: "{{ route('alamat.kabupaten') }}",
                method: 'GET',
                data: {
                    provinsi_id: prov
                },
                success: function(data) {
                    $("#kabupaten_id-{{ $item->id }}").empty();
                    $.each(data, function(key, value) {
                        var option = $('<option value="' + value.id + '">' + value
                            .name + '</option>');
                        if (value.id == kab) {
                            option.attr('selected', 'selected');
                        }
                        $("#kabupaten_id-{{ $item->id }}").append(option);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
            var kec = "{{ $item->alamat_santri->kecamatan->id }}";
            $.ajax({
                url: "{{ route('alamat.kecamatan') }}",
                method: 'GET',
                data: {
                    kabupaten_id: kab
                },
                success: function(data) {
                    $("#kecamatan_id-{{ $item->id }}").empty();
                    $.each(data, function(key, value) {
                        var option = $('<option value="' + value.id + '">' + value
                            .name + '</option>');
                        if (value.id == kec) {
                            option.attr('selected', 'selected');
                        }
                        $("#kecamatan_id-{{ $item->id }}").append(option);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
            var kel = "{{ $item->alamat_santri->kelurahan->id }}";
            $.ajax({
                url: "{{ route('alamat.kelurahan') }}",
                method: 'GET',
                data: {
                    kecamatan_id: kec
                },
                success: function(data) {
                    $("#kelurahan_id-{{ $item->id }}").empty();
                    $.each(data, function(key, value) {
                        var option = $('<option value="' + value.id + '">' + value
                            .name + '</option>');
                        if (value.id == kel) {
                            option.attr('selected', 'selected');
                        }
                        $("#kelurahan_id-{{ $item->id }}").append(option);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });

            $("#provinsi_id-{{ $item->id }}").change(function() {
                var selectedProvinsi = $(this).val();
                var selectedKabupaten = "{{ $item->alamat_santri->kabupaten->id }}";
                $.ajax({
                    url: "{{ route('alamat.kabupaten') }}",
                    method: 'GET',
                    data: {
                        provinsi_id: selectedProvinsi
                    },
                    success: function(data) {
                        $("#kabupaten_id-{{ $item->id }}").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == selectedKabupaten) {
                                option.attr('selected', 'selected');
                            }
                            $("#kabupaten_id-{{ $item->id }}").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kabupaten_id-{{ $item->id }}").change(function() {
                var kabupaten_id = $(this).val();
                var selectedKecamatan = "{{ $item->alamat_santri->kabupaten->id }}";
                $.ajax({
                    url: "{{ route('alamat.kecamatan') }}",
                    method: 'GET',
                    data: {
                        kabupaten_id: kabupaten_id
                    },
                    success: function(data) {
                        $("#kecamatan_id-{{ $item->id }}").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == selectedKecamatan) {
                                option.attr('selected', 'selected');
                            }
                            $("#kecamatan_id-{{ $item->id }}").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kecamatan_id-{{ $item->id }}").change(function() {
                var kecamatan_id = $(this).val();
                var selectedKelurahan = "{{ $item->alamat_santri->kelurahan->id }}";
                $.ajax({
                    url: "{{ route('alamat.kelurahan') }}",
                    method: 'GET',
                    data: {
                        kecamatan_id: kecamatan_id
                    },
                    success: function(data) {
                        $("#kelurahan_id-{{ $item->id }}").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == selectedKelurahan) {
                                option.attr('selected', 'selected');
                            }
                            $("#kelurahan_id-{{ $item->id }}").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
        })
    </script>
@endpush
