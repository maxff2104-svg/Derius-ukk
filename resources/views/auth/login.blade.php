@extends('layouts.app', [
    'namePage' => 'Login page',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'login',
    'backgroundImage' => asset('assets') . "/img/bg14.jpg",
])

@section('content')
    <div class="content">
        <div class="container">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-9">
                                <h1 class="text-white">{{ __('Pengaduan Sarana Sekolah') }}</h1>
                                <p class="text-lead text-light mt-3 mb-0">
                                    {{ __('Sistem Manajemen Pengaduan Sarana dan Prasarana Sekolah') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ml-auto mr-auto">
            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
            <div class="card card-login card-plain">
                <div class="card-header ">
                <div class="logo-container">
                    <img src="{{ asset('assets/img/now-logo.png') }}" alt="">
                </div>
                </div>
                <div class="card-body ">
                <div class="input-group no-border form-control-lg {{ $errors->has('username') ? ' has-danger' : '' }}">
                    <span class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                    </div>
                    </span>
                    <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Username atau NIS') }}" type="text" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                @if ($errors->has('username'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
                <div class="input-group no-border form-control-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="now-ui-icons objects_key-25"></i>
                    </div>
                    </div>
                    <input placeholder="Password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" required>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                </div>
                <div class="card-footer ">
                <button  type = "submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Login') }}</button>
                <div class="text-center mt-3">
                    <small class="text-muted">
                        {{ __('Admin: admin / admin123') }}<br>
                        {{ __('Siswa: 2024001 / 2024001') }}
                    </small>
                </div>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
        demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush
