@extends('admin.auth.layout.app')

@section('title') {{ __('Reset Password') }} @endsection

@section('content')
    <div class="login-box">
        <!-- /.login-box-body -->
        <div class="card card-outline card-warning">
            <div class="card-header text-center">
                <a href="{{ route('admin.home') }}">
                    <img src="{{ asset('images/logo-small.png') }}" class="img-fluid"/>
                </a>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    {{ __('You are only one step a way from your new password, recover your password now.') }}</p>

                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group mb-3">
                        <input type="email"
                               name="email"
                               value="{{ $email ?? old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="E-mail">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="{{ __('Password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @error('password')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="{{ __('Confirm Password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block">{{ __('Reset Password') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('admin.login') }}" class="text-secondary">{{ __('Back to login') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>

    </div>
@endsection
