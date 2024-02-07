@extends('layouts.app')

@section('title', 'Tabungan | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Tabungan'></x-breadcrumb>
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
                                    <x-modal-form title='Tambah data tabungan santri' id='exampleModal'
                                        fn="{{ route('saldo_debit.store') }}" method="POST">
                                        @csrf
                                        <x-select-option label="Pilih santri" name="santri_id" id="santri">
                                            <option value="" selected disabled>Pilih Santri</option>
                                            <option value="semua">Semua Santri Aktif</option>
                                            @foreach ($santri as $str)
                                                <option value="{{ $str->id }}">{{ $str->user->name }}</option>
                                            @endforeach
                                        </x-select-option>
                                        <div class="my-4">
                                            <x-input type="number" name="saldo" id="saldo" label="Nominal Saldo"
                                                placeholder="Nominal Saldo" value="0"></x-input>
                                        </div>
                                        <div class="my-4">
                                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
                                        </div>
                                    </x-modal-form>
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
                                                    <th>Saldo</th>
                                                    <th>Keterangan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tabungan as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->santri->no_induk }}</td>
                                                        <td>{{ $item->santri->user->name }}</td>
                                                        <td>{{ 'Rp. ' . number_format($item->saldo) }}</td>
                                                        <td>{{ $item->keterangan }}</td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal-{{ $item->id }}"
                                                                    class="btn btn-sm btn-danger">
                                                                    <span class="bx bx-trash"> </span>
                                                                </button>

                                                                <x-delete-modal title='Hapus data' id="{{ $item->id }}"
                                                                    fn="{{ route('saldo_debit.destroy', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </x-delete-modal>

                                                                {{-- History link --}}
                                                                <a href="{{ route('saldo_debit.history', $item->santri_id) }}"
                                                                    role="button" class="btn btn-sm btn-primary">
                                                                    <span class="bx bx-history"> </span>
                                                                </a>

                                                                {{-- Export button --}}
                                                                <form
                                                                    action="{{ route('saldo_debit.export', $item->santri_id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-info rounded-0">
                                                                        <span class="bx bx-file"> </span>
                                                                    </button>
                                                                </form>
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
    </script>
@endpush
