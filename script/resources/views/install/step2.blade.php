@extends('layouts.install')
@section('title', 'Install - Step 2')
@section('content')
<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-5">
    <div class="card mt-3">
        <div class="card-body text-center">
            <h4 class="card-title mb-2">{{ __('Great Job :)') }} <a href="https://cutt.ly/PLFZenO" target="_blank">NULLED :: Web Community</a></h4>
            <p>{{ __('There is more few steps to make your website works') }}</p>
            <p class="text-muted">{{ __('Now lets get your website ready.') }}</p>
            <form action="{{route('install/step2/import_database')}}" method="POST" class="my-login-validation"
                novalidate="">
                @csrf
                <div class="form-group m-0">
                    <button type="submit" name="logBtn" class="btn btn-primary btn-block btn-pd">
                        {{ __('Get Started') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop