@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{__('Languages')}}</h1>
    <div class="section-header-button">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#LanguageModal">
        {{__('Add New')}}
      </button>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item">{{__('Languages')}}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{__('Languages')}}</h2>
    <p class="section-lead">
      {{__('You can manage all languages, such as deleting and more.')}}
    </p>
    <div class="row mt-4">
      <div class="col-12">
        @if(Session::has('error'))
          <div class="alert alert-danger">
              {{ Session::get('error') }}
          </div>
        @endif
        <div class="card">
          <div class="card-header">
            <h4>{{__('All Languages')}}</h4>
          </div>
          <div class="card-body">
            <div class="clearfix mb-3"></div>
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Language Code')}}</th>
                    <th>{{__('RTL')}}</th>
                    <th class="text-center">{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($languages as $language)
                  <tr>
                    <td>{{$language->id}}</td>
                    <td>{!! $language->name !!}</td>
                    <td>{{$language->code}}</td>
                    <td>{{$language->rtl? __('Yes') : __('No')}}</td>
                    <td class="text-center">
                      <a data-toggle="tooltip" data-placement="bottom" title="Edit lang Name & Flag" href="{{route('languages.edit' ,$language->id )}}" class="btn btn-primary bg_primary btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a data-toggle="tooltip" data-placement="top" title="Edit translations" href="{{route('languages.show' ,$language->id )}}" class="btn btn-info  btn-sm">
                        <i class="fas fa-spell-check"></i></a>
                      <button class="btn btn-danger bg_danger btn-sm confirm" id="{{$language->id}}">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete{{$language->id}}" action="{{route('languages.destroy' ,$language->id ) }}"
                        method="POST" class="d-none">
                        @csrf
                        @method("DELETE")
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="LanguageModal" tabindex="-1" role="dialog" aria-labelledby="LanguageModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="LanguageModalLabel">{{__('Create New Language')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('languages.store')}}">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <label class="form-label">{{ __('Name') }} :</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
              value="{{ old('name') }}" required placeholder='Name'>
            @error('name')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Languages') }}</label>

            <select class="selectpicker  @error('code') is-invalid @enderror" required name="code"
              data-live-search="true" data-width="100%">
              @foreach(\File::files('assets/flags') as $path)

              @if(!in_array(pathinfo($path)['filename'],$lang))

              <option value="{{ pathinfo($path)['filename'] }}" data-content="<div class=''><img src='{{ asset('assets/flags/'.pathinfo($path)['filename'].'.png') }}' 
                class='mr-2 flag_img'><span>{{ pathinfo($path)['filename'] }}</span></div>"></option>

              @endif
              @endforeach
            </select>
            @error('code')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 ">{{__('RTL')}}</label>
            <div class="col-sm-6 col-md-9">
              <label class="custom-switch text-md-right">
                <input type="checkbox" name="rtl" class="custom-switch-input" value="1">
                <span class="custom-switch-indicator"></span>
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <button type="submit" class="btn btn-primary">{{__('Add New Language')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@if ($errors->any())
@push('scripts')
<script src="{{ asset('assets/js/vendor/open-modal.js') }}"></script>
@endpush
@endif


@push('styles')
<link href="{{ asset('assets/css/selectric.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/select.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
@endpush


@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap-select.min.js') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/vendor/modules-datatables.js') }}"></script>
@endpush