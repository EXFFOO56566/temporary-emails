@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('SMTP Settings')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
            <div class="breadcrumb-item">{{__('SMTP Settings')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('All About SMTP Settings')}}</h2>
        <p class="section-lead">
            {{__('You can adjust all SMTP settings here')}}
        </p>

        <div id="output-status"></div>
        <div class="row">
            @include('layouts.setting')

            <div class="col-md-8">
                <form action="{{ route('settings.smtp.update')}}" method="POST" autocomplete="on"
                    enctype="multipart/form-data">
                    <div class="card" id="settings-card">
                        @csrf
                        <div class="card-header">
                            <h4>{{__('SMTP Settings')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Mailer')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="MAIL_MAILER"
                                        class="form-control @error('MAIL_MAILER') is-invalid @enderror"
                                        value="{{$setting['MAIL_MAILER']}}">
                                    @error('MAIL_MAILER')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Host')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="MAIL_HOST"
                                        class="form-control @error('MAIL_HOST') is-invalid @enderror"
                                        value="{{$setting['MAIL_HOST']}}">
                                    @error('MAIL_HOST')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Port')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="MAIL_PORT"
                                        class="form-control @error('MAIL_PORT') is-invalid @enderror"
                                        value="{{$setting['MAIL_PORT']}}">
                                    @error('MAIL_PORT')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('You Can Use 25 / 2525 / 465 / 587 ')}}
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Username')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="MAIL_USERNAME"
                                        class="form-control @error('MAIL_USERNAME') is-invalid @enderror"
                                        value="{{$setting['MAIL_USERNAME']}}">
                                    @error('MAIL_USERNAME')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Password')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="password" name="MAIL_PASSWORD"
                                        class="form-control @error('MAIL_PASSWORD') is-invalid @enderror"
                                        value="{{ env('DEMO_MODE') ? " your password" : $setting['MAIL_PASSWORD'] }}">
                                    @error('MAIL_PASSWORD')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Encryption')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <select class="form-control selectric" name="MAIL_ENCRYPTION" id="encryption">
                                        <option value="null" {{ $setting['MAIL_ENCRYPTION']=='null' ? 'selected' : ''
                                            }}>{{__('None')}}</option>
                                        <option value="ssl" {{ $setting['MAIL_ENCRYPTION']=='ssl' ? 'selected' : '' }}>
                                            {{__('SSL')}}</option>
                                        <option value="tls" {{ $setting['MAIL_ENCRYPTION']=='tls' ? 'selected' : '' }}>
                                            {{__('TLS')}}</option>
                                    </select>
                                    @error('MAIL_ENCRYPTION')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('From
                                    Email Address')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="MAIL_FROM_ADDRESS"
                                        class="form-control @error('MAIL_FROM_ADDRESS') is-invalid @enderror"
                                        value="{{$setting['MAIL_FROM_ADDRESS']}}">
                                    @error('MAIL_FROM_ADDRESS')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('This email must be for your domain name or hosting !!')}}
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('To Email
                                    Address')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="MAIL_TO_ADDRESS"
                                        class="form-control @error('MAIL_TO_ADDRESS') is-invalid @enderror"
                                        value="{{$setting['MAIL_TO_ADDRESS']}}">
                                    @error('MAIL_TO_ADDRESS')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('This is email where you will receive any new message from the contact
                                        form')}}
                                    </small>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" type="submit">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                </form>
                <hr>
                <form action="{{ route('check.smtp')}}" method="POST" autocomplete="on" enctype="multipart/form-data">
                    <div class="card" id="settings-card">
                        @csrf
                        <div class="card-header">
                            <h4>{{__('Test SMTP Server')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Send Test To ')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="email" placeholder="Your Email" required name="test_email"
                                        class="form-control @error('test_email') is-invalid @enderror">
                                    @error('test_email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" type="submit">{{__('Check SMTP Server')}}</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="{{ asset('assets/css/selectric.css') }}" rel="stylesheet">
@endpush

@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.selectric.min.js') }}"></script>
@endpush