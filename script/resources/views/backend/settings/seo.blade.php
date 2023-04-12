@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Seo Settings')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
            <div class="breadcrumb-item">{{__('Seo Settings')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('All About Seo Settings')}}</h2>
        <p class="section-lead">
            {{__('You can adjust all seo settings here')}}
        </p>
        <div class="row">
            @include('layouts.setting')
            <div class="col-md-8">
                <form action="{{ route('settings.seo.update')}}" method="POST" autocomplete="on"
                    enctype="multipart/form-data">
                    <div class="card" id="settings-card">
                        @csrf
                        <div class="card-header">
                            <h4>{{__('Seo Settings')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning offset-sm-3 col-sm-6 col-md-9" role="alert">
                                <strong>
                                    {{__('You can modify all SEO Tags for each language . Go to language and edit
                                    translations and click SEO Tab.')}}
                                </strong>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="form-control-label col-sm-3 text-md-right">{{__('Open Graph
                                    image')}}</label>
                                <div class="col-sm-6 col-md-5">
                                    <input type="file" name="og_image" class="form-control" id="site-logo-upload" />
                                    <div class="form-text text-muted">{{__('The Open Graph image must have a maximum
                                        size of 5MB')}}</div>
                                    <div class="mb-3">
                                        <input type="hidden"
                                            class="form-control @error('og_image') is-invalid @enderror">
                                        @error('og_image')
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
                                <label for="site-title"
                                    class="form-control-label col-sm-3 text-md-right">{{__('Separator')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="separator"
                                        class="form-control @error('separator') is-invalid @enderror"
                                        value="{{$setting['separator']}}" placeholder="| or - or _ ">
                                    @error('separator')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Custom
                                    Tags')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <textarea rows="5" class="form-control @error('custom_tags') is-invalid @enderror"
                                        name="custom_tags"
                                        placeholder='<meta name="author" content="Lobage">'>{{$setting['custom_tags']}}</textarea>
                                    @error('custom_tags')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Google
                                    Analytics Code (Old)')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="google_analytics_code"
                                        class="form-control @error('google_analytics_code') is-invalid @enderror"
                                        value="{{$setting['google_analytics_code']}}" placeholder="UA-XXXXX-Y">
                                    @error('google_analytics_code')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Google
                                    Analytics 4 Code (New GA4)')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="google_analytics_4"
                                        class="form-control @error('google_analytics_4') is-invalid @enderror"
                                        value="{{$setting['google_analytics_4']}}" placeholder="G-XXXXXXXX">
                                    @error('google_analytics_4')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Google
                                    Tag Manager')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="text" name="google_tag_manager"
                                        class="form-control @error('google_tag_manager') is-invalid @enderror"
                                        value="{{$setting['google_tag_manager']}}" placeholder="GTM-XXXX">
                                    @error('google_tag_manager')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Upload
                                    Your Sitemap')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <input type="file" name="sitemap"
                                        class="form-control @error('sitemap') is-invalid @enderror"
                                        value="{{$setting['sitemap']}}" placeholder="GTM-XXXX">
                                    @error('sitemap')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>





                            <div class="form-group row align-items-center">
                                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Robots
                                    Txt')}}</label>
                                <div class="col-sm-6 col-md-9">
                                    <textarea class="form-control @error('robots') is-invalid @enderror" name="robots"
                                        placeholder="">{{$setting['robots']}}</textarea>
                                    @error('robots')
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
<link href="{{ asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/selectric.css') }}" rel="stylesheet">
<!--SET DYNAMIC VARIABLE IN STYLE-->
<style>
    .bg-preview {
        background-image: url('{{asset($setting['og_image'])}}');
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
@endpush
