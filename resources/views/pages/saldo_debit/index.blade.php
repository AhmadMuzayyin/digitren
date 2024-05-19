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
    <script>
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('saldo_debit.index') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
            }, {
                data: 'no_induk',
                name: 'no_induk'
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'saldo',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp '),
                name: 'saldo'
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
    </script>
@endpush
