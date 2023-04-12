@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('posts.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Create New Post')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item"><a href="{{route('posts.index')}}">{{__('Posts')}}</a></div>
            <div class="breadcrumb-item">{{__('Create New Post')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('Create New Post')}}</h2>
        <p class="section-lead">
            {{__('On this page you can create a new post and fill in all fields.')}}
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4{{__('>Write Your Post')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('posts.store')}}" method="POST" autocomplete="on"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Title')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}" required placeholder="Titel">
                                    @error('title')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Slug')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug') }}" required placeholder="Slug">
                                    @error('slug')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Description')}}
                                    (max:200)</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        name="description" required placeholder="Description"></textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Keywords')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" data-role="tagsinput"
                                        class="form-control  @error('keywords') is-invalid @enderror" name="keywords"
                                        value="{{ old('keywords') }}" required placeholder="Keywords">
                                    @error('keywords')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Language')}}
                                    :</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control selectric" name="lang" id="language">
                                        <option value="" selected disabled>Choose</option>
                                        @foreach ($languages as $language)
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

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Category')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control" required name="category_id" id="category">
                                        <option value="" selected disabled>Choose</option>
                                    </select>
                                    <div class="mb-3">
                                        <input type="hidden"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        @error('category_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Content')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea id="summernote" name="content">{{ old('content') }}</textarea>
                                    <div class="mb-3">
                                        <input type="hidden"
                                            class="form-control @error('content') is-invalid @enderror">
                                        @error('content')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Thumbnail')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">{{__('Choose File')}}</label>
                                        <input type="file" name="thumbnail" id="image-upload" />
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden"
                                            class="form-control @error('thumbnail') is-invalid @enderror">
                                        @error('thumbnail')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Status')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control selectric" name="status">
                                        <option value="1">{{__('Publish')}}</option>
                                        <option value="0">{{__('Draft')}}</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Meta Title
                                    (Optional)')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('mete_title') is-invalid @enderror"
                                        name="mete_title" value="{{ old('mete_title') }}"
                                        placeholder="Post Title - Your Site">
                                    @error('mete_title')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Meta
                                    Description (Optional Max:160)')}}
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                        name="meta_description" placeholder="Description"></textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-primary">{{__('Create Post')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="{{ asset('assets/css/selectric.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
@endpush

@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/uploadPreview_custom.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap-tagsinput.min.js') }}"></script>
@endpush

@push('scripts')
<!--SET DYNAMIC VARIABLE IN SCRIPT -->
<script type="text/javascript">
    var checkslug_title = "{{route('posts.checkslug')}}";
  CKEDITOR.replace('content', {
      filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
      filebrowserUploadMethod: 'form'
  });

</script>
@endpush
