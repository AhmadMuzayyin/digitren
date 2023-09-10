@extends('layouts.app')

@section('title', 'Rapor Santri | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Rapor</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="{{ route('rapor.index') }}">
                                            <i class='bx bx-home-alt'></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Kelas</li>
                                    <li class="breadcrumb-item"><a href="#">
                                            <i class='bx bx-home-alt'></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Santri</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-start">
                                        <div class="row">
                                            <div class="col">
                                                <h5>Rapor Santri Kelas <strong>{{ $kelas->kelas }}</strong></h5>
                                            </div>
                                            <div class="col text-end">
                                                <a href="{{ route('rapor.index') }}" class="btn btn-primary"><i
                                                        class="bx bx-undo"></i> Kembali</a>
                                            </div>
                                        </div>
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
                                                            <div class="btn-group pull-right">
                                                                <div class="btn-group pull-right">
                                                                    <a href="{{ route('rapor.nilai', $item->id) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <span class="bx bx-edit"> </span>
                                                                    </a>
                                                                    @if ($item->rapor_santri->count() > 0)
                                                                        <a href="about:blank" target="_blank"
                                                                            class="btn btn-sm btn-success">
                                                                            <span class="bx bx-printer"> </span>
                                                                        </a>
                                                                    @endif
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
