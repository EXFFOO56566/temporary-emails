<div class="col-lg-4 m-15px-tb blog-aside">


    <!-- AD -->
    <div class="widget widget-post">
        {!!$setdata['sidebar_ad']!!}
    </div>
    <!-- End AD-->

    <!-- Latest Post -->
    <div class="widget widget-latest-post">
        <div class="widget-title">
            <h3>{{translate('Popular Posts')}}</h3>
        </div>
        <div class="widget-body">
            @foreach ($popular_posts as $post)
            <div class="latest-post-aside media">
                <div class="lpa-left media-body">
                    <div class="lpa-title">
                        <h5><a href="{{route('post' , $post->slug)}}">{{$post->title}}</a></h5>
                    </div>
                    <div class="lpa-meta">
                        <a class="name" href="{{route('category' , $post->category->slug)}}">
                            {{$post->category->name}}
                        </a>
                        <a class="date" href="{{route('post' , $post->slug)}}">
                            {{$post->created_at->format('d M Y')}}
                        </a>
                    </div>
                </div>
                <div class="lpa-right">
                    <a href="{{route('post' , $post->slug)}}">
                        <img src="{{asset($post->image)}}" title="{{$post->title}}" alt="{{$post->title}}">
                    </a>
                </div>
            </div>
            @endforeach


        </div>
    </div>
    <!-- End Latest Post -->

    <!-- widget category -->
    <div class="widget widget-category">
        <div class="widget-title">
            <h3>{{translate('Categories')}}</h3>
        </div>
        <div class="widget-body">
            <div class="nav tag-cloud">
                @foreach ($categories as $category)
                <a href="{{route('category' , $category->slug)}}">{{$category->name}}</a>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End widget Tags -->
</div>