@extends('layouts.app')
@section('title', 'Login - ' . $setdata['name'])


@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <a href="{{url('/')}}">{{$setdata['name']}}</a>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" tabindex="1" value="{{ env('DEMO_MODE') ? "admin@lobage.com" : old('email') }}" required autofocus>
                            @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                                @if (Route::has('password.request'))
                                <div class="float-right">
                                    <a class="btn btn-link" href="{{ route('password.request') }}" class="text-small">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            <input id="password" type="password"
                                class="form-control @error('email') is-invalid @enderror" name="password" tabindex="2"
                                required autocomplete="current-password" value="{{ env('DEMO_MODE') ? "lobage123" : '' }}">
                            @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" tabindex="3" name="remember"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="simple-footer">
                Copyright &copy; {{$setdata['name']}} {{date("Y")}}
            </div>
        </div>
    </div>
</div>
@endsection