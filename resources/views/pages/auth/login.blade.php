@extends('layouts.app')

@section('title', 'Login | DIGITREN')

@section('content')
    <div>
        <div class="section-authentication-login d-flex align-items-center justify-content-center mt-4">
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="card radius-15 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-xl-6 col-md-6">
                                <div class="card-body p-5">
                                    <div class="text-center">
                                        <img src="{{ url('assets/images/logo-icon.png') }}" width="80" alt="">
                                        <h3 class="mt-4 font-weight-bold">Welcome Back</h3>
                                    </div>
                                    <div>
                                        <div class="form-body">
                                            <form class="row g-3" action="{{ route('login.auth') }}" method="POST">
                                                @csrf
                                                <div class="col-md-12">
                                                    <x-input name='email' id='email' label='Email' type='email'
                                                        value="{{ old('email') }}" placeholder='example@example.com'>
                                                    </x-input>
                                                </div>
                                                <div class="col-md-12">
                                                    <x-input-password label='Enter Password' id='password'>
                                                    </x-input-password>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="flexSwitchCheckChecked" checked="">
                                                        <label class="form-check-label"
                                                            for="flexSwitchCheckChecked">Remember Me</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <a href="#" role="button">Forgot Password ?</a>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="bx bxs-lock-open"></i>Sign in</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 bg-login-color d-flex align-items-center justify-content-center">
                                <img src="{{ url('assets/images/login-images/login-frent-img.jpg') }}" class="img-fluid"
                                    alt="image">
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @if (flash()->message)
        <!--notification js -->
        <script src="{{ url('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
        <script src="{{ url('assets/plugins/notifications/js/notifications.min.js') }}"></script>
        <script>
            Lobibox.notify("{{ flash()->class }}", {
                pauseDelayOnHover: true,
                icon: 'bx bx-x-circle',
                size: 'mini',
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: "{{ flash()->message }}"
            });
        </script>
    @endif
@endpush
