@extends('layouts.app')

@section('title', 'Santri | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Tingkatan'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            <i class="bx bx-plus"></i>
                                            Tambah Data
                                        </button>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTable" style="width:100%" role="grid"
                                            id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No Induk</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Tahun Masuk</th>
                                                    <th>Status</th>
                                                    <th>Foto</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($santri as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->no_induk }}</td>
                                                        <td>{{ $item->user->name }}</td>
                                                        <td>
                                                            {{ ucwords(strtolower($item->dusun . ', ' .$item->desa . ', ' . $item->kecamatan . ', ' . $item->kabupaten . ', ' . $item->provinsi)) }}
                                                        </td>
                                                        <td>{{ date('d F, Y', strtotime($item->tahun_masuk)) }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>
                                                            @if ($item->foto === 'santri.png')
                                                                <img src="{{ url('/img') . '/' . $item->foto }}"
                                                                    alt="santri" class="img-fluid rounded-circle"
                                                                    width="70px">
                                                            @else
                                                                <img src="{{ url('/storage/uploads/santri') . '/' . $item->foto }}"
                                                                    alt="santri" class="img-fluid rounded-circle"
                                                                    width="70px">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                @if ($item->wali_santri->count() > 0)
                                                                    <a href="{{ route('santri.print.kts', $item->no_induk) }}"
                                                                        target="_blank" class="btn btn-sm btn-success">
                                                                        <span class="bx bx-printer"> </span>
                                                                    </a>
                                                                @endif
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#detailModal-{{ $item->id }}"
                                                                    class="btn btn-sm btn-info">
                                                                    <span class="bx bx-show-alt"> </span>
                                                                </button>
                                                                <x-detail-modal title="Detail data santri"
                                                                    id="{{ $item->id }}" modalSize='modal-lg'>
                                                                    @include('pages.santri.detail')
                                                                </x-detail-modal>

                                                                <div class="btn-group pull-right">
                                                                    <button data-bs-toggle="modal"
                                                                        data-bs-target="#editModal-{{ $item->id }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <span class="bx bx-edit"> </span>
                                                                    </button>
                                                                    <x-edit-modal title="Edit data santri"
                                                                        id="{{ $item->id }}"
                                                                        fn="{{ route('santri.update', $item->id) }}"
                                                                        method="POST" modalSize='modal-lg'>
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        @include('pages.santri.edit')
                                                                    </x-edit-modal>

                                                                    <button data-bs-toggle="modal"
                                                                        data-bs-target="#deleteModal-{{ $item->id }}"
                                                                        class="btn btn-sm btn-danger">
                                                                        <span class="bx bx-trash"> </span>
                                                                    </button>

                                                                    <x-delete-modal title='Hapus data'
                                                                        id="{{ $item->id }}"
                                                                        fn="{{ route('santri.destroy', $item->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </x-delete-modal>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end page-content-wrapper-->
            <x-modal-form id='exampleModal' title='Tambah data santri' fn="{{ route('santri.store') }}"
                attribute="required" method="POST" modalSize="modal-lg">
                @csrf
                <div class="row mb-2">
                    <div class="col">
                        <div class="mb-2">
                            <x-input type='text' name='no_induk' id="no_induk" label='No Induk' placeholder='No Induk'
                                attribute='readonly' value="No induk otomatis sesuai tahun masuk"></x-input>
                        </div>
                    </div>
                    <div class="col">
                        <div>
                            <x-input type="date" label='Tahun masuk' id="tahun_masuk" name='tahun_masuk'
                                placeholder='Tahun masuk' value="{{ old('tahun_masuk') }}" attribute="required"></x-input>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div class="mb-2">
                            <x-input type='text' name='nama_lengkap' id="nama_lengkap" label='Nama Lengkap'
                                placeholder='Nama Lengkap' value="{{ old('nama_lengkap') }}"
                                attribute="required"></x-input>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option label='Jenis Kelamin' id="jenis_kelamin" name='jenis_kelamin'
                                attribute="required">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-Laki"
                                    {{ old('jenis_kelamin') != null ? (old('jenis_kelamin') === 'Laki-Laki' ? 'selected' : '') : '' }}>
                                    Laki-Laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin') != null ? (old('jenis_kelamin') === 'Perempuan' ? 'selected' : '') : '' }}>
                                    Perempuan</option>
                            </x-select-option>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='provinsi' id="provinsi" label='Provinsi' attribute="required">
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='kabupaten' id="kabupaten" label='Kabupaten'
                                attribute="required">
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='kecamatan' id="kecamatan" label='Kecamatan'
                                attribute="required">
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='desa' id="kelurahan" label='Desa / Kelurahan'
                                attribute="required">
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <x-input type="text" name="dusun" id="dusun" value="{{ old('dusun') }}" label="Dusun" placeholder="Dusun"></x-input>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-2">
                            <x-input type='text' name='tempat_lahir' id="tempat_lahir" label='Tempat Lahir'
                                placeholder='Tempat Lahir' value="{{ old('tempat_lahir') }}"
                                attribute="required"></x-input>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-2">
                            <x-select-option name='tanggal_lahir' id="tanggal_lahir" label='Tanggal lahir'>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" attribute="required"
                                        {{ old('tanggal_lahir') != null ? (old('tanggal_lahir') == $i ? 'selected' : '') : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-2">
                            <x-select-option name='bulan_lahir' id="bulan_lahir" label='Bulan lahir'>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" attribute="required"
                                        {{ old('bulan_lahir') != null ? (old('bulan_lahir') == $i ? 'selected' : '') : '' }}>
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
                                @for ($date = 1905; $date <= $now; $date++)
                                    <option value="{{ $date }}" attribute="required"
                                        {{ old('tahun_lahir') != null ? (old('tahun_lahir') == $date ? 'selected' : '') : '' }}>
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
                                value="{{ old('nik') }}" attribute="required"></x-input>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-input type='number' name='kk' id="kk" label='KK' placeholder='KK'
                                value="{{ old('kk') }}" attribute="required"></x-input>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-input type='number' name='whatsapp' id="whatsapp" label='Nomor Whatsapp Aktif'
                                placeholder='Nomor Whatsapp Aktif' value="{{ old('whatsapp') }}"
                                attribute="required"></x-input>
                            <small class="text-muted" style="font-style: italic">mulai dari angka 8xxxxxx
                                (85155353793)</small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <x-input type='text' label='Nama Ayah' id="nama_ayah" name='nama_ayah'
                            placeholder='Nama Ayah' value="{{ old('nama_ayah') }}" attribute="required"></x-input>
                    </div>
                    <div class="col">
                        <x-input type='text' label='Nama Ibu' id="nama_ibu" name='nama_ibu' placeholder='Nama Ibu'
                            value="{{ old('nama_ibu') }}" attribute="required"></x-input>
                    </div>
                </div>
                <div class="row mb-2 mt-3">
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='kelas' id="kelas" label='Kelas'>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}" attribute="required"
                                        {{ old('kelas') != null ? (old('kelas') === $kls->id ? 'selected' : '') : '' }}>
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
                                        {{ old('kamar') != null ? (old('kamar') === $kmr->id ? 'selected' : '') : '' }}
                                        {{ $kmr->jumlah_santri == $kmr->maksimal_santri ? 'disabled' : '' }}>
                                        {{ $kmr->nama . ' - BLK ' . $kmr->blok . ' - ' . $kmr->jumlah_santri . ' SNTR' }}
                                    </option>
                                @endforeach
                            </x-select-option>
                            <small class="text-muted" style="font-style: italic">Disabled jika sudah full</small>
                        </div>
                    </div>
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
                                placeholder='Tanggal Boyong' value="{{ old('tanggal_boyong') }}"></x-input>
                            <small class="text-muted" style="font-style: italic">Hanya jika sudah boyong</small>
                        </div>
                    </div>
                </div>
            </x-modal-form>
        </div>
    </div>
@endsection
@push('js')
    <!--Data Tables js-->
    <script src="{{ url('assets/plugins/datatable/js/jquery.dataTables.min.js') }}" attribute="required"></script>
    <script>
        $(document).ready(function() {
            //Default data table
            $('#table').DataTable();
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        $('#exampleModal').on('shown.bs.modal', function() {
            var urlProvinsi = "{{ url('wilayah/provinsi.json') }}";
            var urlKabupaten = "{{ url('wilayah/kabupaten/') }}";
            var urlKecamatan = "{{ url('wilayah/kecamatan/') }}";
            var urlKelurahan = "{{ url('wilayah/kelurahan/') }}";
            const selectProv = $('#provinsi');
            $.getJSON(urlProvinsi, function(res) {
                selectProv.empty();
                $.each(res, function(i, obj) {
                    selectProv.append($('<option>', {
                        value: obj.id,
                        text: obj.nama
                    }));
                });
            });
            const selectKab = $('#kabupaten');
            $(selectProv).change(function() {
                var val = $(selectProv).val();
                $.getJSON(urlKabupaten + '/' + val + ".json", function(res) {
                    selectKab.empty();
                    $.each(res, function(i, obj) {
                        selectKab.append($('<option>', {
                            value: obj.id,
                            text: obj.nama
                        }));
                    });
                });
            })
            const selectKec = $('#kecamatan');
            $(selectKab).change(function() {
                var val = $(selectKab).val();
                $.getJSON(urlKecamatan + '/' + val + ".json", function(res) {
                    selectKec.empty();
                    $.each(res, function(i, obj) {
                        selectKec.append($('<option>', {
                            value: obj.id,
                            text: obj.nama
                        }));
                    });
                });
            })
            const selectkel = $('#kelurahan');
            $(selectKec).change(function() {
                var val = $(selectKec).val();
                $.getJSON(urlKelurahan + '/' + val + ".json", function(res) {
                    selectkel.empty();
                    $.each(res, function(i, obj) {
                        selectkel.append($('<option>', {
                            value: obj.id,
                            text: obj.nama
                        }));
                    });
                });
            })
        })
    </script>
@endpush
