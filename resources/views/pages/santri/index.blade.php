@extends('layouts.app')

@section('title', 'Santri | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Santri'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#importexport">
                                            <i class="bx bx-file"></i>
                                            Import/Export
                                        </button>

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
                                                    <th>Jenis Kelamin</th>
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
                                                        <td>{{ $item->jenis_kelamin }}</td>
                                                        <td>
                                                            {{ ucwords(strtolower($item->alamat_santri->dusun . ', ' . $item->alamat_santri->kelurahan->name . ', ' . $item->alamat_santri->kecamatan->name . ', ' . $item->alamat_santri->kabupaten->name)) }}
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
                            <x-select-option name='provinsi_id' id="provinsi_id" label='Provinsi' attribute="required">
                                <option value="" selected disabled>Pilih Provinsi</option>
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='kabupaten_id' id="kabupaten_id" label='Kabupaten'
                                attribute="required">
                                <option value="" selected disabled>Pilih Kabupaten</option>
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='kecamatan_id' id="kecamatan_id" label='Kecamatan'
                                attribute="required">
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <x-select-option name='kelurahan_id' id="kelurahan_id" label='Desa / Kelurahan'
                                attribute="required">
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </x-select-option>
                        </div>
                    </div>
                    <div class="col">
                        <x-input type="text" name="dusun" id="dusun" value="{{ old('dusun') }}"
                            label="Dusun" placeholder="Dusun"></x-input>
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
                    <div class="col-6">
                        <div class="mb-2">
                            <x-input type='date' name='tanggal_lahir' id="tanggal_lahir" label='Tanggal Lahir'
                                placeholder='Tanggal Lahir' value="{{ old('tanggal_lahir') }}"
                                attribute="required"></x-input>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-xs-12 col-lg col-md">
                        <div class="mb-2">
                            <x-input type='number' name='nik' id="nik" label='NIK' placeholder='NIK'
                                value="{{ old('nik') }}" attribute="required"></x-input>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg col-md">
                        <div class="mb-2">
                            <x-input type='number' name='kk' id="kk" label='KK' placeholder='KK'
                                value="{{ old('kk') }}" attribute="required"></x-input>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label for="whatsapp">Nomor Whatsapp Aktif</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text">+62</span>
                            <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                                value="{{ old('whatsapp') }}" required placeholder='Nomor Whatsapp Aktif'>
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
            <x-modal title="Import/Export" id="importexport" modalSize="modal-lg">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('santri.download') }}">Download format import</a>
                    </div>
                    <div class="col text-end">
                        <a role="button" data-bs-toggle="modal" data-bs-target="#statusModal"
                            style="color: #673ab7">Export
                            data santri</a>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <ul>
                            <li>Penulisan tanggal harus sesuai format yang ada (05 tidak boleh ditulis 5).</li>
                            <li>Penulisan bulan harus sesuai format yang ada (05 tidak boleh ditulis 5).</li>
                            <li>Penulisan tahun harus sesuai format yang ada.</li>
                            <li>Penulisan nomor telepon/whatsapp harus dimulai dari 62 (62851xxxxx).</li>
                            <li>Semua kolom harus di isi dan harus sesuai format yang telah ditentukan.</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <form action="{{ route('santri.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="file">File excel</label>
                            <input type="file" name="file" id="file" class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </x-modal>
            <x-modal title="Export Santri" id="statusModal">
                <form action="{{ route('santri.export') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <input type="submit" value="Santri Aktif" name="status[]" class="btn btn-primary">
                            <input type="submit" value="Santri Alumni" name="status[]" class="btn btn-info">
                            <input type="submit" value="Semua Santri" name="status[]" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </x-modal>
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
            var provinsiData = {!! json_encode($provinsi) !!};
            $('#provinsi_id').empty();
            $('#provinsi_id').append('<option value="" selected disabled>Pilih Provinsi</option>');
            $.each(provinsiData, function(key, value) {
                $('#provinsi_id').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            $("#provinsi_id").change(function() {
                var selectedProvinsi = $(this).val();
                $.ajax({
                    url: "{{ route('alamat.kabupaten') }}",
                    method: 'GET',
                    data: {
                        provinsi_id: selectedProvinsi
                    },
                    success: function(data) {
                        $('#kabupaten_id').empty();
                        $.each(data, function(key, value) {
                            $('#kabupaten_id').append(
                                '<option value = "' + value.id + '" > ' + value
                                .name +
                                '</option>');
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kabupaten_id").change(function() {
                var kabupaten_id = $(this).val();
                $.ajax({
                    url: "{{ route('alamat.kecamatan') }}",
                    method: 'GET',
                    data: {
                        kabupaten_id: kabupaten_id
                    },
                    success: function(data) {
                        $('#kecamatan_id').empty();
                        $.each(data, function(key, value) {
                            $('#kecamatan_id').append(
                                '<option value = "' + value.id + '" > ' + value
                                .name +
                                '</option>');
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kecamatan_id").change(function() {
                var kecamatan_id = $(this).val();
                $.ajax({
                    url: "{{ route('alamat.kelurahan') }}",
                    method: 'GET',
                    data: {
                        kecamatan_id: kecamatan_id
                    },
                    success: function(data) {
                        $('#kelurahan_id').empty();
                        $.each(data, function(key, value) {
                            $('#kelurahan_id').append(
                                '<option value = "' + value.id + '" > ' + value
                                .name +
                                '</option>');
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
