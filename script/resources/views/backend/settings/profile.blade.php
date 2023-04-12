@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>{{__('Profile Settings')}}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
      <div class="breadcrumb-item">{{__('Profile Settings')}}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-md-4">
        <h2 class="section-title">{{__('Profile Information')}}</h2>
        <p class="section-lead">
          {{__('Update your account\'s profile information and email address.')}}
        </p>
      </div>
      <div class="col-md-8">
        <form action="{{ route('settings.info.update')}}" method="POST" autocomplete="on" enctype="multipart/form-data">
          <div class="card" id="settings-card">
            @csrf
            <div class="card-header">
              <h4>{{__('Profile Information')}}</h4>
            </div>
            <div class="card-body">
              <div class="form-group row align-items-center">

                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Photo')}}</label>
                <div class="col-sm-6 col-md-9">
                  <div id="profile-preview" class="bg-preview"></div><br />
                  <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                    id="profile-upload" />
                  @error('photo')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Full Name')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required
                    value="{{$user->name}}">
                  @error('name')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Email')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required
                    value="{{$user->email}}">
                  @error('email')
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
    <hr>
    <div class="row">
      <div class="col-md-4">
        <h2 class="section-title">{{__('Update Password')}}</h2>
        <p class="section-lead">
          {{__('Ensure your account is using a long, random password to stay secure.')}}
        </p>
      </div>
      <div class="col-md-8">
        <form action="{{ route('settings.password.update')}}" method="POST" autocomplete="on">
          <div class="card" id="settings-card">
            @csrf
            <div class="card-header">
              <h4>{{__('Update Password')}}</h4>
            </div>
            <div class="card-body">
              <div class="form-group row align-items-center">
                <label class="form-control-label col-sm-3 text-md-right">{{__('Current Password')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="password" name="current_password"
                    class="form-control @if(session()->has('error')) is-invalid @endif" required>
                  @if(session()->has('error'))
                  <div class="invalid-feedback">
                    <strong>{{ session()->get('error') }}</strong>
                  </div>
                  @endif
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('New Password')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    required>
                  @error('password')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('Confirm Password')}}</label>
                <div class="col-sm-6 col-md-9">
                  <input type="password" name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror" required>
                  @error('password_confirmation')
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

@push('styles')
<!--SET DYNAMIC VARIABLE IN STYLE-->
<style>
  .bg-preview{
    background-image: url('{{asset($user->avater)}}');
  }
</style>
@endpush

@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.uploadPreview.min.js') }}"></script>
@endpush
