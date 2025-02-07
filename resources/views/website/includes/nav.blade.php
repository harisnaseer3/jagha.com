@php use App\Models\Dashboard\City; @endphp
<div id="site" class="left relative">
    <div id="site-wrap" class="left relative">
        <div id="fly-wrap">
            <div class="fly-wrap-out">
                <div class="fly-side-wrap">
                    <ul class="fly-bottom-soc left relative">
                        <li class="fb-soc">
                            <a href="https://www.facebook.com/profile.php?id=61570901009233" target="_blank" title="Visit Jagha Facebook">
                                <i class="fab fa-facebook-square icon-padding"></i>
                            </a>
                        </li>
{{--                        <li class="twit-soc">--}}
{{--                            <a href="https://twitter.com/jaghapk" target="_blank" title="Visit Jagha Twitter">--}}
{{--                                <i class="fab fa-twitter icon-padding"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="link-soc">--}}
{{--                            <a href="https://www.linkedin.com/company/jaghapk" target="_blank" title="Visit Jagha Linkedin">--}}
{{--                                <i class="fab fa-linkedin in icon-padding"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="insta-soc">
                            <a href="https://www.instagram.com/jaghapk/" target="_blank" title="Visit Jagha Instagram">
                                <i class="fab fa-instagram  icon-padding"></i>
                            </a>
                        </li>
{{--                        <li class="youtube-soc">--}}
{{--                            <a href="https://www.youtube.com/channel/jaghapk" target="_blank" title="Visit Jagha Youtube">--}}
{{--                                <i class="fab fa-youtube icon-padding"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </div><!--fly-side-wrap-->
                <div class="fly-wrap-in">
                    <div id="fly-menu-wrap">
                        <nav class="fly-nav-menu left relative" style="height: 90%;">
                            <div class="menu-main-menu-container">
                                <ul id="menu-main-menu" class="menu">
                                    <li id="menu-item-2457"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457">
                                        <a href="https://www.jagha.com">Home</a>
                                    </li>
                                    <li id="menu-item-12"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12 toggled tog-minus">
                                        <a href="/">Property</a>
                                        <ul class="sub-menu" style="display:block;">
                                            <li id="menu-item-2508"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                                <a href="{{route('property.city.count.listing',['type'=>'homes'])}}">Houses</a>
                                            </li>
                                            <li id="menu-item-2469"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">
                                                <a href="{{route('property.city.count.listing', ['type'=>'plots'])}}">Plots</a>
                                            </li>
                                            <li id="menu-item-2509"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">
                                                <a href="{{route('property.city.count.listing',['type'=> 'commercial'])}}">Commercial</a>
                                            </li>
                                            {{-- <li id="menu-item-2510"--}}
                                            {{-- class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">--}}
                                            {{-- <a href="{{route('blogs.index')}}">Blogs</a>--}}
                                            {{-- </li>--}}
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="{{route('agents.listing')}}">Partners</a>
                                            </li>
                                            <li id="menu-item-2512" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2512">
                                                {{ Form::open(['route' => ['property.search.id'], 'method' => 'get', 'role' => 'form','class'=>'px-0 py-2 nav-link color-555', 'style' => 'max-width:300px;' ,'id'=>'search-property-ref-2']) }}
                                                <input class="px-3 property-id text-transform" type="text" placeholder="Property Search" name="term" id="ref-id-2" autocomplete="false"
                                                       value="{{isset($params['search_term']) ? $params['search_term']:'' }}" style="border-radius: 0;border: none;">
                                                <small id="property_id-error-2" class="help-block text-red"></small>
                                                <button class="btn btn-sm btn-reference-style" id="property-reference-2" type="submit">
                                                    <i class="fa fa-search ml-1"></i></button>
                                                {{ Form::close() }}
                                            </li>


                                        </ul>

                                    </li>
                                    <li id="menu-item-10"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10">
                                        <a href="https://www.jagha.com/">News</a>
                                        <ul class="sub-menu">
                                            <li id="menu-item-2508"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                                <a href="https://www.jagha.com/">News-1</a>
                                            </li>
                                            <li id="menu-item-2469"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">
                                                <a href="https://www.jagha.com/">News-2</a>
                                            </li>
                                            <li id="menu-item-2509"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">
                                                <a href="https://www.jagha.com/">News-3</a>
                                            </li>
                                            <li id="menu-item-2510"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">
                                                <a href="https://www.jagha.com/">News-4</a>
                                            </li>
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="https://www.jagha.com/">News-5</a>
                                            </li>
                                            <li id="menu-item-2512"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2512">
                                                <a href="https://www.jagha.com/">News-6</a>
                                            </li>
                                            <li id="menu-item-2513"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2513">
                                                <a href="https://www.jagha.com/">News-7</a>
                                            </li>
                                            <li id="menu-item-2514"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2514">
                                                <a href="https://www.jagha.com/">News-8</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li id="menu-item-2519"
                                        class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519">
                                        <a href="https://www.jagha.com/" aria-current="page">Blog</a>
                                        <ul class="sub-menu">
                                            <li id="menu-item-2518"
                                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2518">
                                                <a href="https://www.jagha.com/">Blog-1</a>
                                            </li>
                                            <li id="menu-item-2517"
                                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2517">
                                                <a href="https://www.jagha.com/">Blog-2</a>
                                            </li>
                                            <li id="menu-item-2516"
                                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2516">
                                                <a href="https://www.jagha.com/">Blog-3</a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li id="menu-item-14"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2517">
                                        <a href="https://www.jagha.com/">About Us</a>
                                    </li>
                                    <li id="menu-item-15"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518">
                                        <a href="https://www.jagha.com/">Contact Us</a>
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
                                <div class="left relative">
                                    <div id="toggle-sidebar" class="fly-but-wrap left relative"> {{-- logo new style --}}
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

{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10">--}}
{{--                                                            <a href="https://www.jagha.com/">News</a>--}}
{{--                                                            <ul class="sub-menu">--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-1</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-2</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-3</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-4</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-5</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2512">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-6</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2513">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-7</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2514">--}}
{{--                                                                    <a href="https://www.jagha.com/">News-8</a>--}}
{{--                                                                </li>--}}
{{--                                                            </ul>--}}
{{--                                                        </li>--}}

{{--                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518">--}}
{{--                                                            <a href="https://www.jagha.com/">Contact Us</a>--}}
{{--                                                        </li>--}}
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
{{--                                                            <ul class="sub-menu">--}}
{{--                                                                <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2518">--}}
{{--                                                                    <a href="https://www.jagha.com/">Blog-1</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2517">--}}
{{--                                                                    <a href="https://www.jagha.com/">Blog-2</a>--}}
{{--                                                                </li>--}}
{{--                                                                <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2516">--}}
{{--                                                                    <a href="https://www.jagha.com/">Blog-3</a>--}}
{{--                                                                </li>--}}
{{--                                                            </ul>--}}
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
{{--                        <li class="nav-item hide-nav navbar-li {{ request()->is('properties/type/homes/*') ? 'active' : '' }}">--}}
{{--                            <a class="nav-link" href="{{route('property.city.count.listing',['type'=>'homes'])}}">--}}
{{--                                Houses--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item hide-nav navbar-li {{ request()->is('properties/type/plots/*') ? 'active' : '' }}">--}}
{{--                            <a class="nav-link" href="{{route('property.city.count.listing', ['type'=>'plots'])}}">--}}
{{--                                Plots--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item hide-nav navbar-li {{ request()->is('properties/type/commercial/*') ? 'active' : '' }}">--}}
{{--                            <a class="nav-link" href="{{route('property.city.count.listing',['type'=> 'commercial'])}}">--}}
{{--                                Commercial</a>--}}
{{--                        </li>--}}
                        {{-- <li class="nav-item hide-nav navbar-li {{ request()->is('blogs') || request()->is('blogs/*') ? 'active' : '' }}">--}}
                        {{-- <a class="nav-link" href="{{route('blogs.index')}}">--}}
                        {{-- Blogs</a>--}}
                        {{-- </li>--}}
{{--                        <li class="nav-item hide-nav navbar-li {{ request()->is('agents') || request()->is('agents/*') ? 'active' : '' }}">--}}
{{--                            <a class="nav-link" href="{{route('agents.listing')}}">--}}
{{--                                Partners</a>--}}
{{--                        </li>--}}

                        <li class="nav-item hide-nav navbar-li nav-profile-link">
                            @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                <a class="nav-link theme-dark-blue" href="{{route('users.edit',\Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier())}}">
                                    My Account Settings
                                </a>
                            @endif
                        </li>

                        <li class="nav-item hide-nav navbar-li nav-property-link">
                            @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                <a class="nav-link theme-dark-blue" href="{{route('properties.listings',
                                           ['status'=>'active','purpose'=>'all','user'=>\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'sort'=>'id','order'=>'desc','page'=>10])}}">
                                    Property Management
                                </a>
                            @endif
                        </li>

                    </ul>
                    <ul class="top-social-media navbar-nav ml-auto">
                        <li class="nav-item">
                            {{ Form::open(['route' => ['property.search.id'], 'method' => 'get', 'role' => 'form','class'=>'px-3 nav-link color-555', 'style' => 'max-width:300px;' ,'id'=>'search-property-ref']) }}
                            <input class="px-3 property-id text-transform" type="text" placeholder="Property Search" name="term" id="ref-id" autocomplete="false"
                                   value="{{isset($params['search_term']) ? $params['search_term']:'' }}">
                            <small id="property_id-error" class="help-block text-red"></small>
                            <button class="btn btn-sm btn-reference-style" id="property-reference" type="submit">
                                <i class="fa fa-search ml-1"></i></button>
                            {{ Form::close() }}
                        </li>
                        <li class="nav-item user-dropdown">
                            @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                <div class="dropdown dropdown-min-width">
                                    <a class="nav-link dropdown-toggle text-center" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fas fa-user mr-2"></i>
                                        @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                            <span
                                                class="mr-1">{{\Illuminate\Support\Facades\Auth::guard('web')->user()->name}} (ID: {{\Illuminate\Support\Facades\Auth::guard('web')->user()->id}})</span>
                                        @endif

                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('users.edit',\Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier())}}"><i
                                                class="far fa-user-cog mr-2"></i>Manage Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="{{route('properties.listings',
                                           ['status'=>'active','purpose'=>'all','user'=>\Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier(),'sort'=>'id','order'=>'desc','page'=>10])}}">
                                            <i class="fa fa-building-o mr-2"></i>Property Management</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="{{route('account.wallet')}}">
                                            <i class="far fa-wallet mr-2"></i>
                                            My Wallet</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('accounts.logout')}}"><i
                                                class="far fa-sign-out mr-2"></i>Logout</a>
                                    </div>
                                </div>
                            @elseif(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                <a class="nav-link" data-toggle="modal" data-target="#adminLogoutModal"
                                   href="javascript:void(0);" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user mr-3"></i>
                                </a>

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
                    {{-- <div class="col-12"><div class="text-right">--}}
                    {{-- {{ Form::open(['route' => ['property.search.id'], 'method' => 'get', 'role' => 'form','class'=>'px-3 nav-link color-555', 'style' => 'max-width:345px;' ,'id'=>'search-property-ref']) }}--}}
                    {{-- <input class="px-3 property-id text-transform" type="text" placeholder="Property Search" name="term" id="ref-id" autocomplete="false"--}}
                    {{-- value="{{isset($params['search_term']) ? $params['search_term']:'' }}">--}}
                    {{-- <small id="property_id-error" class="help-block text-red"></small>--}}
                    {{-- <button class="btn btn-sm btn-reference-style" id="property-reference" type="submit">--}}
                    {{-- <i class="fa fa-search ml-1"></i></button>--}}
                    {{-- {{ Form::close() }}
                </div>--}}
                    {{-- </div>--}}
                    <div class="user-dropdown col-12">
                        @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                            <div class="dropdown dropdown-min-width">
                                <a class="nav-link dropdown-toggle text-right" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="fas fa-user mr-2"></i>
                                    @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                        <span
                                            class="mr-1">{{\Illuminate\Support\Facades\Auth::guard('web')->user()->name}} (ID: {{\Illuminate\Support\Facades\Auth::guard('web')->user()->id}})</span>
                                    @endif

                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('users.edit',\Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier())}}"><i
                                            class="far fa-user-cog mr-2"></i>Manage Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="{{route('properties.listings',
                                           ['status'=>'active','purpose'=>'all','user'=>\Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier(),'sort'=>'id','order'=>'desc','page'=>10])}}">
                                        <i class="fa fa-building-o mr-2"></i>Property Management</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('accounts.logout')}}"><i
                                            class="far fa-sign-out mr-2"></i>Logout</a>
                                </div>
                            </div>
                        @elseif(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                            <a class="nav-link" data-toggle="modal" data-target="#adminLogoutModal"
                               href="javascript:void(0);" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user mr-3"></i>
                            </a>

                        @else
                            <a class="nav-link text-right" data-toggle="modal" data-target="#exampleModalCenter"
                               href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user mr-3"></i>
                            </a>
                        @endif
                    </div>
                </div>

            </nav>

@include('website.layouts.investor-sign-in-modal')
@include('website.layouts.sign-in-modal')
@if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
    @include('website.layouts.admin-logout-modal')
@endif


