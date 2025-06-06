<div id="site" class="left relative">
    <div id="site-wrap" class="left relative">
        <div id="fly-wrap">
            <div class="fly-wrap-out">
                <div class="fly-side-wrap">
                    <ul class="fly-bottom-soc left relative">
                        <li class="fb-soc">
                            <a href="https://www.facebook.com//people/Jaghacom/61570901009233/" target="_blank" title="Visit About Pakistan Facebook">
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
                        <nav class="fly-nav-menu left relative" style="height: 90%;">
                            <div class="menu-main-menu-container">
                                <ul id="menu-main-menu" class="menu">
                                    <li id="menu-item-2457"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2457">
                                        <a href="https://www.aboutpakistan.com">Home</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10">
                                        <a href="https://www.aboutpakistan.com/quran-audios">Islam</a>
                                        <ul class="sub-menu">
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                                <a href="https://www.aboutpakistan.com/quran-audios">Quran Audios</a>
                                            </li>

                                        </ul>
                                    </li>

                                    <li id="menu-item-12"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12 toggled tog-minus">
                                        <a href="/">Property</a>
                                        <ul class="sub-menu" style="display:block;">
                                            <li id="menu-item-2508"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                                <a href="{{route('user.dashboard')}}">Dashboard</a>
                                            </li>
                                            <li id="menu-item-2469"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">
                                                <a href="{{route('properties.listings',
                                           ['status'=>'active','purpose'=>'all','user'=>\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'sort'=>'id','order'=>'desc','page'=>10])}}">Property Management</a>
                                            </li>
                                            <li id="menu-item-2509"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">
                                                <a href="{{route('message-center.inbox')}}">Message Center</a>
                                            </li>
                                            <li id="menu-item-2510"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">
                                                <a href="{{route('users.edit', ['user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()])}}">My Account Settings</a>
                                            </li>
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="{{route('agents.listing')}}">My Agencies</a>
                                            </li>
                                            @php $agencies = Auth::guard('web')->user()->agencies->where('status','verified') @endphp
                                            @if(count($agencies)> 0)
                                                <li id="menu-item-2511"
                                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                    <a href="{{route('agencies.staff')}}">Agency Staff</a>
                                                </li>
                                            @endif
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="{{route('users.edit', ['user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()])}}">My Account Settings</a>
                                            </li>
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="{{route('message-center.inbox')}}"> Message Center</a>
                                            </li>
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="{{route('aboutpakistan.support')}}">Support</a>
                                            </li>
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="{{route('account.wallet')}}">
                                                    Wallet</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li id="menu-item-10"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-10">
                                        <a href="https://aboutpakistan.com/news">News</a>
                                        <ul class="sub-menu">
                                            <li id="menu-item-2508"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2508">
                                                <a href="https://aboutpakistan.com/news/category/pakistan/">Pakistan</a>
                                            </li>
                                            <li id="menu-item-2469"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2469">
                                                <a href="https://aboutpakistan.com/news/category/sports/">Sports</a>
                                            </li>
                                            <li id="menu-item-2509"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2509">
                                                <a href="https://aboutpakistan.com/news/category/business/">Business</a>
                                            </li>
                                            <li id="menu-item-2510"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2510">
                                                <a href="https://aboutpakistan.com/news/category/entertainment/">Entertainment</a>
                                            </li>
                                            <li id="menu-item-2511"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2511">
                                                <a href="https://aboutpakistan.com/news/category/fashion/">Fashion</a>
                                            </li>
                                            <li id="menu-item-2512"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2512">
                                                <a href="https://aboutpakistan.com/news/category/technology/">Technology</a>
                                            </li>
                                            <li id="menu-item-2513"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2513">
                                                <a href="https://aboutpakistan.com/news/category/education/">Education</a>
                                            </li>
                                            <li id="menu-item-2514"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2514">
                                                <a href="https://aboutpakistan.com/news/category/international/">International</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="menu-item-13"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516">
                                        <a href="https://aboutpakistan.com/mobile-packages">Mobile Packages</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516">
                                        <a href="https://aboutpakistan.com/pakpedia">Pakpedia
                                        </a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2516">
                                        <a href="https://aboutpakistan.com/sports">Sports
                                        </a></li>
                                    <li id="menu-item-2519"
                                        class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-2519">
                                        <a href="https://aboutpakistan.com/blog" aria-current="page">Blog</a>
                                        <ul class="sub-menu">
                                            <li id="menu-item-2518"
                                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2518">
                                                <a href="https://aboutpakistan.com/blog/category/pakistan/">Pakistan</a>
                                            </li>
                                            <li id="menu-item-2517"
                                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2517">
                                                <a href="https://aboutpakistan.com/blog/category/medical/">Medical</a>
                                            </li>
                                            <li id="menu-item-2516"
                                                class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2516">
                                                <a href="https://aboutpakistan.com/blog/category/travel/">Travel</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="menu-item-11"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2515">
                                        <a href="https://aboutpakistan.com/medical">Medical</a></li>


                                    <li id="menu-item-14"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2517">
                                        <a href="https://aboutpakistan.com/about-us.php">About Us</a>
                                    </li>
                                    <li id="menu-item-15"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2518">
                                        <a href="https://aboutpakistan.com/contact-us.php">Contact Us</a>
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
            @include('website.includes.nav')
            <nav class="navbar navbar-expand-lg navbar-light desktop-nav">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav header-ml">
                        <li class="nav-item hide-nav navbar-li">
                            <a class="nav-link" href="{{route('user.dashboard')}}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item hide-nav navbar-li {{ in_array($current_route_name, ['properties.create', 'properties.edit', 'properties.listings']) ? 'active' : '' }}">
                            <a class="nav-link theme-dark-blue" href="{{route('properties.listings',
                                           ['status'=>'active','purpose'=>'all','user'=>\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),'sort'=>'id','order'=>'desc','page'=>10])}}">
                                My Properties
                            </a>
                        </li>
                        <li class="nav-item hide-nav navbar-li">
                            <a class="nav-link" href="{{route('package.create')}}">
                                Packages</a>
                        </li>
                        <li class="nav-item hide-nav navbar-li {{ in_array($current_route_name, ['users.edit', 'agencies.edit','user_roles.edit','settings.edit','password.edit','agencies.create']) ? 'active' : '' }}">
                            <?php $route_params = ['status' => 'verified_agencies', 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'desc', 'page' => 10]; ?>
                            <a class="nav-link {{ in_array($current_route_name, ['agencies.listings']) ? 'active' : '' }}"
                               href="{{route('agencies.listings', array_merge($route_params, ['purpose' => 'all']))}}">
                                My Agencies</a>
                        </li>
                        @php $agencies = Auth::guard('web')->user()->agencies->where('status','verified') @endphp
                        @if(count($agencies)> 0)
                            <li class="nav-item hide-nav navbar-li">
                                <a class="nav-link" href="{{route('agencies.staff')}}">
                                    Agency Staff</a>
                            </li>
                        @endif

                        <li class="nav-item hide-nav navbar-li">
                            <a class="nav-link" href="{{route('message-center.inbox')}}">
                                Message Center</a>
                        </li>
                        <li class="nav-item hide-nav navbar-li {{ in_array($current_route_name, ['users.edit', 'agencies.edit','user_roles.edit','settings.edit','password.edit','agencies.create']) ? 'active' : '' }}">
                            <a class="nav-link theme-dark-blue" href="{{route('users.edit', ['user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()])}}">
                                My Account Settings</a>
                        </li>

                        <li class="nav-item hide-nav navbar-li">
                            <a class="nav-link theme-dark-blue" href="{{route('aboutpakistan.support')}}">
                                Support</a>
                        </li>
                        <li class="nav-item hide-nav navbar-li">
                            <a class="nav-link" style="color: orangered !important;" href="{{route('account.wallet')}}">
                                Wallet</a>
                        </li>
                    </ul>
                    <ul class="top-social-media navbar-nav ml-auto">
                        <li class="nav-item user-dropdown">

                            @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                <div class="dropdown dropdown-min-width">
                                    <a class="nav-link dropdown-toggle text-center" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fas fa-user mr-2"></i>
                                        @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                            <span class="mr-1">{{\Illuminate\Support\Facades\Auth::guard('web')->user()->name}} (ID: {{\Illuminate\Support\Facades\Auth::guard('web')->user()->id}})</span>
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

                        @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                            <div class="dropdown dropdown-min-width">
                                <a class="nav-link dropdown-toggle text-right" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="fas fa-user mr-2"></i>
                                    @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                                        <span class="mr-1">{{\Illuminate\Support\Facades\Auth::guard('web')->user()->name}} (ID: {{\Illuminate\Support\Facades\Auth::guard('web')->user()->id}})</span>
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
                        @else
                            <a class="nav-link text-right" data-toggle="modal" data-target="#exampleModalCenter"
                               href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user mr-3"></i>
                            </a>
                        @endif
                    </div>

                </div>
            </nav>
@include('website.layouts.sign-in-modal')
