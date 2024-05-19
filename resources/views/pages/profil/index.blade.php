@extends('layouts.app')

@section('title', 'Profil | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Profil'></x-breadcrumb>
                    <div class="user-profile-page">
                        <div class="card radius-15">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-7 border-right">
                                        <div class="d-md-flex align-items-center">
                                            <div class="mb-md-0 mb-3">
                                                @isset($user->santri->foto)
                                                    @if ($user->santri->foto === 'santri.png' || $user->santri->foto === '')
                                                        <img src="{{ url('assets/images/avatars/avatar-1.png') }}"
                                                            class="rounded-circle shadow" width="130" height="130"
                                                            alt="santri.png" />
                                                    @else
                                                        <img src="{{ url("storage/uploads/santri/{$user->santri->foto}") }}"
                                                            class="rounded-circle shadow" width="70" alt="santri.png" />
                                                    @endif
                                                @endisset
                                            </div>
                                            <div class="ms-md-4 flex-grow-1">
                                                <div class="d-flex align-items-center mb-1">
                                                    <h4 class="mb-0">{{ $user->name }}</h4>
                                                </div>
                                                <p class="text-primary"><i class='bx bx-buildings'></i>
                                                    {{ $user->roles->first()->name }} -
                                                    {{ isset($user->santri) ? $user->santri->no_induk : '112' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5">
                                    </div>
                                </div>
                                <!--end row-->
                                <ul class="nav nav-pills mt-2">
                                    {{-- <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                            href="#Show-Profile"><span class="p-tab-name">Profil</span><i
                                                class='bx bx-message-edit font-24 d-sm-none'></i></a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                            href="#Edit-Profile"><span class="p-tab-name">Edit Profil</span><i
                                                class='bx bx-message-edit font-24 d-sm-none'></i></a>
                                    </li> --}}
                                </ul>
                                <div class="tab-content mt-3">
                                    @include('pages.profil.form')
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
@endpush
