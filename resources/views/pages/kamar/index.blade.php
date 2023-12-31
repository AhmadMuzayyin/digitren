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
                                            <tbody>
                                                @foreach ($kamar as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->kode }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->blok }}</td>
                                                        <td>{{ $item->jumlah_santri }}</td>
                                                        <td>{{ $item->maksimal_santri }}</td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#editModal-{{ $item->id }}"
                                                                    class="btn btn-sm btn-primary">
                                                                    <span class="bx bx-edit"> </span>
                                                                </button>

                                                                <x-edit-modal title="Edit data kamar"
                                                                    id="{{ $item->id }}"
                                                                    fn="{{ route('kamar.update', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="mb-3">
                                                                        <x-input type='text' name='nama'
                                                                            id="nama" label='Nama Kamar'
                                                                            placeholder='Nama Kamar'
                                                                            value="{{ $item->nama }}"></x-input>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <x-input type='text' name='blok'
                                                                            id="blok" label='Blok'
                                                                            placeholder='Nama Blok'
                                                                            value="{{ $item->blok }}"></x-input>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <x-input type='number' name='jumlah_santri'
                                                                            id="jumlah_santri" label='Jumlah Santri'
                                                                            placeholder='Jumlah Santri'
                                                                            value="{{ $item->jumlah_santri }}"></x-input>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <x-input type='number' name='maksimal_santri'
                                                                            id="maksimal_santri" label='Maksimal Santri'
                                                                            placeholder='Maksimal Santri'
                                                                            value="{{ $item->maksimal_santri }}"></x-input>
                                                                    </div>
                                                                </x-edit-modal>

                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal-{{ $item->id }}"
                                                                    class="btn btn-sm btn-danger">
                                                                    <span class="bx bx-trash"> </span>
                                                                </button>

                                                                <x-delete-modal title='Hapus data' id="{{ $item->id }}"
                                                                    fn="{{ route('kamar.destroy', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </x-delete-modal>
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
@endsection

@push('js')
    <!--Data Tables js-->
    <script src="{{ url('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
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
    </script>
@endpush
