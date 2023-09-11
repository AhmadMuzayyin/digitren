@extends('layouts.app')

@section('title', 'Jabatan | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" path='Jabatan'></x-breadcrumb>
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
                                                    <th>Name</th>
                                                    <th>Created_at</th>
                                                    <th>Updated_at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->created_at->format('d F Y') }}</td>
                                                        <td>{{ $item->updated_at->format('d F Y') }}</td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#editModal-{{ $item->id }}"
                                                                    class="btn btn-sm btn-primary">
                                                                    <span class="bx bx-edit"> </span>
                                                                </button>

                                                                <x-edit-modal title="Edit data jabatan"
                                                                    id="{{ $item->id }}"
                                                                    fn="{{ route('roles.update', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="mb-3">
                                                                        <x-input type='text' name='name'
                                                                            id="name" label='Nama' placeholder='Nama'
                                                                            value="{{ $item->name }}"
                                                                            attribute='required'></x-input>
                                                                    </div>
                                                                </x-edit-modal>
                                                                @if ($item->user->count() == 0)
                                                                    <button data-bs-toggle="modal"
                                                                        data-bs-target="#deleteModal-{{ $item->id }}"
                                                                        class="btn btn-sm btn-danger">
                                                                        <span class="bx bx-trash"> </span>
                                                                    </button>

                                                                    <x-delete-modal title='Hapus data'
                                                                        id="{{ $item->id }}"
                                                                        fn="{{ route('roles.destroy', $item->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </x-delete-modal>
                                                                @endif
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
            <x-modal-form id='exampleModal' title='Tambah data jabatan' fn="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <x-input type='text' name='name' id="name" label='Nama Lengkap' placeholder='Nama Lengkap'
                        value="{{ old('name') }}"></x-input>
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
