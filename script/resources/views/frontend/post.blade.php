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
          <h1>{{$post->title}}</h1>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Blog Section End -->

<!-- Blog Section Start -->
<div class="blog-single gray-bg">
  <div class="container">
    <div class="row align-items-start">
      <div class="col-lg-8 m-15px-tb">
        <article class="article">

          <div class="article-img mb-3">
            <img src="{{asset($post->image)}}" title="{{$post->title}}" alt="{{$post->title}}">
          </div>
          {!!$setdata['top_ad']!!}
          <div class="article-title">
            <h6>{{translate('Published in')}} : {{$post->created_at->format('d M Y')}}</h6>
            <h2>{{$post->title}}</h2>

          </div>
          <div class="article-content">
            {!! $post->content !!}
          </div>
          <div class="nav tag-cloud mb-1">
            <a href="{{route('category' , $post->category->slug)}}">{{$post->category->name}}</a>
          </div>
          {!!$setdata['bottom_ad']!!}
        </article>

        @if (!empty($setdata['disqus']))
        <div class="contact-form article-comment">
          <h4>{{translate('Leave a Reply')}}</h4>
          <div id="disqus_thread"></div>
          <script>
            var disqus_config = function () {
                this.page.url = "{{url()->current()}}";  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier ="{{$post->id}}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                
                (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = '{{$setdata['disqus']}}';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
                })();
          </script>
          <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
              Disqus.</a></noscript>
        </div>
        @endif
      </div>
      @include('frontend.sidebar')
    </div>
  </div>
</div>
<!-- Blog Section End -->

@endsection