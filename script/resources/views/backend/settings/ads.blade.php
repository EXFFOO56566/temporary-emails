@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>{{__('Ads')}}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
      <div class="breadcrumb-item">{{__('Ads')}}</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">{{__('All About Ads')}}</h2>
    <p class="section-lead">
      {{__('You can adjust all ads here')}}
    </p>

    <div id="output-status"></div>
    <div class="row">
      @include('layouts.setting')
      <div class="col-md-8">
        <form action="{{ route('settings.ads.update')}}" method="POST" autocomplete="on">
          <div class="card" id="settings-card">
            @csrf
            <div class="card-header">
              <h4>{{__('Ads')}}</h4>
            </div>
            <div class="card-body">
              <div class="alert alert-info offset-sm-3 col-sm-6 col-md-9" role="alert">
                <strong>{{__('These fields accept text, html or javascript.')}}</strong>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Top Ad')}}</label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control  @error('top_ad') is-invalid @enderror"
                    name="top_ad">{{$setting['top_ad']}}</textarea>
                  @error('top_ad')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror

                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Bottom Ad')}}</label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control  @error('bottom_ad') is-invalid @enderror"
                    name="bottom_ad">{{$setting['bottom_ad']}}</textarea>
                  @error('bottom_ad')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Left Ad')}}</label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control  @error('left_ad') is-invalid @enderror"
                    name="left_ad">{{$setting['left_ad']}}</textarea>
                  @error('left_ad')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Right Ad')}}</label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control  @error('right_ad') is-invalid @enderror"
                    name="right_ad">{{$setting['right_ad']}}</textarea>
                  @error('right_ad')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Sidebar Ad')}} ({{__('only in
                  blog')}})</label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control  @error('sidebar_ad') is-invalid @enderror"
                    name="sidebar_ad">{{$setting['sidebar_ad']}}</textarea>
                  @error('sidebar_ad')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Head Ad')}} ({{__('Ex: Pop Up Ad
                  ...')}})</label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control  @error('head_ad') is-invalid @enderror"
                    name="head_ad">{{$setting['head_ad']}}</textarea>
                  @error('head_ad')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
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
  </div>
</section>
@endsection
