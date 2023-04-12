@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{__('Pages')}}</h1>
    <div class="section-header-button">
      <a href="{{route("pages.create")}}" class="btn btn-primary">{{__('Add New')}}</a>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item">{{__('Pages')}}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{__('Pages')}}</h2>
    <p class="section-lead">
      {{__('You can manage all pages, such as editing, deleting and more.')}}
    </p>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{__('All Pages')}}</h4>
          </div>
          <div class="card-body">
            <div class="clearfix mb-3"></div>
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Created At')}}</th>
                    <th>{{__('Language')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pages as $page)
                  <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->title}}
                    </td>
                    <td>
                      {{ToDate($page->created_at)}}
                    </td>
                    <td>{{$page->lang}}</td>
                    <td>
                      @if ($page->status == 1)
                      <span class='badge badge-primary'>{{__('Published')}}</span>
                      @else
                      <span class='badge badge-warning'>{{__('Draft')}}</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <a href="{{route('pages.edit' ,$page->id )}}" class="btn btn-primary bg_primary btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <button class="btn btn-danger bg_danger btn-sm confirm" id="{{$page->id}}">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete{{$page->id}}" action="{{route('pages.destroy' ,$page->id ) }}" method="POST"
                        class="d-none">
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
@endsection

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