@extends('layouts.app')

@section('title', 'Riwayat Tabungan | DIGITREN')

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
                                        <a href="{{ route('saldo_debit.index') }}" class="btn btn-primary">
                                            <i class="bx bx-arrow-back"></i>
                                            Kembali
                                        </a>
                                    </div>
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
                                                <th>Santri</th>
                                                <th>Jenis Transkasi</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                                <th>Saldo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $saldo = 0;
                                                $debit = 0;
                                                $kredit = 0;
                                            @endphp
                                            @foreach($data as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->santri->user->name }}</td>
                                                    <td>{{ $item->jenis_transaksi }}</td>
                                                    <td>
                                                        @if($item->jenis_transaksi === 'Setoran')
                                                            @php
                                                                $kredit = $item->jumlah_transaksi;
                                                            @endphp
                                                            {{ "Rp. " . number_format($item->jumlah_transaksi) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->jenis_transaksi === 'Penarikan')
                                                            @php
                                                                $debit = $item->jumlah_transaksi;
                                                            @endphp
                                                            {{ "Rp. ". number_format($item->jumlah_transaksi) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($loop->iteration == 1 && $item->jenis_transaksi === 'Setoran')
                                                            @php
                                                                $saldo = $item->jumlah_transaksi;
                                                            @endphp
                                                            {{ "Rp. " . number_format($saldo) }}
                                                        @else
                                                            @if($item->jenis_transaksi === 'Setoran')
                                                                {{ "Rp. " . number_format($kredit + $saldo - $debit) }}
                                                            @else
                                                                {{ "Rp. " . number_format($saldo - $debit) }}
                                                            @endif
                                                        @endif
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
