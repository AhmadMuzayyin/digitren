@extends('layouts.app')

@section('title', 'Kelas | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" path='Kelas'></x-breadcrumb>
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
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTable" style="width:100%" role="grid"
                                            id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode Kelas</th>
                                                    <th>Tingkat</th>
                                                    <th>Kelas</th>
                                                    <th>Keterangan</th>
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
            <x-modal-form id='exampleModal' title='Tambah data tingkatan' fn="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <x-input type='text' name='tingkatan' id="tingkatan" label='Tingkatan'
                        placeholder='Nama Tingkatan'></x-input>
                </div>
                <div class="mb-3">
                    <x-input type='text' name='kelas' id="kelas" label='Kelas' placeholder='Nama Kelas'></x-input>
                </div>
                <div class="mb-3">
                    <x-input type='text' name='keterangan' id="keterangan" label='Keterangan'
                        placeholder='Keterangan'></x-input>
                </div>
            </x-modal-form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelas.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                }, {
                    data: 'kode',
                    name: 'kode'
                }, {
                    data: 'tingkatan',
                    name: 'tingkatan'
                }, {
                    data: 'kelas',
                    name: 'kelas'
                }, {
                    data: 'keterangan',
                    name: 'keterangan'
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
