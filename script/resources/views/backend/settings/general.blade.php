@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('General Settings')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
            <div class="breadcrumb-item">{{__('General Settings')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('All About General Settings')}}</h2>
        <p class="section-lead">
            {{__('You can adjust all general settings here')}}
        </p>

        <div id="output-status"></div>
        <div class="row">
            @include('layouts.setting')

            <div class="col-md-8">
                <form action="{{ route('settings.general.update')}}" method="POST" autocomplete="on"
                    enctype="multipart/form-data">
                    <div class="card" id="settings-card">
                        @csrf
                        <div class="card-header">
                            <h4>{{__('General Settings')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Site
                                    Title')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" required
                                        value="{{$setting['name']}}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Site
                                    Url')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="url" name="site_url"
                                        class="form-control @error('site_url') is-invalid @enderror" required
                                        value="{{$setting['site_url']}}">
                                    @error('site_url')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Site Logo')}}</label>
                                <div class="col-sm-6 col-md-5">
                                    <input type="file" name="site_logo" class="form-control" id="site-logo-upload" />
                                    <div class="form-text text-muted">{{__('The Logo must have a maximum size of 1MB')}}
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden"
                                            class="form-control @error('site_logo') is-invalid @enderror">
                                        @error('site_logo')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 bg_main_color">
                                    <div id="site-logo-preview" class="bg-preview">
                                    </div><br />
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Favicon')}}</label>
                                <div class="col-sm-6 col-md-5">
                                    <input type="file" name="favicon" class="form-control" id="favicon-upload" />
                                    <div class="form-text text-muted">{{__('The Favicon must have a maximum size of
                                        1MB')}}</div>
                                    <div class="mb-3">
                                        <input type="hidden"
                                            class="form-control @error('favicon') is-invalid @enderror">
                                        @error('favicon')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div id="favicon-preview" class="bg-preview bg-preview-2">
                                    </div><br />
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Main
                                    Color')}}</label>
                                <div class="col-sm-6 col-md-2">
                                    <input type="color" name="main_color"
                                        class="p-1 form-control @error('main_color') is-invalid @enderror" required
                                        value="{{$setting['main_color']}}">
                                    @error('main_color')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Secondary Color')}}</label>
                                <div class="col-sm-6 col-md-2">
                                    <input type="color" name="secondary_color"
                                        class="p-1 form-control @error('secondary_color') is-invalid @enderror" required
                                        value="{{$setting['secondary_color']}}">
                                    @error('secondary_color')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Default
                                    Language')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <select class="form-control selectric" name="lang">
                                        @foreach ($languages as $language)
                                        <option value="{{ $language->code }}" @if($setting['lang']==$language->code)
                                            selected @endif >{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" type="submit">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <form action="{{ route('settings.general.update2')}}" method="POST" autocomplete="on"
                    enctype="multipart/form-data">
                    <div class="card" id="settings-card">
                        @csrf
                        <div class="card-header">
                            <h4>{{__('Advanced Settings')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('IMAP
                                    Host')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="imap_host"
                                        class="form-control @error('imap_host') is-invalid @enderror" required
                                        value="{{$setting['imap_host']}}">
                                    @error('imap_host')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('IMAP
                                    Port')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="imap_port"
                                        class="form-control @error('imap_port') is-invalid @enderror" required
                                        value="{{$setting['imap_port']}}">
                                    @error('imap_port')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('993 / 143')}}
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('IMAP
                                    Encryption')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <select class="form-control selectric" name="imap_encryption" id="encryption">
                                        <option value="notls" {{ $setting['imap_encryption']=='notls' ? 'selected' : ''
                                            }}>{{__('None')}}</option>
                                        <option value="ssl" {{ $setting['imap_encryption']=='ssl' ? 'selected' : '' }}>
                                            {{__('SSL')}}</option>
                                        <option value="tls" {{ $setting['imap_encryption']=='tls' ? 'selected' : '' }}>
                                            {{__('TLS')}}</option>
                                    </select>
                                    @error('imap_encryption')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Validate
                                    Certificates')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <label class="custom-switch ">
                                        <input type="checkbox" name="imap_certificate" class="custom-switch-input"
                                            value="1" @if($setting['imap_certificate']) checked @endif>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('IMAP
                                    Username')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="imap_user"
                                        class="form-control @error('imap_user') is-invalid @enderror" required
                                        value="{{$setting['imap_user']}}">
                                    @error('imap_user')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('IMAP
                                    Password')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="password" autocomplete="current-password" name="imap_pass"
                                        class="form-control @error('imap_pass') is-invalid @enderror" required
                                        value="{{ env('DEMO_MODE') ? " your password" : $setting['imap_pass'] }}">
                                    @error('imap_pass')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Email
                                    Lifetime')}}
                                    ({{__('Days')}})
                                    :</label>
                                <div class="col-sm-6 col-md-9 row">
                                    <div class="col-12 col-md-6">
                                        <input type="number" name="email_lifetime"
                                            class="form-control @error('email_lifetime') is-invalid @enderror" required
                                            value="{{$setting['email_lifetime']}}">
                                        @error('email_lifetime')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control selectric" name="email_lifetime_type">
                                            <option value="1440" {{ $setting['email_lifetime_type']=='1440' ? 'selected'
                                                : '' }}>{{__('Days')}}</option>
                                            <option value="60" {{ $setting['email_lifetime_type']=='60' ? 'selected'
                                                : '' }}>{{__('Hours')}}</option>
                                            <option value="1" {{ $setting['email_lifetime_type']=='1' ? 'selected' : ''
                                                }}>{{__('Minutes')}}</option>
                                        </select>
                                        @error('email_lifetime_type')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted pl-3">
                                        {{__('All email data will be automatically deleted after this period')}}
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Fetch
                                    Mail Every')}}
                                    ({{__('Seconds')}})
                                    :</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="number" name="fetch_time"
                                        class="form-control @error('fetch_time') is-invalid @enderror" required
                                        value="{{$setting['fetch_time']}}">
                                    @error('fetch_time')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Domains')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" data-role="tagsinput" name="domains" required
                                        class="form-control inputtags @error('domains') is-invalid @enderror"
                                        value="{{$setting['domains']}}">
                                    @error('domains')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('Add Domains Without "https://" , "/" like (site.com , example.com ,
                                        yourdomain.com) ')}}
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Forbidden IDs')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" data-role="tagsinput" name="forbidden_id"
                                        class="form-control inputtags @error('forbidden_id') is-invalid @enderror"
                                        value="{{$setting['forbidden_id']}}">
                                    @error('forbidden_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Allowed
                                    files')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" data-role="tagsinput" name="allowed_files"
                                        class="form-control inputtags @error('allowed_files') is-invalid @enderror"
                                        value="{{$setting['allowed_files']}}">
                                    @error('allowed_files')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Fake
                                    Emails Created')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="number" name="emails_created"
                                        class="form-control @error('emails_created') is-invalid @enderror" required
                                        value="{{$setting['emails_created']}}">
                                    @error('emails_created')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Fake
                                    Messages Received')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="number" name="messages_received"
                                        class="form-control @error('messages_received') is-invalid @enderror" required
                                        value="{{$setting['messages_received']}}">
                                    @error('messages_received')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Recaptcha Site
                                    Key')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="RECAPTCHA_SITE_KEY"
                                        class="form-control @error('RECAPTCHA_SITE_KEY') is-invalid @enderror"
                                        value="{{$setting['RECAPTCHA_SITE_KEY']}}">
                                    @error('RECAPTCHA_SITE_KEY')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('If you want to protect all forms from bots')}}
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Recaptcha Secret
                                    Key')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="RECAPTCHA_SECRET_KEY"
                                        class="form-control @error('RECAPTCHA_SECRET_KEY') is-invalid @enderror"
                                        value="{{$setting['RECAPTCHA_SECRET_KEY']}}">
                                    @error('RECAPTCHA_SECRET_KEY')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Invisible Recaptcha Site
                                    Key')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="INVISIBLE_SITE_KEY"
                                        class="form-control @error('INVISIBLE_SITE_KEY') is-invalid @enderror"
                                        value="{{$setting['INVISIBLE_SITE_KEY']}}">
                                    @error('INVISIBLE_SITE_KEY')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{__('Only if you want to protect mail from bots')}}
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Invisible Recaptcha Secret
                                    Key')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="INVISIBLE_SECRET_KEY"
                                        class="form-control @error('INVISIBLE_SECRET_KEY') is-invalid @enderror"
                                        value="{{$setting['INVISIBLE_SECRET_KEY']}}">
                                    @error('INVISIBLE_SECRET_KEY')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class=" col-6 form-group row align-items-center">
                                    <label for="site-title"
                                        class="form-control-label col-sm-6 text-md-right">{{__('Enable
                                        Cookie Pop Up')}}</label>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="custom-switch ">
                                            <input type="checkbox" name="COOKIE_CONSENT_ENABLED"
                                                class="custom-switch-input" value="1"
                                                @if($setting['COOKIE_CONSENT_ENABLED']) checked @endif>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 form-group row align-items-center">
                                    <label for="site-title"
                                        class="form-control-label col-sm-6 text-md-right">{{__('Force
                                        HTTPS')}}</label>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="custom-switch ">
                                            <input type="checkbox" name="https_force" class="custom-switch-input"
                                                value="1" @if($setting['https_force']) checked @endif>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-6 form-group row align-items-center">
                                    <label for="site-title"
                                        class="form-control-label col-sm-6 text-md-right">{{__('Enable
                                        Preloader')}}</label>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="custom-switch ">
                                            <input type="checkbox" name="enable_preloader" class="custom-switch-input"
                                                value="1" @if($setting['enable_preloader']) checked @endif>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-6 form-group row align-items-center">
                                    <label for="site-title" class="form-control-label col-sm-6 text-md-right">{{__('Hide
                                        Default Lang In URL')}}</label>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="custom-switch ">
                                            <input type="checkbox" name="hideDefaultLocaleInURL"
                                                class="custom-switch-input" value="1"
                                                @if($setting['hideDefaultLocaleInURL']) checked @endif>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-dark check_imap" type="button">{{__('Check IMAP Server')}}</button>
                            <button class="btn btn-primary" type="submit">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                </form>
                <div class="log">
                    <pre id='log_info'></pre>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@push('styles')
<link href="{{ asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/selectric.css') }}" rel="stylesheet">
<!--SET DYNAMIC VARIABLE IN STYLE-->
<style>
    .bg-preview {
        background-image: url('{{asset($setting['site_logo'])}}');
    }

    .bg-preview-2 {
        background-image: url('{{asset($setting['favicon'])}}');
    }

    .bg_main_color {

        background: {
                {
                $setting['main_color']
            }
        }

        ;
    }
</style>
@endpush

@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.selectric.min.js') }}"></script>
@endpush

@push('scripts')
<!--SET DYNAMIC VARIABLE IN SCRIPT -->
<script>
    "use strict";
  var check_link = "{{ route('check.imap') }}";
</script>
@endpush
