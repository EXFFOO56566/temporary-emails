@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Dashboard') }}</h1>
        </div>
        <div class="row">
            @if (empty($setdata['imap_host']))
                <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        {{ __('Please set your IMAP information') }} <a href="{{ route('settings.general') }}"
                            class="alert-link">{{ __('Set Up Now') }}</a>
                    </div>
                </div>
            @endif
            @if (empty($setdata['MAIL_FROM_ADDRESS']))
                <div class="col-lg-12">
                    <div class="alert alert-warning" role="alert">
                        {{ __('Please set your SMTP information') }} <a href="{{ route('settings.smtp') }}"
                            class="alert-link">{{ __('Set Up Now') }}</a>
                    </div>
                </div>
            @endif
            @if (empty($setdata['license']))
                <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        {{ __('Please add your license as soon as possible') }} <a href="{{ route('settings.license') }}"
                            class="alert-link">{{ __('Check it') }}</a>
                    </div>
                </div>
            @endif

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-at"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Emails') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $setdata['total_emails_created'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Messages') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $setdata['total_messages_received'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Posts') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $posts }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total Pages') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $pages }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">{{ __('Messages Received') }}</h5>
                    <div class="card-body">
                        <div id="messges_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">{{ __('Emails Created') }}</h5>
                    <div class="card-body">
                        <div id="email_chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">{{ __('Your Cron Job Command') }}</h4>

                    <code>/usr/local/bin/php {{ env('DEMO_MODE') ? 'SERVER_PATH' : base_path() }}/artisan schedule:run >>
                        /dev/null 2>&1 </code>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        "use strict";
        var data1 = [
            @foreach ($total_messges as $message)
                {{ $message->value . ',' }}
            @endforeach
        ];

        var cat1 = [
            @foreach ($total_messges as $message)
                '{{ $message->created_at->format('d M') }}',
            @endforeach
        ];

        var data2 = [
            @foreach ($total_email as $email)
                {{ $email->value . ',' }}
            @endforeach
        ];

        var cat2 = [
            @foreach ($total_email as $email)
                '{{ $email->created_at->format('d M') }}',
            @endforeach
        ];
    </script>
    <script src="{{ asset('assets/js/vendor/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/charts.js') }}"></script>
@endpush
