@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{__('Features')}}</h1>
    <div class="section-header-button">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#FeatureModal">
        {{__('Add New')}}
      </button>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item">{{__('Features')}}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{__('Features')}}</h2>
    <p class="section-lead">
      {{__('You can manage all features, such as deleting and more.')}}
    </p>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{__('All Features')}}</h4>
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
                    <th>{{__('Description')}}</th>
                    <th>{{__('Language')}}</th>
                    <th class="text-center">{{__('Created At')}}</th>
                    <th class="text-center">{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($features as $feature)
                  <tr>
                    <td>{{$feature->id}}</td>
                    <td>{!! $feature->icon !!}</td>
                    <td>{{$feature->title}}</td>
                    <td>{{$feature->description}}</td>
                    <td>{{$feature->lang}}</td>
                    <td class="text-center">{{ToDate($feature->created_at)}}</td>
                    <td class="text-center">
                      <a href="{{route('features.edit' ,$feature->id )}}"
                        class="btn btn-primary bg_primary btn-sm"><i class="fa fa-edit"></i></a>
                      <button class="btn btn-danger bg_danger btn-sm confirm" id="{{$feature->id}}">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete{{$feature->id}}" action="{{route('features.destroy' ,$feature->id ) }}"
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
<div class="modal fade" id="FeatureModal" tabindex="-1" role="dialog" aria-labelledby="FeatureModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="FeatureModalLabel">{{__('Create New Feature')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('features.store')}}">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <label class="form-label">{{ __('Icon') }} : <strong> {{__('Get icon code')}} <a
                  href="https://fontawesome.com/v5.15/icons" target="_black">{{__('Here')}} </a></strong></label>
            <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"
              value="{{ old('icon') }}" required placeholder='<i class="fas fa-home"></i>'>
            @error('icon')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Title') }}</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
              value="{{ old('title') }}" required placeholder="Titel">
            @error('title')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Short Description') }}</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" required
              placeholder="Description">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Language') }}</label>
            <select class="form-control selectric" name="lang">
              @foreach ($languages as  $language)
                  <option value="{{ $language->code }}">{{ $language->name }}</option>
              @endforeach
            </select>
            @error('lang')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <button type="submit" class="btn btn-primary">{{__('Add New Feature')}}</button>
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