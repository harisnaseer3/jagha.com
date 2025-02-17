<div class="option-bar">
    <div class="float-left">
        <h4>
            {{--            <span class="heading-icon"><i class="fa fa-th-list"></i></span>--}}
            <span class="title-name text-transform ml-2">Properties List</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <select class="record-limit none-992" id="list-record">
                <option value="15" {{ request()->query('limit') === '15'  ? 'selected' : '' }}>15 Records</option>
                <option value="30" {{ request()->query('limit') === '30'  ? 'selected' : '' }}>30 Records</option>
                <option value="45" {{ request()->query('limit') === '45'  ? 'selected' : '' }}>45 Records</option>
                <option value="60" {{ request()->query('limit') === '60'  ? 'selected' : '' }}>60 Records</option>
            </select>
            <select class="sorting area-filter none-992" id="list-area-filter">
                <option disabled selected>Select Area Filter</option>
                <option value="higher_area" {{request()->query('area_sort') === 'higher_area' ? 'selected' : '' }}>Area (High To Low)</option>
                <option value="lower_area" {{ request()->query('area_sort') === 'lower_area'? 'selected' : '' }}>Area (Low To High)</option>
            </select>
            <select class="sorting" id="list-sorting">
                <option value="newest" {{  request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{  request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest</option>
                <option value="high_price" {{ request()->query('sort') === 'high_price' ? 'selected' : '' }}>Price (High To Low)</option>
                <option value="low_price" {{  request()->query('sort') === 'low_price'? 'selected' : '' }}>Price (Low To High)</option>
            </select>
            <a class="change-view-btn active-view-btn list-layout-btn" role="button" aria-label="List view"><i class="fa fa-th-list"></i></a>
            <a class="change-view-btn grid-layout-btn" role="button" aria-label="Grid view"><i class="fa fa-th-large"></i></a>
        </div>
    </div>
</div>


@if($properties->isEmpty())
    <div> No results to show</div>
@endif

<!-- Property box 2 start -->
@foreach($properties as $property)
    <div class="property-box-2">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-pad">
                @if($property->id < 104280)
                    <a href="{{route('properties.show',[
                            'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                            'property'=>$property->id])}}"
                @else
                    <a href="{{route('properties.show',[
                            'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                            'property'=>$property->id])}}" @endif

                    class="property-img" title="{{$property->sub_type}} for {{$property->purpose}}">
                        <img
                            src="{{ $property->user_id !== 1 && isset($property->image)? asset('thumbnails/properties/'.explode('.',$property->image)[0].'-450x350.webp'): asset("/img/logo/dummy-logo.png")}}"
                            alt="{{$property->sub_type}} for {{$property->purpose}}"
                            title="{{$property->sub_type}} for {{$property->purpose}}" class="img-fluid" aria-label="Listing photo" onerror="this.src='{{asset("/img/logo/dummy-logo.png")}}'">

{{--                                                {{dd($property)}}--}}
                        @if(isset($property->golden_listing) && $property->golden_listing == 1)
                            <div class="listing-badges"><span aria-label="super hot label" class="featured">Golden</span></div>
                        @elseif(isset($property->platinum_listing) && $property->platinum_listing  == 1)
                            <div class="listing-badges"><span aria-label="hot label" class="featured">Platinum</span></div>
                        @endif
                        <div class="listing-time opening" aria-label="purpose label">
                            @if( $property->purpose === 'Wanted')
                                {{ $property->purpose }} Property
                            @else
                                For {{ $property->purpose }}
                            @endif
                        </div>
                        <div class="price-ratings-box">
                            @if($property->price != 0)
                                <p class="price">
                                    <span class="color-white" aria-label="currency">PKR</span> <span class="color-white" aria-label="price"> {{ $property->price }}</span>
                                </p>
                            @else
                                <p class="price">
                                    <span class="color-white" aria-label="currency"></span> <span class="color-white" aria-label="price">Call Us for Price Details</span>
                                </p>
                            @endif
                            <div class="ratings stars" data-rating="{{$property->views > 0 ? (($property->favorites/$property->views)*5) : 0}}" data-num-stars="5" aria-label="rating"></div>
                        </div>
                    </a>
            </div>
            <div class="col-lg-7 col-md-7 col-pad">
                <div class="detail">
                    <h2 class="title">
                        @if($property->id < 104280)
                            <a href="{{route('properties.show',[
                            'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                            'property'=>$property->id])}}"
                        @else
                            <a href="{{route('properties.show',[
                            'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                            'property'=>$property->id])}}" @endif


                            data-toggle="tooltip" data-placement="right" data-html="true"
                               title='<div class="row mt-1">
                           <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>
                           <div class="col-md-12 mb-1  mt-1"> {{ number_format($property->area_in_sqft,2) }} Sq.Ft.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqyd,2) }} Sq.Yd.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqm,2) }} Sq.M.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_marla,2) }} Marla </div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_kanal,2) }} Kanal </div>
                           </div>'>
                                @if($property->price != 0)
                                    <span aria-label="currency" class="font-16"> PKR </span>
                                    <span aria-label="price"> {{Helper::getPriceInWords($property->price)}} </span>
                                @else
                                    <span aria-label="currency" class="font-16"></span><span aria-label="price">Call Us for Price Details</span></span>
                                @endif
                            </a>
                            <div class="pull-right" style="font-size: 1rem">
                                @if(isset($property->agency_status) && $property->agency_status === 'verified')
                                    <span style="color:green" data-toggle="tooltip" data-placement="top"
                                          title=" {{$property->agency}} is our verified partner. To become our trusted partner, simply contact us or call us at +92 51 4862317 OR +92 315 5141959"><i
                                            class="far fa-shield-check"></i></span>
                                @endif
                                @if(isset($property->featured_listing) && $property->featured_listing === 1)
                                    <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> FEATURED PARTNER</span></span>
                           </span>
                                @endif
                            </div>
                    </h2>
                    <h5 class="location">
                        <a aria-label="Listing location" title="{{$property->title}}"><i class="flaticon-location"></i>
                            {{ \Illuminate\Support\Str::limit($property->location, 15, $end='...') }} {{ \Illuminate\Support\Str::limit($property->city, 15, $end='...') }}
                        </a>
                    </h5>
                    <ul class="facilities-list facilities-list-custom clearfix">
                        <li aria-label="bedrooms">
                            @if($property->bedrooms > 0)
                                <i class="fal fa-bed-alt"></i>
                                <span>{{ number_format($property->bedrooms) }} Beds</span>
                            @endif
                        </li>
                        <li aria-label="baths">
                            @if($property->bathrooms > 0)
                                <i class="fal fa-bath"></i>
                                <span>{{ number_format($property->bathrooms) }} Baths</span>
                            @endif
                        </li>
                        <li aria-label="land area" style="width:50%;" data-toggle="tooltip" data-placement="top" data-html="true"
                            title='<div class="row mt-1">
                           <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>
                           <div class="col-md-12 mb-1  mt-1"> {{ number_format($property->area_in_sqft,2) }} Sq.Ft.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqyd,2) }} Sq.Yd.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqm,2) }} Sq.M.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_marla,2) }} Marla </div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_kanal,2) }} Kanal </div>
                           </div>'>
                            @if(request()->query('area_unit') != null)
                                <i class="fas fa-arrows-alt"></i>
                                <span>
                                    @if(str_replace('-',' ',request()->query('area_unit')) == 'marla'){{ number_format($property->area_in_new_marla,2) }} Marla
                                    {{--                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'new kanal (16 marla)'){{ number_format($property->area_in_new_kanal,2) }} Kanal--}}
                                    {{--                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'marla'){{ number_format($property->area_in_marla,2) }} Old Marla (272 sqft)--}}
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'kanal'){{ number_format($property->area_in_kanal,2) }} Kanal
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'square feet'){{ number_format($property->area_in_sqft,2) }} Sq.F.
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'square meters'){{ number_format($property->area_in_sqm,2) }} Sq.M
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'square yards'){{ number_format($property->area_in_sqyd,2) }} Sq.Yd.
                                    @endif
                                </span>
                                {{--                                <span> {{ number_format($property->land_area, 2) }}--}}
                                {{--                                    @if($property->area_unit == 'Square Meters') Sq.M.--}}
                                {{--                                    @elseif($property->area_unit == 'Square Feet')Sq.F.--}}
                                {{--                                    @elseif ($property->area_unit == 'Square Yards') Sq.Yd.--}}
                                {{--                                    @else {{$property->area_unit}}  --}}
                                {{--                                    @endif--}}
                                {{--                                </span>--}}
                                {{--                            @elseif(isset($property->land_area))--}}
                                {{--                                <i class="fas fa-arrows-alt"></i>--}}
                                {{--                                <span> {{ number_format($property->land_area,2) }}--}}
                                {{--                                    @if($property->area_unit == 'Square Meters') Sq.M.--}}
                                {{--                                    @elseif($property->area_unit == 'Square Feet')Sq.F.--}}
                                {{--                                    @elseif ($property->area_unit == 'Square Yards') Sq.Yd.--}}
                                {{--                                    @else {{$property->area_unit}}  @endif--}}
                                {{--                                </span>--}}
                            @endif
                        </li>
                    <!-- <li class="property-agency-logo">
                        @if(isset($property->logo))
                        <img src="{{asset('thumbnails/agency_logos/'.explode('.',$property->logo)[0].'-100x100.webp')}}"  alt="{{$property->agency}}" title="{{$property->agency}}" class="d-block ml-auto mr-auto w-50 mt-5 mb-5" aria-label="Listing photo">
                        @endif
                        </li>    -->
                    </ul>
                    <div class="row call-email-container contact-container">
                        {{ Form::hidden('phone',$property->cell, array_merge(['class'=>'number']))}}
                        {{ Form::hidden('title',$property->title)}}
                        {{ Form::hidden('reference',$property->reference)}}
                        @if(!empty($agency))
                            {{ Form::hidden('agent',$agency->id)}}
                        @else
                            {{ Form::hidden('property',$property->id)}}
                        @endif
                        <div class="col-sm-12 col-md-9" style="height:70px;">
                            <div class="mb-2">
                                @if($property->id < 104280)
                                    <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                        'property'=>$property->id])}}"
                                @else
                                    <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                        'property'=>$property->id])}}" @endif
                                    title="{{$property->sub_type}} for {{$property->purpose}}" class="property-title text-transform mb-2">
                                        {{\Illuminate\Support\Str::limit(strtolower($property->title), 30, $end='...')}}
                                    </a>
                            </div>
                            <div class="property-description">
                                @if($property->id < 104280)
                                    <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                        'property'=>$property->id])}}"
                                @else
                                    <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                        'property'=>$property->id])}}" @endif

                                    title="{{$property->sub_type}} for {{$property->purpose}}" class="custom-font text-transform property-description">
                                        {{$property->user_id !== 1 ?\Illuminate\Support\Str::limit(strtolower($property->description),75, $end='...more'):'No description added'}}
                                    </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 partner-logo-style" style="height:70px;">
                            {{--                            {{dd($property->logo)}}--}}
                            @if($property->agency)
                                @if($property->user_id !== 1 && isset($property->logo))
                                    <img src="{{asset('thumbnails/agency_logos/'.explode('.',$property->logo)[0].'-100x100.webp')}}" alt="{{$property->agency}}"
                                         onerror="this.src='{{asset('img/logo/dummy-logo.png')}}'"
                                         data-toggle="popover" data-trigger="hover" title="{{$property->agency}}" data-html='true' data-content='
                                    <div><span class="float-left color-blue">Total Properties: {{$property->agency_property_count}}</span>
                                    <span class="float-right color-blue">Partner Since: {{ (new \Illuminate\Support\Carbon($property->agency_created_at))->diffForHumans(['parts' => 2]) }}</span>
                                    <br \>
                                    <div>{{$property->agency_description}}</div>'>
                                @else
                                    <img src="{{asset('img/logo/dummy-logo.png')}}" alt="{{$property->agency}}"
                                         data-toggle="popover" data-trigger="hover" title="{{$property->agency}}" data-html='true' data-content='
                                    <div><span class="float-left color-blue">Total Properties: {{$property->agency_property_count}}</span>
                                    <span class="float-right color-blue">Partner Since: {{ (new \Illuminate\Support\Carbon($property->agency_created_at))->diffForHumans(['parts' => 2]) }}</span>
                                    <br \>
                                    <div>{{$property->user_id !== 1 ?$property->agency_description:''}}</div>'>

                                @endif
                            @endif
                        </div>
                    <!-- <div class="col-sm-12 property-description">
                               @if($property->id < 104280)
                        <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                        'property'=>$property->id])}}"
                        @else
                        <a href="{{route('properties.show',[
                                        'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                        'property'=>$property->id])}}" @endif
                        title="{{$property->sub_type}} for {{$property->purpose}}" class="custom-font text-transform">
                                {{\Illuminate\Support\Str::limit(strtolower($property->description), 100, $end='...more')}}
                        </a>
                    </div> -->
                        <div class="col-sm-6 p-1">
                            <button class="btn btn-block mb-1 btn-call call-model-btn" data-toggle="modal" data-target="{{'#CallModelCenter'.$property->reference}}" aria-label="Call">Call</button>
                        </div>

                        @if($property->email != null)
                            <div class="col-sm-6 p-1">
                                <button class="btn btn-block  mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</button>
                            </div>
                        @else
                            <div class="col-sm-6 p-1" data-toggle="tooltip" data-placement="top" data-html="true" title="<div>Currently not available</div>"><a
                                    class="btn btn-block  mb-1 btn-email disabled" aria-label="Email">Email</a></div>
                        @endif
                    </div>
                </div>
                <div class="footer clearfix">
                    <div class="float-left mr-2">
                        <a aria-label="Listing creation date"><i class="fas fa-eye"></i> {{ $property->views}}</a>
                    </div>
                    <ul class="float-left mr-2">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <li>
                                <div class="favorite-property" style="font-size: 20px;">
                                    <a href="javascript:void(0);" title="Add to favorite"
                                       style="display: {{$property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()? 'none':'block' }}"
                                       class="favorite" data-id="{{$property->id}}">
                                        <i class="fal fa-heart empty-heart color-black"></i>
                                    </a>
                                    <a href="javascript:void(0);" title="Add to favorite"
                                       style="display : {{$property->user_favorite === \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() ? 'block':'none'}}"
                                       class="remove-favorite color-black" data-id="{{$property->id}}">
                                        <i class="fas fa-heart filled-heart color-red"></i>
                                    </a>
                                </div>
                            </li>
                            {{--                        @else--}}
                            {{--                            <li>--}}
                            {{--                                <div class="favorite-property font-20">--}}
                            {{--                                    <a data-toggle="modal" data-target="#exampleModalCenter" class="favourite color-black" title="Add to favorite">--}}
                            {{--                                        <i class="fal fa-heart empty-heart"></i>--}}
                            {{--                                    </a>--}}
                            {{--                                </div>--}}
                            {{--                            </li>--}}
                        @endif
                    </ul>
                    <div class="pull-left days">
                        <a><i class="fa fa-user"></i>
                            @if($property->contact_person != '')
                                <span data-toggle="tooltip" data-placement="top" data-html="true" title="<div>{{ucwords($property->contact_person)}}</div>">
                                    {{count(explode(',',$property->contact_person)) > 1 ? \Illuminate\Support\Str::limit(ucwords(explode(',',$property->contact_person)[0]), 20, $end='..').'..' : \Illuminate\Support\Str::limit(ucwords(explode(',',$property->contact_person)[0]), 20, $end='...')}}
                                </span>
                            @else
                                <span data-toggle="tooltip" data-placement="top" data-html="true" title="<div>{{ucwords($property->agent)}}</div>">
                                    {{count(explode(',',$property->agent)) > 1 ? \Illuminate\Support\Str::limit(ucwords(explode(',',$property->agent)[0]), 20, $end='..').'..' : \Illuminate\Support\Str::limit(ucwords(explode(',',$property->agent)[0]), 20, $end='...')}}
                                </span>
                            @endif
                        </a>
                    </div>
                    <div class="pull-right">
                        <a aria-label="Listing creation date"><i class="flaticon-time"></i>
                            {{ (new \Illuminate\Support\Carbon($property->created_at))->diffForHumans()}}   <!-- ['parts' => 2] -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="{{'CallModelCenter'.$property->reference}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Contact Us</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="container" style="font-size: 12px; color: #555">
                        <div class="text-center">
                            <div class="mb-2">

                                @if($property->id < 104280)
                                    <a href="{{route('properties.show',[
                                                'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                                'property'=>$property->id])}}"
                                @else
                                    <a href="{{route('properties.show',[
                                                    'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                                                    'property'=>$property->id])}}" @endif
                                    class="font-weight-bold title-font"
                                       title="{{$property->sub_type}} for {{$property->purpose}}">{{ $property->title }}</a></div>
                            <div class="mb-2 font-weight-bold"> {{ $property->agency !== null ? $property->agency: '' }} </div>
                            <div class="mb-2">Please use property ID</div>
                            <div class="mb-2" style="font-weight: bold"> {{ $property->id }} </div>
                            <div class="mb-2">While calling please mention <a class="hover-color link-font" href="https://www.jagha.com/">https://www.jagha.com</a></div>
                        </div>

                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td class="w-30">Mobile</td>
                                @if(isset($property->cell) && $property->cell !== '')
                                    <td class="w-70 font-weight-bold">{{$property->cell}}</td>
                                @elseif(isset($property->agency_cell) && $property->agency_cell !== '')
                                    <td class="w-70 font-weight-bold">{{ $property->agency_cell}}</td>
                                @else
                                    <td class="font-weight-bold">-</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Phone No</td>
                                @if(isset($property->phone) && $property->phone !== '')
                                    <td class="font-weight-bold">{{$property->phone}}</td>
                                @elseif(isset($property->agency_phone) && $property->agency_phone !== '')
                                    <td class="font-weight-bold">{{$property->agency_phone}}</td>
                                @else
                                    <td class="font-weight-bold">-</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Agent</td>
                                @if($property->contact_person != '' || $property->agent!= '' )
                                    <td class="font-weight-bold">{{ $property->contact_person != ''? ucwords($property->contact_person) : ucwords($property->agent)}}</td>
                                @else
                                    <td class="font-weight-bold">{{ $property->user_nick_name != ''? ucwords($property->user_nick_name) : ucwords($property->user_name)}}</td>

                                @endif

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
