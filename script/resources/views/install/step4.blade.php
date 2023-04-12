@extends('layouts.install')
@section('title', 'Install - Step 4')
@section('content')
<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-5">
    @if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title mb-2">{{ __('Admin information') }} </h4>
            <p class="text-muted">{{ __('Enter your admin information.') }}</p>
            <form action="{{route('install/step4/set_admininfo')}}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polyline points="3 7 12 13 21 7" /></svg>
                    </span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Admin email" name="email" required value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <circle cx="12" cy="16" r="1" />
                            <path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                    </span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Admin password" name="password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <circle cx="12" cy="16" r="1" />
                            <path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                    </span>
                    <input type="password" class="form-control" placeholder="Confirm password"
                        name="password_confirmation" required>
                </div>
                <div class="form-group m-0">
                    <button type="submit" name="logBtn" class="btn btn-primary btn-block btn-pd">
                        {{ __('Complete installation') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop