@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('pages.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{__('Edit Page')}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item"><a href="{{route('pages.index')}}">{{__('Pages')}}</a></div>
            <div class="breadcrumb-item">{{__('Edit Page')}}</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{__('Edit Page')}}</h2>
        <p class="section-lead">
            {{__('On this page you can edit page and fill in all fields.')}}
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Edit Your Page')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pages.update' , $page->id) }}" method="POST" autocomplete="on"
                            enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Title')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ $page->title }}" required placeholder="Titel">
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
                                        id="slug" name="slug" value="{{ $page->slug }}" required placeholder="Slug">
                                    @error('slug')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Content')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea id="summernote" name="content">{{ $page->content }}</textarea>
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
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Language')}}
                                    :</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control selectric" name="lang">
                                        @foreach ($languages as $language)
                                        <option value="{{ $language->code}}" @if($page->lang == $language->code)
                                            selected @endif>{{ $language->name }}</option>
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
                                    class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Status')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="form-control selectric" name="status">
                                        <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>{{__('Publish')}}
                                        </option>
                                        <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>{{__('Draft')}}
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <hr>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Meta Title
                                    (Optional)')}}</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('mete_title') is-invalid @enderror"
                                        name="mete_title" value="{{ $page->mete_title }}"
                                        placeholder="Page Title - Your Site">
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
                                        name="meta_description"
                                        placeholder="Description">{{ $page->meta_description }}</textarea>
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
                                    <button class="btn btn-primary">{{__('Update')}}</button>
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
@endpush

@push('libraies')
<script src="{{ asset('assets/js/vendor/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endpush

@push('scripts')
<!--SET DYNAMIC VARIABLE IN SCRIPT -->
<script type="text/javascript">
    CKEDITOR.replace('content', {
      filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
      filebrowserUploadMethod: 'form'
  });

</script>
@endpush
