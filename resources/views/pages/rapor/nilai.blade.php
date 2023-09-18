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
                                    {{-- table form --}}
                                    @if (isset($rapor))
                                        <form action="{{ route('rapor.update') }}" method="POST">
                                        @elseif (isset($mapel))
                                            <form action="{{ route('rapor.store') }}" method="POST">
                                    @endif
                                    @csrf
                                    <input type="hidden" name="santri_id" value="{{ $santri->id }}">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTable" style="width:100%" id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kategori</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th style="max-width: 50px">Nilai Angka</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($rapor))
                                                    <input type="hidden" name="rapor_id"
                                                        value="{{ $rapor->rapor_santri[0]->id }}">
                                                    @foreach ($rapor->nilai as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->mata_pelajaran->kategori }}</td>
                                                            <td>{{ $item->mata_pelajaran->nama }}</td>
                                                            <td>
                                                                <input class="form-control" type="number" max="10"
                                                                    style="max-width: 100%;" name="nilai[]" id="nilai[]"
                                                                    value="{{ $item->nilai }}">
                                                            </td>
                                                            <td>
                                                                <textarea name="keterangan[]" id="keterangan[]" class="form-control">{{ $item->keterangan }}</textarea>
                                                            </td>
                                                            <input type="hidden" name="mata_pelajaran_id[]"
                                                                value="{{ $item->mata_pelajaran_id }}">
                                                            <input type="hidden" name="nilai_id[]"
                                                                value="{{ $item->id }}">
                                                        </tr>
                                                    @endforeach
                                                @elseif (isset($mapel))
                                                    @foreach ($mapel as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->kategori }}</td>
                                                            <td>{{ $item->nama }}</td>
                                                            <td>
                                                                <input class="form-control" type="number" max="10"
                                                                    style="max-width: 100%;" name="nilai[]" id="nilai[]">
                                                            </td>
                                                            <td>
                                                                <textarea name="keterangan[]" id="keterangan[]" class="form-control"></textarea>
                                                            </td>
                                                            <input type="hidden" name="mata_pelajaran_id[]"
                                                                value="{{ $item->id }}">
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="row">
                                            <div class="col-8"></div>
                                            <div class="col-4">
                                                <div class="col my-3">
                                                    <label for="jml_nilai_semester" class="form-lable">Jumlah
                                                        Nilai</label>
                                                    <input class="form-control" type="number" name="jml_nilai_semester"
                                                        id="jml_nilai_semester"
                                                        value="{{ isset($rapor) ? $rapor->rapor_santri[0]->jml_nilai_semester : '' }}">
                                                </div>
                                                <div class="col my-3">
                                                    <label for="nilai_rata_rata_semester" class="form-lable">Nilai
                                                        Rata-Rata</label>
                                                    <input class="form-control" type="number"
                                                        name="nilai_rata_rata_semester" id="nilai_rata_rata_semester"
                                                        value="{{ isset($rapor) ? $rapor->rapor_santri[0]->nilai_rata_rata_semester : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="text-bold">Perilaku Santri</h5>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="col my-3">
                                                        <label for="etika" class="form-lable">Etika</label>
                                                        <input class="form-control" type="number" name="etika"
                                                            id="etika"
                                                            value="{{ isset($rapor) ? $rapor->rapor_santri[0]->etika : '' }}">
                                                    </div>
                                                    <div class="col my-3">
                                                        <label for="kerajinan" class="form-lable">Kerajinan</label>
                                                        <input class="form-control" type="number" name="kerajinan"
                                                            id="kerajinan"
                                                            value="{{ isset($rapor) ? $rapor->rapor_santri[0]->kerajinan : '' }}">
                                                    </div>
                                                    <div class="col my-3">
                                                        <label for="kerapian" class="form-lable">Kerapian</label>
                                                        <input class="form-control" type="number" name="kerapian"
                                                            id="kerapian"
                                                            value="{{ isset($rapor) ? $rapor->rapor_santri[0]->kerapian : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="col my-3">
                                                        <label for="sakit" class="form-lable">Sakit</label>
                                                        <input class="form-control" type="number" name="sakit"
                                                            id="sakit"
                                                            value="{{ isset($rapor) ? $rapor->rapor_santri[0]->sakit : '' }}">
                                                    </div>
                                                    <div class="col my-3">
                                                        <label for="izin" class="form-lable">Izin</label>
                                                        <input class="form-control" type="number" name="izin"
                                                            id="izin"
                                                            value="{{ isset($rapor) ? $rapor->rapor_santri[0]->izin : '' }}">
                                                    </div>
                                                    <div class="col my-3">
                                                        <label for="alpha" class="form-lable">Alpha</label>
                                                        <input class="form-control" type="number" name="alpha"
                                                            id="alpha"
                                                            value="{{ isset($rapor) ? $rapor->rapor_santri[0]->alpha : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col text-end">
                                            <div class="btn-group pull-right">
                                                <div class="btn-group pull-right">
                                                    <button type="submit" class="btn btn-primary">
                                                        <span class="bx bx-save"> </span>
                                                        {{ isset($rapor) ? 'Update' : 'Simpan' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    {{-- table form --}}
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
            // $('#table').DataTable();
            // var table = $('#example2').DataTable({
            //     lengthChange: false,
            //     buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            // });
            // table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
