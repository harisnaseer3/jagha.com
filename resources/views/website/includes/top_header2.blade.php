<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logos" href="{{route('home')}}">
                <img src="{{ asset('website/img/logos/logo-with-text-309x66.png')}}" alt="logo" class="logo-none-2" style="height: 50px;">
                <img src="{{ asset('website/img/logos/logo-with-text-309x66.png')}}" alt="logo" class="logo-none" style="height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav header-ml">
                    <li class="nav-item hide-nav navbar-li {{ request()->is('properties/type/homes/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('properties.get_listing',['type'=>'homes', 'sort' =>'newest'])}}">
                            Homes
                        </a>
                    </li>
                    <li class="nav-item hide-nav navbar-li {{ request()->is('properties/type/plots/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('properties.get_listing', ['type'=>'plots', 'sort' =>'newest'])}}">
                            Plots
                        </a>
                    </li>
                    <li class="nav-item hide-nav navbar-li {{ request()->is('properties/type/commercial/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('properties.get_listing',['type'=> 'commercial', 'sort' =>'newest'])}}">
                            Commercial</a>
                    </li>
                    <li class="nav-item hide-nav navbar-li {{ request()->is('blogs') || request()->is('blogs/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('blogs.index')}}">
                            Blogs</a>
                    </li>
                </ul>
                <ul class="top-social-media navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter"
                           href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user mt-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{ Form::open(['route' => ['property.search.id'], 'method' => 'post', 'role' => 'form','class'=>'px-3 nav-link color-555', 'style' => 'max-width:300px;' ,'id'=>'search-property-ref']) }}
                        <input class="px-3 property-id text-transform"  type="text" placeholder="Property ID" name="property_id" id="ref-id" autocomplete="false">
                        <small id="property_id-error" class="help-block text-red"></small>
                        <i class="fa fa-search ml-1"></i>
                        {{ Form::close() }}
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<!-- Modal -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
        <div class="modal-content" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">
            <!--Header-->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Log in</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 justify-content-center">
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <p class="my-3 text-center"><strong>{{\Illuminate\Support\Facades\Auth::user()->name}}</strong></p>
                                <a href="{{route('users.edit',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())}}"
                                   class="btn btn-block" style="background: #274abb;color: white">PROFILE</a>
                                <a href="{{route('accounts.logout')}}" class="btn btn-block btn-outline sign-in" style="color: #0b2e13">LOGOUT</a>
                            @else
                                <p class="text-center">Already a member?</p>
                                <a href="{{route('login')}}" class="btn btn-block sign-in login-btn" style="color: #0b2e13; padding: 6px 20px 9px 20px;">Login</a>
                                <p class="text-center">OR</p>
                                <p class="text-center">Become a new member.</p>
                                <a href="{{route('register')}}" class="btn btn-block btn-outline sign-in text-bold"
                                   style="color: #274abb; padding: 6px 20px 9px 20px;">REGISTER</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
