@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{__('Categories')}}</h1>
    <div class="section-header-button">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CategoryModal">
        {{__('Add New')}}
      </button>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item">{{__('Categories')}}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{__('Categories')}}</h2>
    <p class="section-lead">
      {{__('You can manage all categories, such as editing, deleting and more.')}}
    </p>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{__('All Categories')}}</h4>
          </div>
          <div class="card-body">
            <div class="clearfix mb-3"></div>
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th class="text-center">{{__('Created At')}}</th>
                    <th class="text-center">{{__('Total Posts')}}</th>
                    <th>{{__('Language')}}</th>
                    <th class="text-center">{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $category)
                  <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td class="text-center">{{ToDate($category->created_at)}}</td>
                    <td class="text-center"><span class="badge badge-primary">{{$category->posts->count()}}</span></td>
                    <td>{{$category->lang}}</td>
                    <td class="text-center">
                      <a href="{{route('categories.edit' ,$category->id )}}"
                        class="btn btn-primary bg_primary btn-sm"><i class="fa fa-edit"></i></a>
                      <button class="btn btn-danger bg_danger btn-sm confirm" id="{{$category->id}}">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete{{$category->id}}" action="{{route('categories.destroy' ,$category->id ) }}"
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

<!-- Modal -->
<div class="modal fade" id="CategoryModal" tabindex="-1" role="dialog" aria-labelledby="CategoryModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CategoryModalLabel">{{__('Create New Category')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('categories.store')}}">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <label class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
              value="{{ old('name') }}" required placeholder="Category Name">
            @error('name')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Slug') }}</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
              value="{{ old('slug') }}" required placeholder="Slug">
            @error('slug')
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
          <button type="submit" class="btn btn-primary">{{__('Add Category')}}</button>
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

<!--SET DYNAMIC VARIABLE IN SCRIPT -->
<script type="text/javascript">
var checkslug = "{{route('categories.checkslug')}}";
</script>
@endpush