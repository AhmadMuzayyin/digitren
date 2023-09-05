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
            <x-input type='text' name='nama_lengkap' id="nama_lengkap" label='Nama Lengkap' placeholder='Nama Lengkap'
                value="{{ old('nama_lengkap') ?? $item->user->name }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-select-option label='Jenis Kelamin' id="jenis_kelamin" name='jenis_kelamin' attribute="required">
                <option value="">Pilih jenis kelamin</option>
                <option value="Laki-Laki" {{ old('jenis_kelamin') !=null ? (old('jenis_kelamin')==='Laki-Laki'
                    ? 'selected' : '' ) : ($item->jenis_kelamin === 'Laki-Laki' ? 'selected' : '') }}>
                    Laki-Laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') !=null ? ($item->jenis_kelamin === 'Perempuan' ?
                    'selected' : '') : ($item->jenis_kelamin === 'Perempuan' ? 'selected' : '') }}>
                    Perempuan</option>
            </x-select-option>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='dusun' id="dusun" label='Dusun' placeholder='Dusun'
                value="{{ old('dusun') ?? $item->dusun }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='desa' id="desa" label='Desa' placeholder='Desa'
                value="{{ old('desa') ?? $item->desa }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='kecamatan' id="kecamatan" label='Kecamatan' placeholder='Kecamatan'
                value="{{ old('kecamatan') ?? $item->kecamatan }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <x-input type='text' name='kabupaten' id="kabupaten" label='Kabupaten' placeholder='Kabupaten'
                value="{{ old('kabupaten') ?? $item->kabupaten }}" attribute="required"></x-input>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-6">
        <div class="mb-2">
            <x-input type='text' name='tempat_lahir' id="tempat_lahir" label='Tempat Lahir' placeholder='Tempat Lahir'
                value="{{ old('tempat_lahir') ?? $item->tempat_lahir }}" attribute="required"></x-input>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <x-select-option name='tanggal_lahir' id="tanggal_lahir" label='Tanggal lahir'>
                @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" attribute="required" {{ old('tanggal_lahir')
                    !=null ? (old('tanggal_lahir')==$i ? 'selected' : '' ) : ($item->tanggal_lahir == $i ? 'selected' :
                    '') }}>
                    {{ $i }}</option>
                    @endfor
            </x-select-option>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <x-select-option name='bulan_lahir' id="bulan_lahir" label='Bulan lahir'>
                @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" attribute="required" {{ old('bulan_lahir') !=null
                    ? (old('bulan_lahir')==$i ? 'selected' : '' ) : ($item->bulan_lahir == $i ? 'selected' : '') }}>
                    {{ $i }}</option>
                    @endfor
            </x-select-option>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <x-select-option name='tahun_lahir' id="tahun_lahir" label='Tahun lahir'>
                @php
                $date = 1905;
                $now = date('Y');
                @endphp
                @for ($date = 1905; $date <= $now; $date++) <option value="{{ $date }}" attribute="required" {{
                    old('tahun_lahir') !=null ? (old('tahun_lahir')==$date ? 'selected' : '' ) : ($item->tahun_lahir ==
                    $date ? 'selected' : '') }}>
                    {{ $date }}</option>
                    @endfor
            </x-select-option>
        </div>
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
            <x-input type='number' name='kk' id="kk" label='KK' placeholder='KK' value="{{ old('kk') ?? $item->kk }}"
                attribute="required"></x-input>
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
            value="{{ old('nama_ayah') ?? (!$item->wali_santri->isEmpty() ? $item->wali_santri[0]->nama : '') }}"
            attribute="required"></x-input>
    </div>
    <div class="col">
        <x-input type='text' label='Nama Ibu' id="nama_ibu" name='nama_ibu' placeholder='Nama Ibu'
            value="{{ old('nama_ibu') ?? (!$item->wali_santri->isEmpty() ? $item->wali_santri[1]->nama : '') }}"
            attribute="required"></x-input>
    </div>
</div>

<div class="row mb-2 mt-3">
    <div class="col">
        <div class="mb-2">
            <x-select-option name='kelas' id="kelas" label='Kelas'>
                @foreach ($kelas as $kls)
                <option value="{{ $kls->id }}" attribute="required" {{ old('kelas') !=null ? (old('kelas')===$kls->id ?
                    'selected' : '') : ($item->kelas_id == $kls->id ? 'selected' : '') }}>
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
                <option value="{{ $kmr->id }}" attribute="required" {{ old('kamar') !=null ? (old('kamar')===$kmr->id ?
                    'selected' : '') : ($item->kamar_id == $kmr->id ? 'selected' : '') }}
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
        <img src="{{ url('/storage/uploads/santri') . '/' . $item->foto }}" alt="santri" width="70px" class="img-fluid">
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