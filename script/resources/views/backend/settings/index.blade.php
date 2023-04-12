@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Settings') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('Settings') }}</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">{{ __('Overview') }}</h2>
            <p class="section-lead">
                {{ __('Organize and adjust all settings about this site.') }}
            </p>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('General') }}</h4>
                            <p>{{ __('General settings such as, site title, logo , and advanced settings.') }}</p>
                            <a href="{{ route('settings.general') }}" class="card-cta">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('SEO') }}</h4>
                            <p>{{ __('Search engine optimization settings, such as meta tags and social media.') }}</p>
                            <a href="{{ route('settings.seo') }}" class="card-cta">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-rss"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('Blog') }}</h4>
                            <p>{{ __('Blog settings such as, enable blog, max mosts in page , and more.') }}</p>
                            <a href="{{ route('settings.blog') }}" class="card-cta">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('SMTP') }}</h4>
                            <p>{{ __('Email SMTP settings, contact us and others related to email.') }}</p>
                            <a href="{{ route('settings.smtp') }}" class="card-cta">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-swatchbook"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('Languages') }}</h4>
                            <p>{{ __('Languages settings , Add and Delete and edit your languages ...') }}</p>
                            <a href="{{ route('languages.index') }}" class="card-cta">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('Ads') }}</h4>
                            <p>{{ __('Manage all ads ,And earn money from advertising') }}</p>
                            <a href="{{ route('settings.ads') }}" class="card-cta text-primary">{{ __('Change Setting') }}
                                <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-solid fa-link"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('API') }}</h4>
                            <p>{{ __('Connect your site with applications via API') }}</p>
                            <a href="{{ route('settings.api') }}" class="card-cta text-primary">{{ __('Change Setting') }}
                                <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-solid fa-code"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('Custom CSS & JS') }}</h4>
                            <p>{{ __('Manage your Custom Css & JS ') }}</p>
                            <a href="{{ route('settings.css.js') }}"
                                class="card-cta text-primary">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-large-icons">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-file-archive"></i>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('License ') }}</h4>
                            <p>{{ __('Manage your License') }}</p>
                            <a href="{{ route('settings.license') }}"
                                class="card-cta text-primary">{{ __('Change Setting') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
