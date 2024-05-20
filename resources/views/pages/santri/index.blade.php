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
                                                    <th>Jenis Kelamin</th>
                                                    <th>Tahun Masuk</th>
                                                    <th>Status</th>
                                                    <th>Foto</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end page-content-wrapper-->
        <x-modal-form id='exampleModal' title='Tambah data santri' fn="{{ route('santri.store') }}" attribute="required"
            method="POST" modalSize="modal-lg">
            @csrf
            @include('pages.santri.include.form')
        </x-modal-form>
        <x-modal title="Import/Export" id="importexport" modalSize="modal-lg">
            <div class="row">
                <div class="col">
                    <a href="{{ route('santri.download') }}">Download format import</a>
                </div>
                <div class="col text-end">
                    <a role="button" data-bs-toggle="modal" data-bs-target="#statusModal" style="color: #673ab7">Export
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
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('santri.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'no_induk',
                    name: 'no_induk',
                }, {
                    data: 'user.name',
                    name: 'user.name',
                }, {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin',
                }, {
                    data: 'tahun_masuk',
                    name: 'tahun_masuk',
                }, {
                    data: 'status',
                    name: 'status',
                }, {
                    data: 'foto',
                    render: function(data) {
                        if (data == 'santri.png') {
                            return `<div class="d-flex justify-content-center">
                            <img src="/img/${data}" alt="santri" class="img-fluid rounded-circle" width="70px">
                            </div`;
                        } else {
                            return `<div class="d-flex justify-content-center">
                                <img src="/storage/uploads/santri/${data}" alt="santri" class="img-fluid " width="70px">
                                </div>`;
                        }
                    },
                    name: 'foto',
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }, ]
            });
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
