@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('features.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Edit Feature')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('features.index')}}">{{__('Features')}}</a></div>
            <div class="breadcrumb-item">{{__('Edit Feature')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('Edit Feature')}}</h2>
        <p class="section-lead">
            {{__('On this page you can edir feature and fill in all fields.')}}
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Edit Feature')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('features.update' , $feature->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Icon') }} **:</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                        name="icon" value="{{ $feature->icon }}" required placeholder='<i class="fas fa-home"></i>'>
                                    @error('icon')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Title')}} :</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ $feature->title }}" required placeholder="Title">
                                    @error('title')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Short Description')}} :</label>
                                <div class="col-sm-12 col-md-7">
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" required
                                        placeholder="Description">{{ $feature->description }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Language')}} :</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control selectric" name="lang">
                                        @foreach ($languages as  $language)
                                            <option value="{{ $language->code}}" @if($feature->lang == $language->code) selected @endif>{{ $language->name }}</option>
                                        @endforeach
                                      </select>
                                    @error('lang')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-primary">{{__('Update')}}</button>
                                </div>
                            </div>
                        </form>

                        <div class="col-12">
                            ** <strong> {{__('Get icon code')}} <a
                                href="https://fontawesome.com/v5.15/icons" target="_black">{{__('Here')}} </a></strong>
                          </div>
                    </div>
                </div>
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