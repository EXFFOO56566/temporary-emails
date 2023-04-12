@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Custom CSS & JS')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
            <div class="breadcrumb-item">{{__('Ads')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('All About Custom CSS & JS')}}</h2>
        <p class="section-lead">
            {{__('You can adjust CSS & JS here')}}
        </p>

        <div id="output-status"></div>
        <div class="row">
            @include('layouts.setting')
            <div class="col-md-8">
                <form action="{{ route('settings.css.js.update')}}" method="POST" autocomplete="on">
                    <div class="card" id="settings-card">
                        @csrf
                        <div class="card-header">
                            <h4>{{__('Custom CSS & JS')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group  align-items-center">
                                <label for="site-title" class="form-control-label">{{__('Custom CSS')}}</label>
                                <textarea class="form-control codeeditor @error('bottom_ad') is-invalid @enderror"
                                    name="custom_css">{{$setting['custom_css']}}</textarea>
                                @error('custom_css')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group  align-items-center">
                                <label for="site-title" class="form-control-label">{{__('Custom JS')}}</label>
                                <textarea class="form-control codeeditor @error('custom_js') is-invalid @enderror"
                                    name="custom_js">{{$setting['custom_js']}}</textarea>
                                @error('custom_js')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" type="submit">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="{{ asset('assets/css/codemirror.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/dracula_theme.css') }}" rel="stylesheet">
@endpush

@push('libraies')
<script src="{{ asset('assets/js/vendor/codemirror.js') }}"></script>
<script src="{{ asset('assets/js/vendor/codemirror_javascript.js') }}"></script>
@endpush
