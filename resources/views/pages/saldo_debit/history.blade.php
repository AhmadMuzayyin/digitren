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
                                    <div class="row">
                                        <div class="col text-start">
                                            <h4>Riwayat Transaksi-{{ isset($data) ? $data[0]->santri->user->name : '' }}
                                            </h4>
                                        </div>
                                        <div class="col text-end">
                                            <a href="{{ route('saldo_debit.index') }}" class="btn btn-primary">
                                                <i class="bx bx-arrow-back"></i>
                                                Kembali
                                            </a>
                                        </div>
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
                                                    <th>Tanggal Transkasi</th>
                                                    <th>Setor</th>
                                                    <th>Tarik</th>
                                                    <th>Saldo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->tanggal_transaksi . '/' . $item->created_at->diffForHumans() }}
                                                        </td>
                                                        <td>
                                                            @if ($item->jenis_transaksi === 'Setoran')
                                                                @php
                                                                    $kredit = $item->jumlah_transaksi;
                                                                @endphp
                                                                {{ 'Rp. ' . number_format($item->jumlah_transaksi) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item->jenis_transaksi === 'Penarikan')
                                                                @php
                                                                    $debit = $item->jumlah_transaksi;
                                                                @endphp
                                                                {{ 'Rp. ' . number_format($item->jumlah_transaksi) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ 'Rp. ' . number_format($item->saldo_saatini) }}
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
