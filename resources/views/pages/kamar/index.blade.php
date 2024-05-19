@extends('layouts.app')

@section('title', 'Kamar | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" path='Kamar'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#importexport">
                                            <i class="bx bx-file"></i>
                                            Export
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
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTable" style="width:100%" role="grid"
                                            id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>Blok</th>
                                                    <th>Jumlah Santri</th>
                                                    <th>Maksimal Santri</th>
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
            <!--end page-content-wrapper-->
            <x-modal-form id='exampleModal' title='Tambah data tingkatan' fn="{{ route('kamar.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <x-input type='text' name='nama' id="nama" label='Nama Kamar'
                        placeholder='Nama Kamar'></x-input>
                </div>
                <div class="mb-3">
                    <x-input type='text' name='blok' id="blok" label='Blok' placeholder='Nama Blok'></x-input>
                </div>
                <div class="mb-3">
                    <x-input type='number' name='jumlah_santri' id="jumlah_santri" label='Jumlah Santri'
                        placeholder='Jumlah Santri'></x-input>
                </div>
                <div class="mb-3">
                    <x-input type='number' name='maksimal_santri' id="maksimal_santri" label='Maksimal Santri'
                        placeholder='Maksimal Santri'></x-input>
                </div>
            </x-modal-form>
        </div>
    </div>
    <x-modal title="Import/Export" id="importexport" modalSize="modal-lg">
        <div class="row">
            <div class="col">
                <a href="{{ route('santri.download') }}">Download format import</a>
            </div>
            <div class="col text-end">
                <a href="{{ route('kamar.download') }}" role="button" style="color: #673ab7">Export
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            //Default data table
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kamar.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                }, {
                    data: 'kode',
                    name: 'kode'
                }, {
                    data: 'nama',
                    name: 'nama'
                }, {
                    data: 'blok',
                    name: 'blok'
                }, {
                    data: 'jumlah_santri',
                    name: 'jumlah_santri'
                }, {
                    data: 'maksimal_santri',
                    name: 'maksimal_santri'
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                }]
            });
        });
    </script>
@endpush
