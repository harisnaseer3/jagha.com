@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('json-ld')
    <?php echo $blog_organization->toScript()  ?>
@endsection

@php
    $result = $result[0];
@endphp
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')
    <!-- Top header start -->
    @include('website.includes.nav')
    <!-- Blog body start -->
    <div class="blog-body content-area-5" style=" padding: 50px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Blog box start -->
                    <div class="blog-1 blog-big">
                        <div class="blog-photo">
                            <img src="{{asset('img/blogs/'.$result->image)}}" alt="blog-img" class="img-fluid">
                        </div>
                        <div class="detail">
                            <h2>
                                <a href="javascript:void(0);">{{$result->post_title}}</a>
                            </h2>
                            <div class="post-meta clearfix mb-20">
                                <span><a href="javascript:void(0)" tabindex="0"><i class="fa fa-user"></i>{{$result->author}} </a></span>
                                <span><a href="javascript:void(0)" tabindex="0"><i class="fa fa-calendar"></i>Posted on {{date_format(date_create($result->post_date),"M d, Y")}}</a></span>
                            </div>
                            <p id="paragraph">
                                @php echo htmlspecialchars_decode($result->post_content) @endphp
                            </p>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="blog-tags">
                                    <span>Tags</span>
                                    <a href="javascript:void(0)">{{$result->category}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    @include('website.includes.similar_blogs')
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
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#subscribeModalCenter").modal('show')
            }, 4000);
            $('#subscribe-form').on('submit', function (e) {
                e.preventDefault();
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    type: 'post',
                    url: window.location.origin+'/property/subscribe',
                    data: {
                        email: $('#subscribe').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 200) {
                            let btn = '<button class="btn btn-block btn-success"><i class="far fa-check-circle"></i> SUBSCRIBED </button>'
                            $("#subscribe-form").slideUp();
                            $('.Subscribe-box').append(btn);
                        } else {
                            //
                        }
                    },
                    error: function (xhr, status, error) {
                        // console.log(error);
                    },
                    complete: function (url, options) {
                    }
                });
            });
        });
    </script>
@endsection
