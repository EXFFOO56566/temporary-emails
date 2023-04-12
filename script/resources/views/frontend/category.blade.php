@extends('layouts.user')

@section('content')
<!-- Blog Section Start -->
<section class="blog d-flex align-items-center">
    <div class="effect-wrap">
        <i class="fas fa-plus effect effect-1"></i>
        <i class="fas fa-plus effect effect-2"></i>
        <i class="fas fa-circle-notch effect effect-3"></i>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="blog-text">
                    <h1>{{$category->name }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

<!-- Blog Section Start -->
<section class="blog-listing gray-bg">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-8 m-15px-tb">
                {!!$setdata['top_ad']!!}
                <div class="row">
                    @foreach ($posts as $post)
                    <div class="col-sm-6">
                        <div class="blog-grid">
                            <div class="blog-img">
                                <div class="date">
                                    <span>{{$post->created_at->format('d')}}</span>
                                    <label>{{$post->created_at->format('M')}}</label>
                                </div>
                                <a href="{{route('post' , $post->slug)}}">
                                    <img loading="lazy" src="{{asset($post->image)}}" title="{{$post->title}}"
                                        alt="{{$post->title}}">
                                </a>
                            </div>
                            <div class="blog-info">
                                <h5><a href="{{route('post' , $post->slug)}}">{{ Str::limit($post->title, 40) }}</a>
                                </h5>
                                <p>{{ Str::limit($post->description, 90) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-12 mt-2">
                        {{$posts->links("pagination::bootstrap-4")}}
                    </div>
                </div>
                {!!$setdata['bottom_ad']!!}
            </div>

            @include('frontend.sidebar')
        </div>
    </div>
</section>
<!-- Blog Section End -->

@endsection
