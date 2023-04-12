@extends('layouts.admin')

@section('content')
<section class="section">
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('languages.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>{{__('Edit Language')}}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard')}}">{{__('Dashboard')}}</a></div>
        <div class="breadcrumb-item"><a href="{{ route('languages.index')}}">{{__('Languages')}}</a></div>
        <div class="breadcrumb-item">{{__('Edit Language')}}</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">{{__('Edit Language')}}</h2>
    <p class="section-lead">
        {{__('On this page you can edir language and fill in all fields.')}}
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Edit Language')}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('languages.update' , $language->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }} :</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $language->name }}" required placeholder='Name'>
                                @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Title')}} :</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="selectpicker  @error('code') is-invalid @enderror" required name="code"
                                data-live-search="true" data-width="100%">
                                @foreach(\File::files('assets/flags') as $path)
                                @if(!in_array(pathinfo($path)['filename'],$lang))
                                <option @if($language->code == pathinfo($path)['filename']) selected @endif value="{{ pathinfo($path)['filename'] }}" data-content="<div class=''><img src='{{ asset('assets/flags/'.pathinfo($path)['filename'].'.png') }}' 
                                    class='mr-2 flag_img'><span>{{ pathinfo($path)['filename'] }}</span></div>"></option>
                                @endif
                                @endforeach
                                </select>
                                @error('title')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('RTL')}} :</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch">
                                    <input type="checkbox" name="rtl" class="custom-switch-input" value="1"
                                        @if($language->rtl) checked @endif>
                                    <span class="custom-switch-indicator"></span>
                                    </label>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">{{__('Update')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
@endpush


@push('libraies')
<script src="{{ asset('assets/js/vendor/bootstrap-select.min.js') }}"></script>
@endpush