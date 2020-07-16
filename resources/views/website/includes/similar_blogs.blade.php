<div class="blog blog content-area-12 pt-0">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1>Similar blog Articles</h1>
        </div>
        <div class="row">
            @foreach($similar_results as $value)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-1">
                        <div class="blog-photo">
                            <a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($value->post_title),$value->id])}}"><img src="{{asset('img/blogs/'.$value->image)}}" alt="blog" class="img-fluid"></a>
                            <div class="date-box">
                                <span>{{date_format(date_create($value->post_date),"d")}}</span>
                                {{date_format(date_create($value->post_date),"M")}}
                            </div>
                        </div>
                        <div class="detail blog-detail">
                            <h3><a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($value->post_title),$value->id])}}">{{ \Illuminate\Support\Str::limit(strip_tags($value->post_title), 69, $end='...') }}</a></h3>
                            <div class="post-meta clearfix">
                                <span><a href="javascript:void(0)" tabindex="0"><i class="fa fa-user"></i>{{ $value->author }}</a></span>
                            </div><p>{{ \Illuminate\Support\Str::limit(strip_tags($value->post_content), 74, $end='...') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
