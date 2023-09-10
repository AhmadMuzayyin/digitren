@extends('layouts.app')

@section('title', 'Riwayat | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Riwayat'></x-breadcrumb>
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
                                                    <th>User</th>
                                                    <th>Riwayat</th>
                                                    <th>Created_at</th>
                                                    <th>Updated_at</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($riwayat as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->user->name }}</td>
                                                        <td>{{ $item->activity }}</td>
                                                        <td>{{ $item->created_at->format('d F Y') }}</td>
                                                        <td>{{ $item->updated_at->format('d F Y') }}</td>
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
