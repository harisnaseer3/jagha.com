@php
    $route_name=  Route::currentRouteName();
@endphp
<footer class="footer">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="footer-item">
                    <div class="footer-logo">
                        <a href="{{route('home')}}">
                            <img src="{{asset('website/img/logos/logo-with-text-309x66.png')}}" data-src="images/logo-with-text-white-309x66.png" class="img-fluid img-defer" alt="logo">
                        </a>
                    </div>
                    <h5 style="line-height: 26px; font-weight: 400; color: #555; font-size: 14px">
                        Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.
                    </h5>

                    <p class="mb-2 pr-15"><i class="fa fa-phone mr-2"></i>+92 51 4862317</p>
                    <p class="mb-2 pr-15"><i class="fa fa-mobile mr-2"></i>+92 301 5993190</p>
                    <p class="mb-2 pr-15"><i class="fa fa-envelope mr-2"></i>info@aboutpakistan.com</p>
                    <hr>
                    <p class="m-0 ml-2">Join us on Social</p>
                    <ul class="social-list clearfix mt-0">
                        <li><a class="m-2 facebook" href="https://www.facebook.com/aboutpk1" target="_blank" rel="noopener"><i class="fab fa-facebook"></i></a></li>
                        <li><a class="m-2 twitter" href="https://twitter.com/aboutpk_" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a></li>
                        <li><a class="m-2 linkedin" href="https://www.linkedin.com/company/aboutpakistan" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i></a></li>
                        <li><a class="m-2 instagram" href="https://www.instagram.com/aboutpk1/?igshid=19bpcgb38304h" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a></li>
                        <li><a class="m-2" href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank" rel="noopener"><i class="fab fa-youtube"></i> </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="footer-item clearfix">
                    <h4>Recent Properties</h4>
                    <div class="s-border"></div>
                    <div class="m-border"></div>
                    <div class="popular-posts">
                        @foreach($recent_properties as $key => $footer_property)
                            @if($route_name === 'properties.show' && $footer_property->id === $property->id)
                                @continue
                            @else
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h3 class="media-heading">
                                            <a href="{{$footer_property->property_detail_path()}}">{{\Illuminate\Support\Str::limit($footer_property->title, 42, $end='..')}}</a>
                                        </h3>
                                        <p> {{\Illuminate\Support\Str::limit($footer_property->city, 30, $end='..')}} |
                                            PKR {{ \Illuminate\Support\Str::limit(explode(',',Helper::getPriceInWords($footer_property->price))[0], 10, $end='...') }}</p>
                                    </div>
                                </div>
                                @if($key + 1 < count($recent_properties))
                                    <hr class="custom-hr">
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="footer-item">
                    <h4>Property Agencies</h4>
                    <div class="s-border"></div>
                    <div class="m-border"></div>
                    <div class="popular-posts">
                        @foreach($footer_agencies as $key => $agency)
                            <div class="media">
                                <div class="media-body align-self-center">
                                    <h3 class="media-heading">
                                        <a href=javaScript:void(0);>{{\Illuminate\Support\Str::limit($agency->title, 42, $end='..')}}</a>
                                        <span>-</span>
                                        <span>
                                            {{\Illuminate\Support\Str::limit(implode (", ", json_decode($agency->city)), 25, $end='..')}} </span>
                                    </h3>
                                    <p><i class="fa fa-user mr-1"></i> {{\Illuminate\Support\Str::limit($agency->ceo_name, 30, $end='..')}} |
                                        <i class="fa fa-phone mr-1"></i> {{$agency->cell}}</p>
                                </div>
                            </div>
                            @if($key + 1 < count($footer_agencies))
                                <hr class="custom-hr">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="foot-menu">
                    <p class="foot-copy">Copyright ©
                        <script>document.write(new Date().getFullYear());</script>
                        . About Pakistan. All rights reserved.
                    </p>
                    <div class="footer-menu-inline-list">
                        <ul class="list-inline footer-inline-ul">
                            <li class="list-inline-item"><a style="" href="{{asset('https://www.aboutpakistan.com/')}}">Home</a></li>
                            <li class="list-inline-item"><a href="{{asset('https://www.aboutpakistan.com/blog/index.php')}}">Blog</a></li>
                            <li class="list-inline-item"><a href="{{asset('https://www.aboutpakistan.com/news/index.php')}}">News</a></li>
                            <li class="list-inline-item"><a href="{{asset('https://www.aboutpakistan.com/news/category/sports/')}}">Sports</a></li>
                            <li class="list-inline-item"><a href="{{asset('https://www.aboutpakistan.com/medical/index.php')}}">Medical</a></li>
                            <li class="list-inline-item"><a href="{{asset('https://www.aboutpakistan.com/mobile-package.php')}}">Mobile Package</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
