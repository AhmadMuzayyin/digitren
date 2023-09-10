@extends('layouts.app')

@section('title', 'Rapor Santri | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Rapor'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-end">
                                        {{-- action data --}}
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
                                                    <th>Kelas</th>
                                                    <th>Tingkatan</th>
                                                    <th>keterangan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kelas as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->kelas }}</td>
                                                        <td>{{ $item->tingkatan }}</td>
                                                        <td>{{ $item->keterangan }}</td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                <div class="btn-group pull-right">
                                                                    <a href="{{ route('rapor.santri', $item->id) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <span class="bx bx-edit"> </span>
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
