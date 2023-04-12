@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{__('Posts')}}</h1>
    <div class="section-header-button">
      <a href="{{route("posts.create")}}" class="btn btn-primary">{{__('Add New')}}</a>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item">{{__('Posts')}}</div>
    </div>
  </div>
  <div class="section-body">
    <h2 class="section-title">{{__('Posts')}}</h2>
    <p class="section-lead">
      {{__('You can manage all posts, such as editing, deleting and more.')}}
    </p>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{__('All Posts')}}</h4>
          </div>
          <div class="card-body">
            <div class="clearfix mb-3"></div>
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Category')}}</th>
                    <th>{{__('Views')}}</th>
                    <th>{{__('Language')}}</th>
                    <th>{{__('Created At')}}</th>
                    <th>{{__('Status')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post)
                  <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}
                      <div class="table-links">
                        <a href="{{route('posts.edit' ,$post->id )}}">{{__('Edit')}}</a>
                        <div class="bullet"></div>
                        <a href="#" class="text-danger confirm" id="{{$post->id}}">{{__('Delete')}}</a>
                        <form id="delete{{$post->id}}" action="{{route('posts.destroy' ,$post->id ) }}" method="POST"
                          class="d-none">
                          @csrf
                          @method("DELETE")
                        </form>
                      </div>
                    </td>
                    <td>
                      [{{$post->category->lang}}] - {{$post->category->name}}
                    </td>
                    <td>
                      {{$post->views}}
                    </td>
                    <td>{{$post->lang}}</td>
                    <td>
                      {{ToDate($post->created_at)}}
                    </td>
                    <td>
                      @if ($post->status == 1)
                      <span class='badge badge-primary'>{{__('Published')}}</span>
                      @else
                      <span class='badge badge-warning'>{{__('Draft')}}</span>
                      @endif
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