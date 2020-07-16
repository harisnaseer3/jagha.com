<div class="blog blog content-area-12 pt-0">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h2>Recent Blog Articles</h2>
        </div>
        <div class="row">
            @foreach($blogs as $result)
                <div itemscope itemtype='http://schema.org/Article' class="col-lg-4 col-md-6">
                    <div class="blog-1">
                        <div class="blog-photo">
                            <a itemprop="url" href="{{route('blogs.show',[\Illuminate\Support\Str::slug($result->post_title),$result->id])}}" title="{{ \Illuminate\Support\Str::limit(strip_tags($result->post_title), 47, $end='...') }}">
                                <img itemprop="image" src="{{asset('img/blogs/'.$result->image)}}" alt="{{ \Illuminate\Support\Str::limit(strip_tags($result->post_title), 47, $end='...') }}"
                                     class="img-fluid"></a>
                            <div class="date-box" itemprop="datePublished" content="{{$result->post_date}}">
                                <span>{{date_format(date_create($result->post_date),"d")}}</span>
                                {{date_format(date_create($result->post_date),"M")}}
                            </div>
                        </div>
                        <div class="detail blog-detail">
                            <h3>
                                <a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($result->post_title),$result->id])}}" title="{{ \Illuminate\Support\Str::limit(strip_tags($result->post_title), 47, $end='...') }}">
                                    <span itemprop="headline">{{\Illuminate\Support\Str::limit(strip_tags($result->post_title), 47, $end='...') }}</span>
                                </a>
                            </h3>
                            <div class="post-meta clearfix">

                                <span><a href="javascript:void(0)" tabindex="0">
                                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                                            <span itemprop="name"><i class="fa fa-user"></i>{{$result->author }}</span></span>
                                    </a>
                                </span>
                            </div>
                            <p itemprop="articleBody">{{ \Illuminate\Support\Str::limit(strip_tags($result->post_content), 74, $end='...') }}</p>
                            <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                    <meta itemprop="url" content="{{asset('img/logo/logo-with-text-309x66.png')}}">
                                    <meta itemprop="width" content="400">
                                    <meta itemprop="height" content="60">
                                </div>
                                <meta itemprop="name" content="aboutpakistan">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
