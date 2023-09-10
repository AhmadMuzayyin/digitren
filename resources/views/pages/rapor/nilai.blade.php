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
                                    <li class="breadcrumb-item"><a href="{{ route('rapor.santri', $kelas->id) }}">
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
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col">
                                                <h5>Rapor {{ strtoupper($santri->user->name) }} Kelas
                                                    <strong>{{ $kelas->kelas }}</strong>
                                                </h5>
                                            </div>
                                            <div class="col text-end">
                                                <a href="{{ route('rapor.santri', $kelas->id) }}" class="btn btn-primary"><i
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
                                        <table class="table table-striped dataTable" style="width:100%" id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kategori</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th style="max-width: 50px">Nilai Angka</th>
                                                    <th>Keterangan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rapor as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->kategori }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>
                                                            <input class="form-control" type="number" max="10"
                                                                style="max-width: 100%;"
                                                                name="nilai-{{ isset($item->santri_id) ? $item->mata_pelajaran_id : $item->id }}"
                                                                id="nilai-{{ isset($item->santri_id) ? $item->mata_pelajaran_id : $item->id }}"
                                                                value="{{ isset($item->santri_id) ? $item->nilai : '' }}">
                                                        </td>
                                                        <td>
                                                            <textarea name="keterangan-{{ isset($item->santri_id) ? $item->mata_pelajaran_id : $item->id }}"
                                                                id="keterangan-{{ isset($item->santri_id) ? $item->mata_pelajaran_id : $item->id }}" class="form-control">{{ isset($item->santri_id) ? $item->keterangan : '' }}</textarea>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                <div class="btn-group pull-right">
                                                                    <a href="" class="btn btn-sm btn-primary">
                                                                        <span class="bx bx-save"> </span>
                                                                    </a>
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
