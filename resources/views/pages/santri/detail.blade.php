@extends('layouts.app')

@section('title', 'Santri | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Santri'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-end">
                                        <a href="{{ route('santri.index') }}" type="button" class="btn btn-primary">
                                            <i class="bx bx-arrow-left"></i>
                                            Kembali
                                        </a>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                            @include('pages.santri.modal')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
