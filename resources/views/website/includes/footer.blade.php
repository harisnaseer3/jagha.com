{{--@php--}}
{{--    $route_name= Route::currentRouteName();--}}
{{--@endphp--}}
{{--<footer id="foot-wrap" class="left relative">--}}
{{--    <div id="foot-top-wrap" class="left relative">--}}
{{--        <div class="body-main-out relative">--}}
{{--            <div class="body-main-in">--}}
{{--                <div id="foot-widget-wrap" class="left relative">--}}
{{--                    <div class="foot-widget left relative">--}}
{{--                        <div class="foot-logo left relative">--}}
{{--                            <a href="https://www.jagha.com">--}}
{{--                                <img src="{{asset('img/logo/new-white-logo.png')}}" alt="Jagha" data-rjs="2" style="max-width: 40%" />--}}
{{--                            </a>--}}
{{--                        </div><!--foot-logo-->--}}
{{--                        <div class="foot-info-text left relative">--}}
{{--                            <p>Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.</p>--}}
{{--                        </div>--}}
{{--                        <!--footer-info-text-->--}}


{{--                        <div class="foot-soc left relative">--}}
{{--                            <p class="mb-2 pr-15"><i class="fa fa-phone mr-2"></i>+92 51 4862317</p>--}}
{{--                            <p class="mb-2 pr-15"><i class="fa fa-mobile mr-2 fa-2x"></i>+92 315 5141959</p>--}}
{{--                            <p class="mb-2 pr-15"><i class="fa fa-envelope mr-2"></i>info@jagha.com</p>--}}
{{--                            <div class="footer-divider"></div>--}}
{{--                            <div class="text-white mt-2"> Join us on Social</div>--}}
{{--                            <div class="color-white mt-2">--}}
{{--                                <a class="mr-2" href="https://www.facebook.com/profile.php?id=61570901009233" target="_blank" title="Visit Jagha Facebook"><i class="fab fa-facebook-f"></i></a>--}}
{{--                                <a class="mr-2" href="https://twitter.com/jaghapk" target="_blank" title="Visit Jagha Twitter"><i class="fab fa-twitter"></i> </a>--}}
{{--                                <a class="mr-2" href="https://www.linkedin.com/company/jaghapk" target="_blank" title="Visit Jagha Linkedin"><i class="fab fa-linkedin in"></i> </a>--}}
{{--                                <a class="mr-2" href="https://www.instagram.com/jaghapk/" target="_blank" title="Visit Jagha Instagram"><i class="fab fa-instagram"></i>--}}
{{--                                </a>--}}
{{--                                <a class="mr-2" href="https://www.youtube.com/channel/jaghapk" target="_blank" title="Visit Jagha Youtube"><i class="fab fa-youtube"></i> </a>--}}
{{--                            </div><!--foot-soc-->--}}
{{--                        </div><!--foot-widget-->--}}
{{--                    </div>--}}
{{--                    <div id="mvp_catlist_widget-8" class="foot-widget left relative mvp_catlist_widget">--}}
{{--                        <h3 class="foot-head">Recent Properties</h3>--}}
{{--                        <div class="blog-widget-wrap left relative">--}}
{{--                            <ul class="blog-widget-list left relative">--}}
{{--                                @foreach($recent_properties as $key => $footer_property)--}}
{{--                                    @if($route_name === 'properties.show' && $footer_property->id === $property->id)--}}
{{--                                        @continue--}}
{{--                                    @else--}}
{{--                                        <li>--}}
{{--                                            @if($footer_property->id < 104280)--}}
{{--                                                <a href="{{route('properties.show',[--}}
{{--                                                'slug'=>Str::slug($footer_property->location) . '-' . Str::slug($footer_property->title) . '-' . $footer_property->reference,--}}
{{--                                                'property'=>$footer_property->id])}}"--}}
{{--                                            @else--}}
{{--                                                <a href="{{route('properties.show',[--}}
{{--                                                    'slug'=>Str::slug($footer_property->city) . '-' .Str::slug($footer_property->location) . '-' . Str::slug($footer_property->title) . '-' . $footer_property->reference,--}}
{{--                                                    'property'=>$footer_property->id])}}" @endif--}}


{{--                                                title="{{\Illuminate\Support\Str::limit($footer_property->title, 70, $end='..')}}">--}}
{{--                                                    {{\Illuminate\Support\Str::limit($footer_property->city,25, $end='..')}} | {{\Illuminate\Support\Str::limit($footer_property->location, 25, $end='..')}} | {{\Illuminate\Support\Str::limit(str_replace($footer_property->city,'',$footer_property->title), 25, $end='..')}} | PKR {{ Helper::getPriceInWords($footer_property->price)}}--}}

{{--                                                </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div><!--blog-widget-wrap-->--}}
{{--                    </div>--}}

{{--                    <div id="mvp_catlist_widget-9" class="foot-widget left relative mvp_catlist_widget">--}}
{{--                        <h3 class="foot-head">Featured Partners</h3>--}}
{{--                        <div class="blog-widget-wrap left relative">--}}
{{--                            <ul class="blog-widget-list left relative" id="footer-blogs">--}}
{{--                                @foreach($footer_agencies as $key => $agency)--}}
{{--                                    <li><a href="{{route('agents.ads.listing',--}}
{{--                                            [ 'city'=>strtolower(Str::slug($agency->city)),--}}
{{--                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),--}}
{{--                                               'agency'=> $agency->id ,--}}
{{--                                               ])}}"--}}
{{--                                           title="{{\Illuminate\Support\Str::limit($agency->title, 70, $end='..')}}">--}}
{{--                                            {{\Illuminate\Support\Str::limit($agency->city, 25, $end='..')}} | {{\Illuminate\Support\Str::limit($agency->title, 70, $end='..')}} |--}}
{{--                                            {{$agency->phone}}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div><!--blog-widget-wrap-->--}}

{{--                    </div>--}}
{{--                </div><!--foot-widget-wrap-->--}}
{{--            </div><!--body-main-in-->--}}
{{--        </div><!--body-main-out-->--}}
{{--    </div><!--foot-top-->--}}
{{--    <div id="foot-bot-wrap" class="left relative">--}}
{{--        <div class="body-main-out relative">--}}
{{--            <div class="body-main-in">--}}
{{--                <div id="foot-bot" class="left relative">--}}
{{--                    <div class="foot-menu relative">--}}
{{--                        <div class="menu-main-menu-container">--}}
{{--                            <ul id="menu-main-menu-2" class="menu">--}}
{{--                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457 page-font"><a href="https://www.jagha.com">Home</a></li>--}}
{{--                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519 page-font">--}}
{{--                                    <a href="https://www.jagha.com/" aria-current="page">Blog</a>--}}
{{--                                </li>--}}
{{--                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10 page-font"><a href="https://www.jagha.com/">News</a>--}}
{{--                                </li>--}}
{{--                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="https://www.aboutpakistan.com/about-us.php">About Us</a></li>--}}
{{--                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516 page-font"><a href="https://www.aboutpakistan.com/contact-us.php">Contact Us</a></li>--}}

{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div><!--foot-menu-->--}}
{{--                    <div class="foot-copy relative">--}}
{{--                        <p class="page-font">Copyright © <span id="current-year"></span>.Jagha. All rights reserved.</p>--}}

{{--                        <script>--}}
{{--                            document.getElementById("current-year").textContent = new Date().getFullYear();--}}
{{--                        </script>--}}
{{--                    </div><!--foot-copy-->--}}
{{--                </div><!--foot-bot-->--}}
{{--            </div><!--body-main-in-->--}}
{{--        </div><!--body-main-out-->--}}
{{--    </div><!--foot-bot-->--}}
{{--</footer>--}}

<footer id="foot-wrap-investor" class="left relative">
    <div id="foot-top-wrap" class="left relative">
        <div class="body-main-out relative">
            <div class="body-main-in">
                <div id="foot-widget-wrap" class="left relative" style="display: flex; justify-content: space-between;">
                    <!-- Column 1: Logo and Info -->
                    <div class="foot-widget left relative">
                        <div class="foot-logo left relative">
                            <a href="https://www.jagha.com">
                                <img src="{{asset('img/logo/new-white-logo.png')}}" alt="Jagha" data-rjs="2" />
                            </a>
                        </div>
                        <div class="investor-foot-info-text left relative text-white">
                            <p class="text-white">Pakistan history, culture, civilization, architecture, politics,
                                constitution, election, music, drama, film, theatre, food, natural resources and more.</p>
                        </div>
                        <div>
                            <button class="btn btn-search footer-btn transition-background green-color">Learn More <span>&rarr;</span></button>
                        </div>
                    </div>

                    <!-- Column 2: Recent Properties -->
                    <div class="foot-widget left relative">
                        <h3 class="foot-head">Recent Properties</h3>
                        <ul class="blog-widget-list left relative text-white">
                            <li>About Us</li>
                            <li style="border: none">Contact Us</li>
                            <li style="border: none">Jobs</li>
                            <li style="border: none">Blogs</li>
                            <li style="border: none">Updates</li>
                            <li style="border: none">Privacy Policy</li>
                        </ul>
                    </div>

                    <!-- Column 3: Features -->
                    <div class="foot-widget left relative">
                        <h3 class="foot-head">Features</h3>
                        <ul class="blog-widget-list left relative text-white">
                            <li style="border: none">Why Choose Us</li>
                            <li style="border: none">Vision</li>
                            <li style="border: none">Mission</li>
                            <li style="border: none">Our Partners</li>
                            <li style="border: none">Investors</li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact Us -->
                    <div class="foot-widget left relative">
                        <h3 class="foot-head">Contact Us</h3>
                        <ul class="blog-widget-list left relative text-white">
                            <p><i class="fa fa-phone"></i> +92 51 4862317</p>
                            <p><i class="fa fa-mobile"></i> +92 315 5141959</p>
                            <p><i class="fa fa-envelope"></i> info@jagha.com</p>
                            <h3 class="foot-head mt-20 mb-2">Join us on Social</h3>
                            <div style="color: white">
                                <a href="https://www.facebook.com/profile.php?id=61570901009233" target="_blank"><i class="fab fa-facebook-f investor-foot-icons"></i></a>
{{--                                <a href="https://twitter.com/jaghapk" target="_blank"><i class="fab fa-twitter investor-foot-icons"></i></a>--}}
{{--                                <a href="https://www.linkedin.com/company/jaghapk" target="_blank"><i class="fab fa-linkedin investor-foot-icons"></i></a>--}}
{{--                                <a href="https://www.instagram.com/jaghapk/" target="_blank"><i class="fab fa-instagram investor-foot-icons"></i></a>--}}
                                <a href="https://www.youtube.com/channel/jaghapk" target="_blank"><i class="fab fa-youtube investor-foot-icons"></i></a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="foot-bot-wrap" class="left relative">
        <div class="body-main-out relative">
            <div class="body-main-in">
                <div id="foot-bot" class="left relative">
                    <div class="foot-copy relative">
                        <p>Copyright © <span id="current-year"></span>. Jagha. All rights reserved.</p>
                        <script>
                            document.getElementById("current-year").textContent = new Date().getFullYear();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<style>
    #foot-widget-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .foot-widget {
        flex: 1; /* All columns take equal space */
        max-width: 22%; /* Adjust column width */
    }

    .foot-widget h3 {
        margin-bottom: 40px;
        font-size: 24px;
        color: white;
    }

    .foot-widget ul {
        list-style: none;
        padding: 0;
    }

    .foot-widget ul li, .foot-widget ul p {
        font-size: 14px;
        color: white;
        margin-bottom: 10px;
    }

    .foot-logo img {
        width: 100%;
        max-width: 150px;
    }

    @media screen and (max-width: 768px) {
        #foot-widget-wrap {
            flex-direction: column;
            align-items: center;
        }

        .foot-widget {
            max-width: 100%; /* Make columns full width on small screens */
        }
    }

</style>
