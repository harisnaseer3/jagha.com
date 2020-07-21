@php
    $route_name=  Route::currentRouteName();
@endphp
<!-- <footer class="footer">
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
</footer> -->
<footer id="foot-wrap" class="left relative">
                <div id="foot-top-wrap" class="left relative">
                    <div class="body-main-out relative">
                        <div class="body-main-in">
                            <div id="foot-widget-wrap" class="left relative">
                                                                    <div class="foot-widget left relative">
                                                                                    <div class="foot-logo left realtive">
                                                <img src="/news/wp-content/uploads/2020/05/logo-with-text.png" alt="About Pakistan" data-rjs="2" />
                                            </div><!--foot-logo-->
                                                                                <div class="foot-info-text left relative">
                                            <p>Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.</p> </div><!--footer-info-text-->
                                            

                                        <div class="foot-soc left relative">
                 <p class="mb-2 pr-15"><i class="fa fa-phone mr-2"></i>+92 51 4862317</p>
                <p class="mb-2 pr-15"><i class="fa fa-mobile mr-2 fa-2x"></i>+92 301 5993190</p>
                <p class="mb-2 pr-15"><i class="fa fa-envelope mr-2"></i>info@aboutpakistan.com</p>
                <div class="footer-divider"></div>
                <div class="text-white mt-2"> Join us on Social </div>
                <div class="color-white mt-2">
                <a class="mr-2" href="https://www.facebook.com/aboutpk1"  target="_blank" title="Visit About Pakistan Facebook"><i class="fab fa-facebook-f"></i></a>
                <a class="mr-2" href="https://twitter.com/aboutpk_" target="_blank" title="Visit About Pakistan Twitter"><i class="fab fa-twitter"></i> </a>
                <a class="mr-2" href="https://www.linkedin.com/company/aboutpakistan" target="_blank"  title="Visit About Pakistan Linkedin"><i class="fab fa-linkedin in"></i> </a>
                <a class="mr-2" href="https://www.instagram.com/aboutpk1/?igshid=19bpcgb38304h" target="_blank"  title="Visit About Pakistan Instagram"><i class="fab fa-instagram"></i> </a>
                <a class="mr-2" href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank"  title="Visit About Pakistan Youtube"><i class="fab fa-youtube"></i> </a>
                                        </div><!--foot-soc-->
                                    </div><!--foot-widget-->
              
                                           
            </div>
            <div id="mvp_catlist_widget-8" class="foot-widget left relative mvp_catlist_widget"><h3 class="foot-head">Recent Properties</h3>
             <div class="blog-widget-wrap left relative">
                <ul class="blog-widget-list left relative">
                @foreach($recent_properties as $key => $footer_property)
                            @if($route_name === 'properties.show' && $footer_property->id === $property->id)
                                @continue
                            @else
                            <li><a href="{{$footer_property->property_detail_path()}}" title="{{\Illuminate\Support\Str::limit($footer_property->title, 42, $end='..')}}">{{\Illuminate\Support\Str::limit($footer_property->title, 42, $end='..')}}</a></li>
                            <p class="property-price"> {{\Illuminate\Support\Str::limit($footer_property->city, 30, $end='..')}} |
                                            PKR {{ \Illuminate\Support\Str::limit(explode(',',Helper::getPriceInWords($footer_property->price))[0], 10, $end='...') }}</p>
                            @endif
                @endforeach
                        </ul>
            </div><!--blog-widget-wrap-->

        </div>

         <div id="mvp_catlist_widget-9" class="foot-widget left relative mvp_catlist_widget"><h3 class="foot-head">Featured Partners</h3>
                                                                <div class="blog-widget-wrap left relative">
                        <ul class="blog-widget-list left relative" id="footer-blogs">
                              <div class="col mb-4">
        <div class="d-flex align-items-center small">
        
        </div>
    </div>
                                              
                                            </ul>
            </div><!--blog-widget-wrap-->
            
        </div>                      </div><!--foot-widget-wrap-->
                        </div><!--body-main-in-->
                    </div><!--body-main-out-->
                </div><!--foot-top-->
                <div id="foot-bot-wrap" class="left relative">
                    <div class="body-main-out relative">
                        <div class="body-main-in">
                            <div id="foot-bot" class="left relative">
                                <div class="foot-menu relative">
                                    <div class="menu-main-menu-container">
                                    <ul id="menu-main-menu-2" class="menu"><li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457 page-font"><a href="/index.php">Home</a></li>
<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519 page-font"><a href="/blog" aria-current="page">Blog</a>
</li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10 page-font"><a href="/news">News</a>
</li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2515 page-font"><a href="/medical">Medical</a></li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="/mobile-packages">Mobile Packages</a></li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="/about-us.php">About Us</a></li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="/contact-us.php">Contact Us</a></li>

</ul></div>                             </div><!--foot-menu-->
                                <div class="foot-copy relative">
                                    <p class="page-font">Copyright © 2020. About Pakistan. All rights reserved.</p>
                                </div><!--foot-copy-->
                            </div><!--foot-bot-->
                        </div><!--body-main-in-->
                    </div><!--body-main-out-->
                </div><!--foot-bot-->
            </footer>
