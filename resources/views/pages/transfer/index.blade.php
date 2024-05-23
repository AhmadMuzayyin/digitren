@extends('layouts.app')
@section('title', 'Transfer | Digitren')
@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" path='Transfer'></x-breadcrumb>
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
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pengirim</th>
                                            <th>Tanggal Transfer</th>
                                            <th>Penerima</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
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
    {{-- modal --}}
    <x-modal-form title="Tambah Data Transfer" id="exampleModal" fn="{{ route('transfer.store') }}" method="post">
        @csrf
        @include('pages.transfer.include.form')
    </x-modal-form>
@endsection
@push('js')
    <script>
        $(function() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('transfer.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pengirim.user.name'
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY')
                        }
                    },
                    {
                        data: 'penerima.user.name'
                    },
                    {
                        data: 'jumlah_transfer',
                        render: function(data) {
                            return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        }
                    },
                    {
                        data: 'keterangan'
                    },
                ]
            })
        })
    </script>
@endpush
