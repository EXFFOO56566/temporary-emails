@extends('layouts.install')
@section('title', 'Install - Step 3')
@section('content')
<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-5">
    @if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title mb-2">{{ __('Website information') }} </h4>
            <p class="text-muted">{{ __('Enter your website information.') }}</p>
            <form action="{{route('install/step3/set_siteinfo')}}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="12" r="9" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                            <polyline points="11 12 12 12 12 16 13 16" /></svg>
                    </span>
                    <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                        placeholder="Webiste Name" name="site_name" required>
                    @error('site_name')
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
                            <path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5" />
                            <path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5" /></svg>
                    </span>
                    <input type="url" class="form-control @error('site_url') is-invalid @enderror"
                        placeholder="Webiste URL" name="site_url" value="{{url('/')}}" required>
                    @error('site_url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group m-0">
                    <button type="submit" name="logBtn" class="btn btn-primary btn-block btn-pd">
                        {{ __('Continue') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop