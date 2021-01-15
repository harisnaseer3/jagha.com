@php
    $route_name=  Route::currentRouteName();
@endphp
<footer id="foot-wrap" class="left relative">
    <div id="foot-top-wrap" class="left relative">
        <div class="body-main-out relative">
            <div class="body-main-in">
                <div id="foot-widget-wrap" class="left relative">
                    <div class="foot-widget left relative">
                        <div class="foot-logo left relative">
                            <a href="https://www.aboutpakistan.com">
                            <img src="{{asset('img/logo/logo-with-text.png')}}" alt="About Pakistan" data-rjs="2"/>
                            </a>
                        </div><!--foot-logo-->
                        <div class="foot-info-text left relative">
                            <p>Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.</p></div>
                        <!--footer-info-text-->


                        <div class="foot-soc left relative">
                            <p class="mb-2 pr-15"><i class="fa fa-phone mr-2"></i>+92 51 4862317</p>
                            <p class="mb-2 pr-15"><i class="fa fa-mobile mr-2 fa-2x"></i>+92 315 5141959</p>
                            <p class="mb-2 pr-15"><i class="fa fa-envelope mr-2"></i>info@aboutpakistan.com</p>
                            <div class="footer-divider"></div>
                            <div class="text-white mt-2"> Join us on Social</div>
                            <div class="color-white mt-2">
                                <a class="mr-2" href="https://www.facebook.com/aboutpkofficial" target="_blank" title="Visit About Pakistan Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a class="mr-2" href="https://twitter.com/aboutpkofficial" target="_blank" title="Visit About Pakistan Twitter"><i class="fab fa-twitter"></i> </a>
                                <a class="mr-2" href="https://www.linkedin.com/company/aboutpkofficial" target="_blank" title="Visit About Pakistan Linkedin"><i class="fab fa-linkedin in"></i> </a>
                                <a class="mr-2" href="https://www.instagram.com/aboutpakofficial/" target="_blank" title="Visit About Pakistan Instagram"><i class="fab fa-instagram"></i>
                                </a>
                                <a class="mr-2" href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank" title="Visit About Pakistan Youtube"><i class="fab fa-youtube"></i> </a>
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
                                        <li><a href="{{$footer_property->property_detail_path()}}"
                                               title="{{\Illuminate\Support\Str::limit($footer_property->title, 70, $end='..')}}">
                                               {{\Illuminate\Support\Str::limit($footer_property->city,25, $end='..')}} |   {{\Illuminate\Support\Str::limit($footer_property->location, 25, $end='..')}} |  {{\Illuminate\Support\Str::limit(str_replace($footer_property->city,'',$footer_property->title), 25, $end='..')}} |  PKR {{ Helper::getPriceInWords($footer_property->price)}}

                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div><!--blog-widget-wrap-->
                    </div>

                    <div id="mvp_catlist_widget-9" class="foot-widget left relative mvp_catlist_widget">
                        <h3 class="foot-head">Featured Partners</h3>
                        <div class="blog-widget-wrap left relative">
                            <ul class="blog-widget-list left relative" id="footer-blogs">
                                @foreach($footer_agencies as $key => $agency)
                                    <li><a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}"
                                           title="{{\Illuminate\Support\Str::limit($agency->title, 70, $end='..')}}">
                                           {{\Illuminate\Support\Str::limit($agency->city, 25, $end='..')}}  |  {{\Illuminate\Support\Str::limit($agency->title, 70, $end='..')}}   |
                                        {{$agency->phone}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!--blog-widget-wrap-->

                    </div>
                </div><!--foot-widget-wrap-->
            </div><!--body-main-in-->
        </div><!--body-main-out-->
    </div><!--foot-top-->
    <div id="foot-bot-wrap" class="left relative">
        <div class="body-main-out relative">
            <div class="body-main-in">
                <div id="foot-bot" class="left relative">
                    <div class="foot-menu relative">
                        <div class="menu-main-menu-container">
                            <ul id="menu-main-menu-2" class="menu">
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457 page-font"><a href="https://www.aboutpakistan.com">Home</a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519 page-font">
                                    <a href="https://www.aboutpakistan.com/blog" aria-current="page">Blog</a>
                                </li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10 page-font"><a href="https://www.aboutpakistan.com/news">News</a>
                                </li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2515 page-font"><a href="https://www.aboutpakistan.com/medical">Medical</a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="https://www.aboutpakistan.com/mobile-packages">Mobile Packages</a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="https://www.aboutpakistan.com/about-us.php">About Us</a></li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="https://www.aboutpakistan.com/contact-us.php">Contact Us</a></li>

                            </ul>
                        </div>
                    </div><!--foot-menu-->
                    <div class="foot-copy relative">
                        <p class="page-font">Copyright © 2020. About Pakistan. All rights reserved.</p>
                    </div><!--foot-copy-->
                </div><!--foot-bot-->
            </div><!--body-main-in-->
        </div><!--body-main-out-->
    </div><!--foot-bot-->
</footer>
