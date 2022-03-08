@extends('admin.auth.layout.app')

@section('title') {{ __('Forgot Your Password') }} @endsection

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
                <p class="login-box-msg">{{ __('Enter your email to receive the password reset link.') }}</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('admin.password.email') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block">{{ __('Send Password Reset Link') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route("admin.login") }}" class="text-secondary">{{ __('Back to login') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

@endsection
