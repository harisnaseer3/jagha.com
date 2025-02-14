@php use App\Models\Dashboard\City; @endphp
<div id="fly-wrap">
    <div class="fly-wrap-out">
        <div class="fly-side-wrap">
            <ul class="fly-bottom-soc left relative">
                <li class="fb-soc">
                    <a href="https://www.facebook.com/aboutpkofficial" target="_blank" title="Visit About Pakistan Facebook">
                        <i class="fab fa-facebook-square icon-padding"></i>
                    </a>
                </li>
                <li class="twit-soc">
                    <a href="https://twitter.com/aboutpkofficial" target="_blank" title="Visit About Pakistan Twitter">
                        <i class="fab fa-twitter icon-padding"></i>
                    </a>
                </li>
                <li class="link-soc">
                    <a href="https://www.linkedin.com/company/aboutpkofficial" target="_blank" title="Visit About Pakistan Linkedin">
                        <i class="fab fa-linkedin in icon-padding"></i>
                    </a>
                </li>
                <li class="insta-soc">
                    <a href="https://www.instagram.com/aboutpakofficial/" target="_blank" title="Visit About Pakistan Instagram">
                        <i class="fab fa-instagram  icon-padding"></i>
                    </a>
                </li>
                <li class="youtube-soc">
                    <a href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank" title="Visit About Pakistan Youtube">
                        <i class="fab fa-youtube icon-padding"></i>
                    </a>
                </li>
            </ul>
        </div><!--fly-side-wrap-->
        <div class="fly-wrap-in">
            <div id="fly-menu-wrap">
                <nav class="fly-nav-menu left relative">
                    <div class="menu-main-menu-container">
                        <ul id="menu-main-menu" class="menu">
                            <li id="menu-item-2457"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457">
                                <a href="https://www.aboutpakistan.com">Home</a></li>
                            <li id="menu-item-2519"
                                class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519">
                                <a href="https://www.aboutpakistan.com/blog" aria-current="page">Blog</a>
                                <ul class="sub-menu">
                                    <li id="menu-item-2518"
                                        class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2518">
                                        <a href="https://www.aboutpakistan.com/blog/category/pakistan/">Pakistan</a>
                                    </li>
                                    <li id="menu-item-2517"
                                        class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2517">
                                        <a href="https://www.aboutpakistan.com/blog/category/medical/">Medical</a>
                                    </li>
                                    <li id="menu-item-2516"
                                        class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2516">
                                        <a href="https://www.aboutpakistan.com/blog/category/travel/">Travel</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="menu-item-10"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10">
                                <a href="https://www.aboutpakistan.com/news">News</a>
                                <ul class="sub-menu">
                                    <li id="menu-item-2508"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                        <a href="https://www.aboutpakistan.com/news/category/pakistan/">Pakistan</a>
                                    </li>
                                    <li id="menu-item-2469"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">
                                        <a href="https://www.aboutpakistan.com/news/category/sports/">Sports</a>
                                    </li>
                                    <li id="menu-item-2509"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">
                                        <a href="https://www.aboutpakistan.com/news/category/business/">Business</a>
                                    </li>
                                    <li id="menu-item-2510"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">
                                        <a href="https://www.aboutpakistan.com/news/category/entertainment/">Entertainment</a>
                                    </li>
                                    <li id="menu-item-2511"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                        <a href="https://www.aboutpakistan.com/news/category/fashion/">Fashion</a>
                                    </li>
                                    <li id="menu-item-2512"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2512">
                                        <a href="https://www.aboutpakistan.com/news/category/technology/">Technology</a>
                                    </li>
                                    <li id="menu-item-2513"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2513">
                                        <a href="https://www.aboutpakistan.com/news/category/education/">Education</a>
                                    </li>
                                    <li id="menu-item-2514"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2514">
                                        <a href="https://www.aboutpakistan.com/news/category/international/">International</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="menu-item-11"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2515">
                                <a href="https://www.aboutpakistan.com/medical">Medical</a></li>
                            <li id="menu-item-12"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12 toggled tog-minus">
                                <a href="/">Property</a>
                                <ul class="sub-menu" style="display:block;">
                                    @can('Manage Dashboard')
                                        <li id="menu-item-2508"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                            <a href="{{route('admin.dashboard')}}">Dashboard</a>
                                        </li>
                                    @endcan
                                    @can('Manage Admins')
                                        <li id="menu-item-2469"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">
                                            <a href="{{route('admin.manage-admins')}}">Admin Management</a>
                                        </li>
                                    @endcan
                                    @can('Manage Roles and Permissions')
                                        <li id="menu-item-2509"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">
                                            <a href="{{route('admin.manage-roles-permissions')}}">Roles & Permissions</a>
                                        </li>
                                    @endcan
                                    @can('Manage Users')
                                        <li id="menu-item-2510"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">
                                            <a href="{{route('admin.manage-users')}}">User Management</a>
                                        </li>
                                    @endcan
                                    @can('Manage Property')
                                        <li id="menu-item-2511"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                            <?php $route_params = ['status' => 'active', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 200]; ?>
                                            <a href="{{route('admin.properties.listings', array_merge($route_params, ['purpose' => 'sale']))}}">Property Management</a>
                                        </li>
                                    @endcan
                                    @can('Manage Agency')
                                        <li id="menu-item-2511"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                            <?php $route_params = ['status' => 'verified_agencies', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 200]; ?>
                                            <a href="{{route('admin.agencies.listings', array_merge($route_params, ['purpose' => 'all']))}}">Agency Management</a>
                                        </li>
                                    @endcan

                                    @can('Manage Packages')
                                        <li id="menu-item-2511"
                                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                            <a href="#">Packages Management</a>
                                        </li>
                                    @endcan
                                    <li id="menu-item-2511"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                        <a href="{{route('admin.facebook.create')}}"> Facebook Post</a>
                                    </li>
                                    <li id="menu-item-2511"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                        <a href="{{route('admin.statistic.index')}}">
                                            Statistics
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li id="menu-item-13"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516">
                                <a href="https://www.aboutpakistan.com/mobile-packages">Mobile Packages</a>
                            </li>
                            <li id="menu-item-14"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2517">
                                <a href="https://www.aboutpakistan.com/about-us.php">About Us</a>
                            </li>
                            <li id="menu-item-15"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518">
                                <a href="https://www.aboutpakistan.com/contact-us.php">Contact Us</a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div><!--fly-menu-wrap-->
        </div><!--fly-wrap-in-->
    </div><!--fly-wrap-out-->
</div><!--fly-wrap-->
<div id="head-main-wrap" class="left relative">
    <div id="head-main-top" class="left relative">
    </div><!--head-main-top-->
    <div id="main-nav-wrap">
        <div class="nav-out">
            <div class="nav-in">
                <div id="main-nav-cont" class="left" itemscope itemtype="http://schema.org/Organization">
                    <div class="nav-logo-out">
                        <div class="nav-left-wrap left relative">
                            <div id="toggle-sidebar" class="fly-but-wrap left relative">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div><!--fly-but-wrap-->
                            <div class="left">
                                <a itemprop="url" href="https://www.jagha.com">
                                    <div style="display: inline-block; padding: 5px; width: 79px; margin-left: 10px;">
                                        <img itemprop="logo" src="{{asset('img/logo/jagha-black-logo.png')}}" alt="Jagha" data-rjs="2"/>
                                        {{--                                                <img itemprop="logo" src="{{asset('img/logo/jagha-cot-transparent-logo.png')}}" alt="Jagha" data-rjs="2"/>--}}
                                    </div>
                                </a>
                            </div>

                        </div><!--nav-left-wrap-->
{{--                        <div class="nav-logo-in">--}}
{{--                            <div class="nav-menu-out">--}}
{{--                                <div class="nav-menu-in">--}}
{{--                                    <nav class="main-menu-wrap left">--}}
{{--                                        <div class="menu-main-menu-container">--}}
{{--                                            <ul id="menu-main-menu-1" class="menu">--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457">--}}
{{--                                                    <a href="https://www.aboutpakistan.com">Home</a></li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519">--}}
{{--                                                    <a href="https://www.aboutpakistan.com/blog"--}}
{{--                                                       aria-current="page">Blog</a>--}}
{{--                                                    <ul class="sub-menu">--}}
{{--                                                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2518">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/blog/category/pakistan/">Pakistan</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2517">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/blog/category/medical/">Medical</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2516">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/blog/category/travel/">Travel</a>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                </li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10">--}}
{{--                                                    <a href="https://www.aboutpakistan.com/news">News</a>--}}
{{--                                                    <ul class="sub-menu">--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/pakistan/">Pakistan</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/sports/">Sports</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/business/">Business</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/entertainment/">Entertainment</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/fashion/">Fashion</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2512">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/technology/">Technology</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2513">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/education/">Education</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2514">--}}
{{--                                                            <a href="https://www.aboutpakistan.com/news/category/international/">International</a>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                </li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2515">--}}
{{--                                                    <a href="https://www.aboutpakistan.com/medical">Medical</a>--}}
{{--                                                </li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2519">--}}
{{--                                                    <a href="/">Property</a></li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516">--}}
{{--                                                    <a href="https://www.aboutpakistan.com/mobile-packages">Mobile--}}
{{--                                                        Packages</a></li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2517">--}}
{{--                                                    <a href="https://www.aboutpakistan.com/about-us.php">About Us</a></li>--}}
{{--                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518">--}}
{{--                                                    <a href="https://www.aboutpakistan.com/contact-us.php">Contact Us</a></li>--}}

{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </nav>--}}
{{--                                </div><!--nav-menu-in-->--}}

{{--                                <div class="nav-right-wrap relative">--}}
{{--                                    --}}{{--                                            <a class="ml-auto" href="{{route('accounts.admin-logout')}}"><span class="nav-soc-but color-white"> <i class="far fa-2x fa-sign-out mr-2 "></i><strong class="color-white">Logout</strong></span></a>--}}

{{--                                    <a href="mailto:info@aboutpakistan.com" target="_blank" rel="noopener noreferrer" title="Email us at info@aboutpakistan.com">--}}
{{--                                        <span class="nav-soc-but"><i class="fa fa-envelope"></i></span>--}}
{{--                                    </a>--}}
{{--                                    <a href="https://www.facebook.com/aboutpkofficial" target="_blank" title="Visit About Pakistan Facebook">--}}
{{--                                        <span class="nav-soc-but"><i class="fab fa-facebook-f"></i></span>--}}
{{--                                    </a>--}}
{{--                                    <a href="https://twitter.com/aboutpkofficial" target="_blank" title="Visit About Pakistan Twitter">--}}
{{--                                        <span class="nav-soc-but"><i class="fab fa-twitter"></i></span>--}}
{{--                                    </a>--}}
{{--                                    <a href="https://www.linkedin.com/company/aboutpkofficial" target="_blank" title="Visit About Pakistan Linkedin">--}}
{{--                                        <span class="nav-soc-but"><i class="fab fa-linkedin in"></i></span>--}}
{{--                                    </a>--}}
{{--                                    <a href="https://www.instagram.com/aboutpakofficial/" target="_blank" title="Visit About Pakistan Instagram">--}}
{{--                                        <span class="nav-soc-but"><i class="fab fa-instagram"></i></span>--}}
{{--                                    </a>--}}
{{--                                    <a href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank" title="Visit About Pakistan Youtube">--}}
{{--                                        <span class="nav-soc-but"><i class="fab fa-youtube"></i></span>--}}
{{--                                    </a>--}}

{{--                                </div><!--nav-right-wrap-->--}}
{{--                            </div><!--nav-menu-out-->--}}
{{--                        </div><!--nav-logo-in-->--}}



{{--                        updated nav--}}
                        <div class="nav-logo-in">
                            <div class="nav-menu-out">
                                <div class="nav-menu-in" style="margin-left: -128px;">
                                    <nav class="main-menu-wrap left">
                                        <div class="menu-main-menu-container">
                                            <ul id="menu-main-menu-1" class="menu transition-background">
                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457">
                                                    {{--                                                            <a href="https://www.jagha.com/">Home</a>--}}
                                                    <a href="{{ route('home') }}">Home</a>
                                                </li>

                                                @php
                                                    $cities = City::all();
                                                @endphp

                                                @include('website.layouts.investor-sign-in-modal', ['cities' => $cities])
                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2458">
                                                    @auth('web') <!-- Check if the user is logged in -->
                                                    @if (auth()->user()->hasRole('Investor')) <!-- Check if the logged-in user has the "Investor" role -->
                                                    <a href="{{ route('investor') }}" style="display: inline-block; position: relative;">
                                                        Investor
                                                        <img src="/img/logo/newanimation.gif"
                                                             style="width: 45px; height: 35px; position: absolute; top: -8px; right: -11px; z-index: 999999; transform: rotate(15deg);" />
                                                    </a>
                                                    @else <!-- User is logged in but doesn't have the Investor role -->
                                                    <a href="#" data-toggle="modal" data-target="#investorModalCenter">
                                                        Investor
                                                        <img src="/img/logo/newanimation.gif"
                                                             style="width: 45px; height: 35px; position: absolute; top: -8px; right: -11px; z-index: 999999; transform: rotate(15deg);" />
                                                    </a>
                                                    @endif
                                                    @else <!-- If the user is not logged in -->
                                                    <a href="#" data-toggle="modal" data-target="#investorModalCenter">
                                                        Investor
                                                        <img src="/img/logo/newanimation.gif"
                                                             style="width: 45px; height: 35px; position: absolute; top: -8px; right: -11px; z-index: 999999; transform: rotate(15deg);" />
                                                    </a>
                                                    @endauth
                                                </li>

                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518 {{ request()->is('properties/type/homes/*') ? 'active' : '' }}">
                                                    <a href="{{route('property.city.count.listing',['type'=>'homes'])}}">
                                                        Houses
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518 {{ request()->is('properties/type/plots/*') ? 'active' : '' }}">
                                                    <a href="{{route('property.city.count.listing', ['type'=>'plots'])}}">
                                                        Plots
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518 {{ request()->is('properties/type/commercial/*') ? 'active' : '' }}">
                                                    <a href="{{route('property.city.count.listing',['type'=> 'commercial'])}}">
                                                        Commercial</a>
                                                </li>
                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518 {{ request()->is('agents') || request()->is('agents/*') ? 'active' : '' }}">
                                                    <a href="{{route('agents.listing')}}">
                                                        Partners</a>
                                                </li>

                                                <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2519">
                                                    <a href="https://www.aboutpakistan.com/blog/"
                                                       aria-current="page">Blog</a>
                                                    </li>

                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2517">
                                                    <a href="https://www.jagha.com/">About Us</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div><!--nav-menu-in-->

                                <div class="nav-right-wrap relative" style="background: none; right: -125px;">
                                    {{--                                            <a href="mailto:info@jagha.com" target="_blank" rel="noopener noreferrer" title="Email us at info@jagha.com">--}}
                                    {{--                                                <span class="nav-soc-but"><i class="fa fa-envelope"></i></span>--}}
                                    {{--                                            </a>--}}
                                    <a href="https://www.facebook.com/profile.php?id=61570901009233" target="_blank" title="Visit Jagha Facebook">
                                        <span class="nav-soc-but"><i class="fab fa-facebook-f"></i></span>
                                    </a>
                                    {{--                                            <a href="https://twitter.com/jaghapk" target="_blank" title="Visit Jagha Twitter">--}}
                                    {{--                                                <span class="nav-soc-but"><i class="fab fa-twitter"></i></span>--}}
                                    {{--                                            </a>--}}
                                    <a href="https://www.linkedin.com/company/jaghapk" target="_blank" title="Visit Jagha Linkedin">
                                        <span class="nav-soc-but"><i class="fab fa-linkedin in"></i></span>
                                    </a>
                                    <a href="https://www.instagram.com/jaghapk/" target="_blank" title="Visit Jagha Instagram">
                                        <span class="nav-soc-but"><i class="fab fa-instagram"></i></span>
                                    </a>
                                    {{--                                            <a href="https://www.youtube.com/channel/jaghapk" target="_blank" title="Visit Jagha Youtube">--}}
                                    {{--                                                <span class="nav-soc-but"><i class="fab fa-youtube"></i></span>--}}
                                    {{--                                            </a>--}}

                                </div><!--nav-right-wrap-->
                            </div><!--nav-menu-out-->
                        </div><!--nav-logo-in-->
                        <div>

                        <div>

                        </div><!--nav-logo-out-->
                    </div><!--main-nav-cont-->
                </div><!--nav-in-->
            </div><!--nav-out-->
        </div><!--main-nav-wrap-->
    </div><!--head-main-wrap-->
    <nav class="navbar navbar-expand-lg navbar-light desktop-nav">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav header-ml">
                @can('Manage Dashboard')

                    <li class="nav-item hide-nav navbar-li">
                        <a class="nav-link" href="{{route('admin.dashboard')}}">
                            Dashboard
                        </a>
                    </li>
                @endcan
                @can('Manage Admins')
                    <li class="nav-item hide-nav navbar-li">
                        <a class="nav-link" href="{{route('admin.manage-admins')}}">
                            Admin Management
                        </a>
                    </li>
                @endcan
                @can('Manage Roles and Permissions')
                    <li class="nav-item hide-nav navbar-li">
                        <a class="nav-link" href="{{route('admin.manage-roles-permissions')}}">
                            Roles & Permissions</a>
                    </li>
                @endcan
                @can('Manage Users')
                    <li class="nav-item hide-nav navbar-li">
                        <a class="nav-link" href="{{route('admin.manage-users')}}">
                            User Management
                        </a>
                    </li>
                @endcan
                @can('Manage Property')
                    <li class="nav-item hide-nav navbar-li">
                        <?php $route_params = ['status' => 'active', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 200]; ?>

                        <a class="nav-link" href="{{route('admin.properties.listings', array_merge($route_params, ['purpose' => 'sale']))}}">
                            Property Management</a>
                    </li>
                @endcan
                @can('Manage Agency')
                    <li class="nav-item hide-nav navbar-li">
                        <?php $route_params = ['status' => 'verified_agencies', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 200]; ?>
                        <a class="nav-link"
                           href="{{route('admin.agencies.listings', array_merge($route_params, ['purpose' => 'all']))}}">
                            Agency Management</a>
                    </li>
                @endcan
                @can('Manage Packages')
                    <li class="nav-item hide-nav navbar-li">
                        <a class="nav-link" href="{{route('admin.package.index')}}">
                            Packages Management
                        </a>
                    </li>
                @endcan
                <li class="nav-item hide-nav navbar-li">
                    <a class="nav-link" href="{{route('admin.facebook.create')}}">
                        Facebook Post
                    </a>
                </li>
                <li class="nav-item hide-nav navbar-li">
                    <a class="nav-link" href="{{route('admin.statistic.index')}}">
                        Statistics
                    </a>
                </li>
            </ul>
            <ul class="top-social-media navbar-nav ml-auto">
                <li class="nav-item user-dropdown">
                    @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                        <div class="dropdown dropdown-min-width">
                            <a class="nav-link dropdown-toggle text-center" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fas fa-user mr-2"></i>
                                @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                    <span class="mr-1">{{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}} (ID: {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->id}})
                                            </span>
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('accounts.admin-logout')}}"><i
                                        class="far fa-sign-out mr-2"></i>Logout</a>
                            </div>
                        </div>
                    @else
                        <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter"
                           href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user mr-3"></i>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light mobile-nav">
        <div class="row">
            <div class="col-12 user-dropdown">
                @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                    <div class="dropdown dropdown-min-width">
                        <a class="nav-link dropdown-toggle text-right" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"
                           aria-expanded="false">
                            <i class="fas fa-user mr-2"></i>
                            @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                <span class="mr-1">{{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}} (ID: {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->id}})
                                            </span>
                            @endif
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('accounts.admin-logout')}}"><i
                                    class="far fa-sign-out mr-2"></i>Logout</a>
                        </div>
                    </div>
                @else
                    <a class="nav-link text-right" data-toggle="modal" data-target="#exampleModalCenter"
                       href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user mr-3"></i>
                    </a>
                @endif
            </div>

        </div>
    </nav>
</div>


