@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('categories.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Edit Category')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('categories.index')}}">{{__('Categories')}}</a></div>
            <div class="breadcrumb-item">{{__('Edit Category')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('Edit Category')}}</h2>
        <p class="section-lead">
            {{__('On this page you can edir category and fill in all fields.')}}
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Edit Your Category')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update' , $category->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Category Name')}}
                                    :</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $category->name }}" required placeholder="Category Name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Slug')}} :</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        name="slug" value="{{ $category->slug }}" required placeholder="Slug">
                                    @error('slug')
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
                                            <option value="{{ $language->code}}" @if($category->lang == $language->code) selected @endif>{{ $language->name }}</option>
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