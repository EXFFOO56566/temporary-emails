@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>{{__('Blog Settings')}}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
      <div class="breadcrumb-item">{{__('Blog Settings')}}</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">{{__('All About Blog Settings')}}</h2>
    <p class="section-lead">
      {{__('You can adjust all blog settings here')}}
    </p>

    <div id="output-status"></div>
    <div class="row">
      @include('layouts.setting')

      <div class="col-md-8">
        <form action="{{ route('settings.blog.update')}}" method="POST" autocomplete="on" enctype="multipart/form-data">
          <div class="card" id="settings-card">
            @csrf
            <div class="card-header">
              <h4>{{__('Blog Settings')}}</h4>
            </div>
            <div class="card-body">
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Enable Blog')}}</label>
                <div class="col-sm-6 col-md-9">
                  <label class="custom-switch ">
                    <input type="checkbox" name="enable_blog" class="custom-switch-input" value="1"
                      @if($setting['enable_blog']) checked @endif>
                    <span class="custom-switch-indicator"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Max Posts in Page')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="number" name="max_posts" class="form-control @error('max_posts') is-invalid @enderror"
                    required value="{{$setting['max_posts']}}">
                  @error('max_posts')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Number of popular
                  posts')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="number" name="popular_posts"
                    class="form-control @error('popular_posts') is-invalid @enderror" required
                    value="{{$setting['popular_posts']}}">
                  @error('popular_posts')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>

              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Disqus Comment System')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="disqus" class="form-control @error('disqus') is-invalid @enderror"
                    value="{{$setting['disqus']}}">
                  @error('disqus')
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