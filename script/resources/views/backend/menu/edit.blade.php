@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('menu.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Edit Link')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('menu.index')}}">{{__('Simple Menu')}}</a></div>
            <div class="breadcrumb-item">{{__('Edit Link')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('Edit Link')}}</h2>
        <p class="section-lead">
            {{__('On this page you can edir link and fill in all fields.')}}
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Edit Link')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('menu.update' , $menu->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Icon') }}
                                    **:</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                        name="icon" value="{{ $menu->icon }}" placeholder='<i class="fas fa-home"></i>'>
                                    @error('icon')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Title')}}
                                    :</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ $menu->title }}" placeholder="Title">
                                    @error('title')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Url')}}
                                    :</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="url" class="form-control @error('url') is-invalid @enderror" name="url"
                                        value="{{ $menu->url }}" required placeholder="{{url('/')}}">
                                    @error('url')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Postion')}}
                                    :</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control selectric" name="postion">
                                        <option value="0" @if($menu->postion == 0) selected @endif>Header</option>
                                        <option value="1" @if($menu->postion == 1) selected @endif>Footer</option>
                                    </select>
                                    @error('lang')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Open In New
                                    Tab')}} :</label>
                                <div class="col-sm-12 col-md-7">
                                    <label class="custom-switch ">
                                        <input type="checkbox" name="target" class="custom-switch-input" value="1"
                                            @if($menu->target) checked @endif>
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

                        <div class="col-12">
                            ** <strong> {{__('Get icon code')}} <a href="https://fontawesome.com/v5.15/icons"
                                    target="_black">{{__('Here')}} </a></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection