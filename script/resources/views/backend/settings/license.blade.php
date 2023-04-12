@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('settings') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ __('License Settings') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('settings') }}">{{ __('Settings') }}</a></div>
                <div class="breadcrumb-item">{{ __('License Settings') }}</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">{{ __('All About License Settings') }}</h2>
            <p class="section-lead">
                {{ __('You can adjust all License settings here') }}
            </p>

            <div id="output-status"></div>
            <div class="row">
                @include('layouts.setting')

                <div class="col-md-8">
                    <form action="{{ route('settings.license.update') }}" method="POST" autocomplete="on"
                        enctype="multipart/form-data">
                        <div class="card" id="settings-card">
                            @csrf
                            <div class="card-header">
                                <h4>{{ __('Manage Your License') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success offset-sm-3 col-sm-6 col-md-9" role="alert">
                                    {{ __('You can download your license') }} <a target="_blank"
                                        href="https://go.lobage.com/license"><strong>{{ __(' Here') }}</strong></a>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="site-title"
                                        class="form-control-label col-sm-3 text-md-right">{{ __('Upload Your License') }}</label>
                                    <div class="col-sm-6 col-md-9">
                                        <input type="file" name="license"
                                            class="form-control @error('license') is-invalid @enderror" required
                                            value="">
                                        @error('license')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                @if ($settings != null)
                                    <div class="form-group row align-items-center">
                                        <label for="site-title"
                                            class="form-control-label col-sm-3 text-md-right">{{ __('Purchase Code') }}</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input readonly type="text" name="license" class="form-control" required
                                                value="{{ $settings->code }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="site-title"
                                            class="form-control-label col-sm-3 text-md-right">{{ __('Installation Fingerprint') }}</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input readonly type="text" name="license" class="form-control" required
                                                value="{{ $settings->license }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="site-title"
                                            class="form-control-label col-sm-3 text-md-right">{{ __('License type') }}</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input readonly type="text" name="license" class="form-control" required
                                                value="{{ $settings->type }}">
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <button class="btn btn-primary" type="submit">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
