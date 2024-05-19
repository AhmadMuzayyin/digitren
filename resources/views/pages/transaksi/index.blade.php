@extends('layouts.app')

@section('title', 'Transaksi | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Transaksi'></x-breadcrumb>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h1 class="card-title">Transaksi
                                        {{ request()->get('jenis_transaksi') ? request()->get('jenis_transaksi') : 'Setoran' }}
                                    </h1>
                                </div>
                                <div class="col text-end">
                                    <select name="select" id="select" class="form-control">
                                        <option value="Setoran"
                                            {{ request()->get('jenis_transaksi') != null
                                                ? (request()->get('jenis_transaksi') == 'Setoran'
                                                    ? 'selected'
                                                    : '')
                                                : '' }}>
                                            Setoran</option>
                                        <option value="Penarikan"
                                            {{ request()->get('jenis_transaksi') != null
                                                ? (request()->get('jenis_transaksi') == 'Penarikan'
                                                    ? 'selected'
                                                    : '')
                                                : '' }}>
                                            Penarikan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <input type="search" class="form-control" max="8" id="no_induk" name="no_induk"
                                        placeholder="No Induk Santri" autofocus>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <div id="spinner" style="display: none">
                                                <div class="d-flex">
                                                    <div class="spinner-border text-primary" role="status"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <select name="name" id="name" class="form-control single-select">
                                        <option value="" selected disabled>Pilih Santri</option>
                                        @foreach ($santri as $model)
                                            <option value="{{ $model->id }}">{{ $model->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if (request()->get('jenis_transaksi') == null || request()->get('jenis_transaksi') == 'Setoran')
                                @include('pages.transaksi.setoran')
                            @else
                                @include('pages.transaksi.penarikan')
                            @endif
                            <div class="col border rounded {{ request()->get('jenis_transaksi') != null
                                ? (request()->get('jenis_transaksi') == 'Setoran'
                                    ? 'bg-info'
                                    : 'bg-danger')
                                : 'bg-info' }} text-white text-center"
                                style="margin-top: -1%">
                                <h1 class="fw-bold">Saldo : Rp. <span id="saldo">000000</span></h1>
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
        $(document).ready(function() {
            $('#select').on('change', function() {
                window.location.href = "{{ route('transaksi.index') }}" + '?jenis_transaksi=' + $(this)
                    .val()
            })
            $('.single-select').select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
        })
    </script>
@endpush
