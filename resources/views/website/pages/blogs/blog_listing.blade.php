@extends('website.layouts.app')

@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('json-ld')
    <?php echo $blog_organization->toScript()  ?>
    <?php echo $blog_website->toScript()  ?>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
@endsection

@section('content')
    <!-- Top header start -->
    @include('website.includes.nav')
    <!-- Main header start -->
    <!-- Blog body start -->
    <div class="blog-body content-area blog-padding">
        <div class="container">
            <div class="row more-blogs">
                @foreach($results as $key => $result)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-3">
                            <div class="blog-photo">
                                <a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($result->post_title),$result->id])}}" title="{{$result->post_title}}">
                                    <img src="{{asset('img/blogs/'.$result->image)}}" alt="{{$result->post_title}}" class="img-fluid"></a>
                                <div class="date-box">
                                    <span>{{date_format(date_create($result->post_date),"d")}}</span>
                                    {{date_format(date_create($result->post_date),"M")}}
                                </div>
                            </div>
                            <div class="post-meta">
                                <ul>
                                    <li class="profile-user">
                                        <img src="{{asset('website/img/avatar/user.png')}}" alt="{{$result->author}}" title="{{$result->author}}"
                                             style="max-height: 35px; max-width: 35px; margin-top: 0">
                                    </li>
                                    <li>By <span>{{$result->author}}</span></li>
                                </ul>
                            </div>
                            <div class="caption detail blog-detail">
                                <h4><a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($result->post_title),$result->id])}}"
                                       title="{{$result->post_title}}">{{ \Illuminate\Support\Str::limit(strip_tags($result->post_title), 75, $end='...') }}</a></h4>
                                <h5 class="font-size-14 color-555"
                                    style="font-weight: 400; line-height: 26px">{{ \Illuminate\Support\Str::limit(strip_tags($result->post_content), 74, $end='...') }}</h5>

                            </div>
                        </div>
                        @if($key+1 === count($results))
                            <span id="blog-list" data-index="{{$result->id}}"></span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-block btn-primary w-50 ml-auto mr-auto" id="load-more" role="button" style="background-color: #274abb; border-color:#274abb ">Load More</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="subscribeModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Subscribe</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <!--TODO: Check if user already subscribed -->
                            <div class="col-12">
                                <div class="Subscribe-box">
                                    <p>Be the first to hear about new properties</p>
                                    <form id="subscribe-form">
                                        <div class="mb-3">
                                            <input id="subscribe" type="email" class="form-contact" name="email" placeholder="example@example.com"
                                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="submit" name="submitNewsletter" class="btn btn-block button-theme" value="SUBSCRIBE">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer start -->
    @include('website.includes.footer')
    <div class="fly-to-top back-to-top">
        <i class="fa fa-angle-up fa-3"></i>
        <span class="to-top-text">To Top</span>
    </div><!--fly-to-top-->
    <div class="fly-fade">
    </div><!--fly-fade-->
@endsection

@section('script')
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/blog-page.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
@endsection
