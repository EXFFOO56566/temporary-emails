@extends('layouts.admin')

@section('content')
<section class="section">

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('languages.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{$language->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
            <div class="breadcrumb-item">{{$language->name}}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('languages.update_translation') }}" method="POST">
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link {{empty(request()->segment(5))? 'active' : ""}}"
                                        href="{{ route('languages.show' , $language->id) }}">General</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{request()->segment(5) == 'seo' ? 'active' : "" }}"
                                        href="{{ route('languages.show.seo' , $language->id) }}">Seo</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{request()->segment(5) == 'text' ? 'active' : "" }}"
                                        href="{{ route('languages.show.text' , $language->id) }}">Texts</a>
                                </li>
                            </ul>
                            <div class="clearfix mb-3"></div>
                            <div class="table-responsive">
                                @csrf
                                <div class="card-body">
                                    @foreach ($translates as $translate)
                                    <div class="row mb-2">
                                        <div class="col-sm-5">{{$translate->key}}</div>
                                        <div class="col-sm-7">
                                            @if(request()->segment(5) == 'text')
                                            <textarea class="ckeditor"
                                                name="values[{{$translate->id}}]">{{$translate->value}}</textarea>
                                            @else

                                            <input type="text" name="values[{{$translate->id}}]" class="form-control"
                                                value="{{$translate->value}}">

                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" type="submit">{{__('Save Changes')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('libraies')
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endpush

@push('scripts')
<!--SET DYNAMIC VARIABLE IN SCRIPT -->
<script type="text/javascript">

</script>
@endpush
