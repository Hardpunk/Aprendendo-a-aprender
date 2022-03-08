@extends('layouts.checkout', ['steps' => [true, false, false]])

@section('content')
    <section id="checkout-identification" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="card">
                        <div class="card-header font-weight-bold">{{ mb_strtoupper(__('user.login')) }}</div>

                        <div class="card-body">
                            <form name="formLogin" method="POST" action="{{ route('user.login') }}">
                                @csrf
                                <input type="hidden" name="loginform" value="1" />

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-2 col-form-label text-md-right">{{ __('user.email') }}</label>

                                    <div class="col-md-10">
                                        <input id="login_email" type="email"
                                            class="form-control {{ $errors->has('email') && old('loginform') ? 'is-invalid' : '' }}"
                                            name="email" value="{{ old('loginform') ? old('email') : '' }}" required
                                            autocomplete="username" autofocus>

                                        @if ($errors->has('email') && old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-2 col-form-label text-md-right">{{ __('user.password') }}</label>

                                    <div class="col-md-10">
                                        <input id="login_password" type="password"
                                            class="form-control {{ $errors->has('password') && old('loginform') ? 'is-invalid' : '' }}"
                                            name="password" autocomplete="current-password" required>

                                        @if ($errors->has('password') && old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group row mb-0">
                                    <div class="col-md-10 offset-md-2">
                                        <button type="submit" class="btn btn-theme-color">
                                            {{ __('user.login_button') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password') }}?
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-header font-weight-bold">{{ mb_strtoupper(__('user.register')) }}</div>

                        <div class="card-body">
                            <form name="formUserRegister" method="POST" action="{{ route('user.register') }}">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="first_name">{{ __('user.name') }}</label>
                                        <input id="first_name" type="text"
                                            class="form-control {{ $errors->has('firstname') && !old('loginform') ? 'is-invalid' : '' }}"
                                            name="firstname" value="{{ !old('loginform') ? old('firstname') : '' }}" required>

                                        @if ($errors->has('firstname') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('firstname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name">{{ __('user.lastname') }}</label>
                                        <input id="last_name" type="text"
                                            class="form-control {{ $errors->has('lastname') && !old('loginform') ? 'is-invalid' : '' }}"
                                            name="lastname" value="{{ !old('loginform') ? old('lastname') : '' }}" required>

                                        @if ($errors->has('lastname') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <label for="email">{{ __('user.email') }}</label>
                                        <input id="email" type="email"
                                            class="form-control {{ $errors->has('email') && !old('loginform') ? 'is-invalid' : '' }}"
                                            name="email" value="{{ !old('loginform') ? old('email') : '' }}"
                                            autocomplete="username" required>

                                        @if ($errors->has('email') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email">{{ __('user.birthday') }}</label>
                                        <input id="birthday" type="text"
                                            class="form-control date {{ $errors->has('birthday') && !old('loginform') ? 'is-invalid' : '' }}"
                                            name="birthday" value="{{ !old('loginform') ? old('birthday') : '' }}" required>

                                        @if ($errors->has('birthday') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('birthday') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="phone">{{ __('user.phone') }}</label>
                                        <input id="phone" type="text" name="phone"
                                            class="form-control phone-mask {{ $errors->has('phone') && !old('loginform') ? 'is-invalid' : '' }}"
                                            value="{{ !old('loginform') ? old('phone') : '' }}" required>

                                        @if ($errors->has('phone') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cpf_cnpj">CPF</label>
                                        <input id="cpf_cnpj" type="text" name="cpf_cnpj"
                                            class="form-control cpf {{ $errors->has('cpf_cnpj') && !old('loginform') ? 'is-invalid' : '' }}"
                                            value="{{ !old('loginform') ? old('cpf_cnpj') : '' }}" required>

                                        @if ($errors->has('cpf_cnpj') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cpf_cnpj') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="password">{{ __('user.password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control {{ $errors->has('password') && !old('loginform') ? 'is-invalid' : '' }}"
                                            name="password" autocomplete="new-password" required>

                                        @if ($errors->has('password') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm">{{ __('user.password_confirmation') }}</label>
                                        <input id="password-confirm" type="password"
                                            class="form-control {{ $errors->has('password_confirmation') && !old('loginform') ? 'is-invalid' : '' }}"
                                            name="password_confirmation" autocomplete="new-password" required>

                                        @if ($errors->has('password_confirmation') && !old('loginform'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-theme-color">
                                        {{ __('user.register_button') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
