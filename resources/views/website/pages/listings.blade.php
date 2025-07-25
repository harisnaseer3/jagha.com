@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
@endsection

@section('content')
    @include('website.includes.dashboard-nav')
    <!-- Top header start -->
    <div class="sub-banner">
        <div class="container">
            <div class="page-name">
                <h1>Property Management</h1>
            </div>
        </div>
    </div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="ListingsTabContent">
                        @foreach(\Illuminate\Support\Facades\Auth::user()->agencies()->where('status','verified') as $agency)
                            @foreach($agenct->agencyUsers() as $agency_user)
                                <div>{{$agency_user->id}}</div>
                            @endforeach
                        @endforeach
                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.includes.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.layouts.flash-message')
                                    <div id="limit-message"></div>
                                    <div class="row m-0">
                                        <div class="col-12 my-2">
                                            <span class="pull-right"><a class="btn btn-sm transition-background color-green ml-2" href="/"><i
                                                        class="fa fa-globe mr-1"></i>Go to jagha.com</a></span>
                                            <span class="pull-right"><a class="btn btn-sm transition-background color-green" href="{{route('properties.create')}}">Post Advertisement</a></span>
                                        </div>
                                    </div>

                                    <span class="tab-content" id="listings-tabContent">
                                        @foreach(['all', 'sale', 'rent','wanted'] as $option)
                                            <div class="tab-pane fade show {{\Illuminate\Support\Facades\Request::segments()[5] === $option? 'active' : '' }}" id="{{"listings-".$option}}"
                                                 role="tabpanel"
                                                 aria-labelledby="{{"listings-".$option."-tab"}}">
                                                <h6 class="pull-left">{{ucwords($option)}} Listings</h6>

                                                <span class="pull-right mx-1 my-2">
                                                    {{ Form::open(['route' => ['property.user.search.id'], 'method' => 'post', 'role' => 'form','class'=>' color-555', 'style' => 'max-width:300px;']) }}
                                                     <div class="input-group input-group-sm mb-3">
                                                    <input class="form-control form-control-sm text-transform" type="number" placeholder="Property ID" name="property_id"
                                                           autocomplete="false" required>
                                                         <div class="col-2 px-0 mx-0">
                                                                <button class="btn color-green transition-background search-submit-btn btn-sm" type="Submit"><i class="fa fa-search ml-1"></i></button>
                                                         </div>
                                                     </div>
                                                    {{ Form::close() }}
                                                </span>
                                                <span class="pull-right mx-1 my-2">
                                                <select class="sorting form-control form-control-sm" style="width: 100%">
                                                    <option value selected disabled data-index="0">Select Sorting Option</option>
                                                    <option value="oldest" {{ $params['order'] === 'asc' || request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest
                                                    </option>
                                                    <option value="newest" {{ $params['order'] === 'desc' || request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest
                                                    </option>
                                                </select>
                                                </span>
                                                @php $agencies = Auth::user()->agencies->where('status','verified')->pluck('id')->toArray();
                                                $agency_users = (new \App\Models\AgencyUser())->whereIn('agency_id',$agencies)->get();
                                                @endphp
                                                @if(count($agency_users) > 0)
                                                    <span class="pull-right mx-1 my-2">
                                                    <select class="form-control form-control-sm agency_users" style="width: 100%" data-placeholder="Select Agency Member">
                                                        <option value disabled data-index="-1">Select Agency User</option>
                                                        <option value="all" selected>All Agency Users</option>
                                                        @foreach (Auth::user()->agencies->where('status','verified') as $agency)
                                                            <option class="font-weight-bold agency-name" data-agency="{{$agency->id}}" value="{{$agency->id}}">{{$agency->title}}</option>
                                                            @foreach ($agency->agencyUsers as $agency_user)
                                                                @if($agency_user->user->id !== Auth::user()->id)
                                                                    <option value="{{$agency_user->user->id}}" data-agency="{{$agency->id}}"
                                                                            data-user="{{$agency_user->user->id}}">{{$agency_user->user->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </span>
                                                @endif


                                                <div class="my-4 component-block">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="transition-background color-green">
                                                            <tr>
                                                                <td>ID</td>
                                                                @if($option === 'all')
                                                                    <td>Purpose</td>
                                                                @endif
                                                                <td>Type</td>
                                                                <td>Location</td>
                                                                <td>Price (PKR)</td>
                                                                <td>Added By</td>
                                                                <td>Listed For</td>
                                                                <td>Listed Date</td>
                                                                @if($params['status'] == 'active')
                                                                    <td>Activation Date</td>
                                                                    <td>Package</td>
                                                                @endif
                                                                @if($params['status'] != 'deleted' || $params['status'] != 'pending' )
                                                                    <td>Status Controls</td>
                                                                @endif
                                                                @if($params['status'] == 'expired')
                                                                    <td>Expired At</td>
                                                                @endif
                                                                <td>Controls</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($listings[$option] !== null)
                                                                @forelse($listings[$option] as $all_listing)
                                                                    <tr>
                                                                        <td>{{ $all_listing->id }}</td>
                                                                        @if($option === 'all')
                                                                            <td>{{ $all_listing->purpose}}</td>
                                                                        @endif
                                                                        <td>{{ $all_listing->type }}</td>
                                                                        <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                                                        @if($all_listing->price != '0')
                                                                            <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                                                        @else
                                                                            <td class="pr-3">{{ 'Call option selected for price'}}</td>
                                                                        @endif
                                                                        <td>{{\App\Models\Dashboard\User::getUserName($all_listing->user_id)}}</td>
                                                                        <td>{{$all_listing->agency_id == null ? 'Individual':'Agency ('.\App\Models\Agency::getAgencyTitle($all_listing->agency_id) .')'}}</td>
                                                                        <td>{{ (new \Illuminate\Support\Carbon($all_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>
                                                                        @if($params['status'] == 'active')
                                                                            <td>
                                                                                <div>
                                                                                {{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                                </div>
                                                                                <div class="badge badge-success p-2">
                                                                                    @if(str_contains ( (new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1]), 'ago' ))
                                                                                        <strong
                                                                                            class="color-white font-12"> Expired {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                                    @else
                                                                                        <strong
                                                                                            class="color-white font-12"> Expires in {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                                    @endif
                                                                               </div>
                                                                            </td>
                                                                            <td>
                                                                                @if($all_listing->golden_listing == 1)
                                                                                    Gold
                                                                                @elseif($all_listing->silver_listing == 1)
                                                                                    Silver
                                                                                @else
                                                                                    Basic
                                                                                @endif
                                                                            </td>
                                                                        @endif

                                                                        @if($params['status'] != 'deleted')
                                                                            <td>
                                                                                @if($params['status'] === 'sold')
                                                                                    <div class="badge badge-success p-2 "><strong class="color-white font-12">Property Sold Out</strong>
                                                                                    </div>
                                                                                @elseif($params['status'] === 'pending' )
                                                                                    <div class="badge badge-warning p-2 "><strong class="font-12">Pending For Verification</strong>
                                                                                    </div>
                                                                                    {{--                                                                                @elseif($params['status'] === 'deleted')--}}

                                                                                @else
                                                                                    <form>
{{--                                                                                        @if($params['status'] != 'expired')--}}

                                                                                        {{--                                                                                        @endif--}}
                                                                                        @if($params['status'] === 'active' && $params['status'] != 'pending')
                                                                                            <input type="radio" name="status" value="reactive" class="mb-1"
                                                                                                   {{$all_listing->status === 'active'? 'checked':'' }}
                                                                                                   data-id="{{ $all_listing->id }}">
                                                                                            <label for="active">Active</label>
                                                                                        @endif
                                                                                        @if($params['status'] === 'rejected')
                                                                                            <div class="badge badge-danger p-2 "><strong class="color-white font-12">Property Rejected</strong></div>
                                                                                        @else
                                                                                            <input type="radio" name="status" value="expired" class="mb-1"
                                                                                                   {{$all_listing->status === 'expired'? 'checked':'' }}
                                                                                                   {{$all_listing->status === 'sold'? 'checked':'' }}
                                                                                                   data-id="{{ $all_listing->id }}" {{$all_listing->status === 'expired'? 'checked':'' }}>
                                                                                            <label for="expired">Expired</label>

                                                                                            @if($params['status'] != 'sold' && $all_listing->purpose != 'Wanted' )
                                                                                                <input type="radio" name="status" value="sold" class="mb-1"
                                                                                                       data-id="{{ $all_listing->id }}" {{$all_listing->status === 'sold'? 'checked':'' }}>
                                                                                                <label for="sold">Sold</label>
                                                                                            @endif
                                                                                        @endif
                                                                                    </form>
                                                                                @endif
                                                                            </td>
                                                                        @else
                                                                            <td>
                                                                                <div class="badge badge-danger p-2 "><strong class="color-white font-12">Property Deleted</strong>
                                                                                    </div>
                                                                            </td>
                                                                        @endif
                                                                        @if($params['status'] == 'expired')
                                                                            <td>
                                                                                <div>
                                                                                {{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                                </div>
                                                                                <div class="badge badge-danger p-2">
                                                                                    <strong
                                                                                        class="color-white font-12"> Expired {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                               </div>
                                                                            </td>
                                                                        @endif
                                                                        <td>
                                                                            @if($params['status'] == 'active')
                                                                                @if($all_listing->id < 104280)
                                                                                    <a type="button" target="_blank"
                                                                                       href="{{route('properties.show',[
                                                                                                'slug'=>Str::slug($all_listing->location) . '-' . Str::slug($all_listing->title) . '-' . $all_listing->reference,
                                                                                                'property'=>$all_listing->id])}}"

                                                                                       class="btn btn-sm btn-primary mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="View Property">
                                                                                    <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                                </a>
                                                                                @else
                                                                                    <a type="button" target="_blank"
                                                                                       href="{{route('properties.show',[
                                                                                                'slug'=>Str::slug($all_listing->city) . '-' .Str::slug($all_listing->location) . '-' . Str::slug($all_listing->title) . '-' . $all_listing->reference,
                                                                                                'property'=>$all_listing->id])}}"

                                                                                       class="btn btn-sm btn-primary mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="View Property">
                                                                                    <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                                </a>
                                                                                @endif
{{--                                                                                <a type="button" target="_blank"--}}
{{--                                                                                   href="{{ route('package.index') }}"--}}
{{--                                                                                   class="btn btn-sm btn-success mb-1"--}}
{{--                                                                                   data-toggle-1="tooltip"--}}
{{--                                                                                   data-placement="bottom" title="Add To Package">--}}
{{--                                                                                    <i class="fas fa-plus"></i><span class="sr-only sr-only-focusable" aria-hidden="true"> Add To Package</span>--}}
{{--                                                                                </a>--}}
                                                                            @endif
                                                                            @if($params['status'] == 'expired')
                                                                                <a type="button"
                                                                                   class="btn btn-sm btn-success color-black restore-btn mb-1"
                                                                                   data-toggle-1="tooltip" data-placement="bottom"
                                                                                   title="Restore Property"
                                                                                   href="javascript:void(0)"
                                                                                   data-record-id="{{$all_listing->id}}">
                                                                                    <i class="fas fa-redo-alt"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                                </a>
                                                                            @endif
                                                                            @if($params['status'] != 'deleted')
                                                                                <a type="button"
                                                                                   href="{{$params['status'] == 'deleted'?
                                                                                        '': route('properties.edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-warning mb-1
                                                                                    {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Edit Property">
                                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                                <a type="button" class="btn btn-sm btn-danger mb-1" data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Delete Property"
                                                                                   data-toggle="modal" data-target="#delete"
                                                                                   data-record-id="{{$all_listing->id}}">
                                                                                    <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                </a>
                                                                            @elseif($params['status'] == 'deleted')
                                                                                <a type="button"
                                                                                   class="btn btn-sm btn-success color-black restore-btn mb-1
                                                                                    {{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                                                                   data-toggle-1="tooltip" data-placement="bottom"
                                                                                   title="restore"
                                                                                   href="javascript:void(0)"
                                                                                   data-record-id="{{$all_listing->id}}">
                                                                                    <i class="fas fa-redo-alt"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                                </a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="12" class="p-4 text-center">No Listings Found!</td>
                                                                    </tr>
                                                                @endforelse
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @if($params['status'] === 'edited')
                                                        <div class="font-12 mb-2"><span class="color-red">*</span> Please check reactive button for verification of changes</div>
                                                    @elseif([$params['status'] === 'active'] ||[$params['status'] === 'expired'] )
                                                        <div class="font-12 mb-2"><span class="color-red">*</span> If property is expired, it will not display on the main site</div>
                                                    @endif
                                                    @if($listings[$option] !== null)
                                                        {{--                                                        {{ $listings[$option]->links() }}--}}
                                                        {{ $listings[$option]->links('vendor.pagination.bootstrap-4') }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('website.layouts.delete-modal', array('route'=>'properties'))

    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/listings-page.js')}}" defer></script>
@endsection
