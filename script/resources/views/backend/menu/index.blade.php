@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{__('Features')}}</h1>
    <div class="section-header-button">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MenuModal">
        {{__('Add New Link')}}
      </button>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item">{{__('Features')}}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{__('Simple Menu')}}</h2>
    <p class="section-lead">
      {{__('You can manage all links, such as deleting and more.')}}
    </p>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{__('All Links')}}</h4>
          </div>
          <div class="card-body">
            <div class="clearfix mb-3"></div>
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{__('Icon')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Url')}}</th>
                    <th>{{__('Postion')}}</th>
                    <th class="text-center">{{__('Created At')}}</th>
                    <th class="text-center">{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($links as $link)
                  <tr>
                    <td>{{$link->id}}</td>
                    <td>{!! $link->icon !!}</td>
                    <td>{{$link->title}}</td>
                    <td><a class="btn btn-sm btn-primary" href="{{$link->url}}" target="_blank" >Show</a></td>
                    <td>{{$link->postion == 0 ? "Header" : "Footer"}}</td>
                    <td class="text-center">{{ToDate($link->created_at)}}</td>
                    <td class="text-center">
                      <a href="{{route('menu.edit' ,$link->id )}}"
                        class="btn btn-primary bg_primary btn-sm"><i class="fa fa-edit"></i></a>
                      <button class="btn btn-danger bg_danger btn-sm confirm" id="{{$link->id}}">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete{{$link->id}}" action="{{route('menu.destroy' ,$link->id ) }}"
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
<div class="modal fade" id="MenuModal" tabindex="-1" role="dialog" aria-labelledby="MenuModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="MenuModalLabel">{{__('Create New Link')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('menu.store')}}">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <label class="form-label">{{ __('Icon') }} : <strong> {{__('Get icon code')}} <a
                  href="https://fontawesome.com/v5.15/icons" target="_black">{{__('Here')}} </a></strong> {{__('(optional)')}}</label>
            <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"
              value="{{ old('icon') }}" placeholder='<i class="fas fa-home"></i>'>
            @error('icon')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Title') }} {{__('(optional)')}}</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
              value="{{ old('title') }}" placeholder="Titel">
            @error('title')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Url') }}</label>
            <input type="url" class="form-control @error('url') is-invalid @enderror" name="url"
              value="{{ old('url') }}" required placeholder="{{url('/')}}">
            @error('url')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Postion') }}</label>
            <select class="form-control selectric" name="postion">
              <option value="0">Header</option>
              <option value="1">Footer</option>
            </select>
            @error('lang')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Open In New Tab') }}</label>
                <div>
                  <label class="custom-switch ">
                    <input type="checkbox" name="target" class="custom-switch-input" value="1">
                    <span class="custom-switch-indicator"></span>
                  </label>
                </div>
          </div>

          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <button type="submit" class="btn btn-primary">{{__('Add New Link')}}</button>
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
@endpush


@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.selectric.min.js') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/vendor/modules-datatables.js') }}"></script>
@endpush