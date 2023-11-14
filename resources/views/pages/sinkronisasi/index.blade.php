@extends('layouts.app')

@section('title', 'Santri | DIGITREN')

@section('content')
    @php
        $id;
    @endphp
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Tingkatan'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTable" style="width:100%" role="grid"
                                            id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Modul</th>
                                                    <th>Terakhir Sinkronisasi</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($data as $item)
                                                    {{-- @dd($item) --}}
                                                    <tr>
                                                        <td>{{ $no + 1 }}</td>
                                                        <td>{{ ucwords($item[0]) }}</td>
                                                        <td>{{ $item[1] }}</td>
                                                        <td>
                                                            <div class="btn-group pull-right">
                                                                <button class="btn btn-sm btn-danger"
                                                                    id="btn-sync-{{ $no }}">
                                                                    <span class="bx bx-sync" id="icon-sync"> </span>
                                                                </button>
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

        var modules = @json(config('modules.modules'));
        $(document).ready(function() {
            var sync_santri = $('#btn-sync-0');
            var icon_sync = $('#icon-sync');
            sync_santri.click(function() {
                icon_sync.addClass('spin-animation')
                setTimeout(function() {
                    icon_sync.removeClass("spin-animation");
                }, 2000);
            })

            function update() {
                modules.santri[1] = new Date().toLocaleString();
                $.ajax({
                    url: "{{ route('sync.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: modules.santri
                    },
                    success: function(data) {
                        if (data.success == true) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 5000);
                        }
                    }
                })
            }
        })
    </script>
    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .spin-animation {
            animation: spin 1s linear infinite;
        }
    </style>
@endpush
