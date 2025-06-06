<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
                        <span class="heading-icon"><i class="fa fa-th-large"></i></span>
            <span class="title-name ml-2 text-transform">Properties Grid</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <select class="record-limit none-992" id="grid-record">
                <option value="15" {{request()->query('limit') === '15'  ? 'selected' : '' }}>15 Records</option>
                <option value="30" {{request()->query('limit') === '30'  ? 'selected' : '' }}>30 Records</option>
                <option value="45" {{request()->query('limit') === '45'  ? 'selected' : '' }}>45 Records</option>
                <option value="60" {{request()->query('limit') === '60'  ? 'selected' : '' }}>60 Records</option>
            </select>
            <select class="sorting area-filter none-992" id="grid-area-filter">
                <option disabled selected>Select Area Filter</option>
                <option value="higher_area" {{request()->query('area_sort') === 'higher_area' ? 'selected' : '' }}>Area (High To Low)</option>
                <option value="lower_area" {{ request()->query('area_sort') === 'lower_area'? 'selected' : '' }}>Area (Low To High)</option>
            </select>
            <select class="sorting" id="grid-sorting">
                <option value="newest" {{ request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest</option>
                <option value="high_price" {{ request()->query('sort') === 'high_price' ? 'selected' : '' }}>Price (High To Low)</option>
                <option value="low_price" {{ request()->query('sort') === 'low_price'? 'selected' : '' }}>Price (Low To High)</option>
            </select>
            <a class="change-view-btn list-layout-btn" role="button" aria-label="List view"><i class="fa fa-th-list"></i></a>
            <a class="change-view-btn active-view-btn grid-layout-btn" role="button" aria-label="Grid view"><i class="fa fa-th-large"></i></a>
        </div>
    </div>
</div>

@if($properties->isEmpty())
    <div> No results to show</div>
@endif
<!-- Property section start -->
<div class="row property-section">
    @foreach($properties as $property)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="property-box">
                <div class="property-thumbnail">
                    @if($property->id < 104280)
                        <a href="{{route('properties.show',[
                        'slug'=>Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                        'property'=>$property->id])}}"
                    @else
                        <a href="{{route('properties.show',[
                            'slug'=>Str::slug($property->city) . '-' .Str::slug($property->location) . '-' . Str::slug($property->title) . '-' . $property->reference,
                            'property'=>$property->id])}}"
                           @endif

                           class="property-img" title="{{$property->sub_type}} for {{$property->purpose}}">
                            <div class="listing-badges">
                                @if($property->platinum_listing == 1)
                                    <span class="featured bg-red" aria-label="premium label">Platinum</span>
                                @elseif($property->golden_listing == 1)
                                    <span class="featured bg-red" aria-label="super hot label">Golden</span>
                                                                    @elseif($property->bronze_listing  == 1)
                                                                        <span class="featured" aria-label="hot label">Bronze</span>
                                                                    @elseif($property->golden_listing  == 1)
                                                                        <span class="featured" aria-label="hot label">Golden</span>
                                @endif
                                @if(isset($property->featured_listing)  && $property->featured_listing == 1)
                                    <span class="featured float-right tag-padding" style="background-color: #555">
                                    <span style="color:#ffcc00 ;"><i class="fas fa-star"></i>
                                        <span class="color-white">FEATURED PARTNER</span>
                                    </span>
                                </span>

                                @else(isset($property->key_listing)  && $property->key_listing == 1)
                                    <span class="featured float-right tag-padding" style="background-color: #555">
                                    <span style="color:#ffcc00 ;"><i class="fas fa-star"></i>
                                        <span class="color-white">KEY PARTNER</span>
                                    </span>
                                </span>
                                @endif
                            </div>

                            <div class="price-ratings-box">
                                @if($property->price != 0 )
                                    <p class="price">
                                        <span aria-label="currency" class="color-white"> PKR </span> <span aria-label="price" class="color-white">{{ $property->price}}</span>
                                    </p>
                                @else
                                    <p class="price"><span aria-label="currency" class="color-white"> Call Us for Price Details </span>
                                    </p>
                                @endif


                                <div class="ratings grid-stars" data-rating="{{$property->views > 0 ? (($property->favorites/$property->views)*5) : 0}}"
                                     data-num-stars="5" aria-label="rating"></div>
                            </div>
                            <img class="d-block w-100"
                                 src="{{ $property->user_id !== 1 && isset($property->image)? asset('thumbnails/properties/'.explode('.',$property->image)[0].'-450x350.webp'): asset("img/logo/dummy-logo.png")}}"
                                 onerror="this.src='{{asset("/img/logo/dummy-logo.png")}}'"
                                 alt="{{$property->sub_type}} for {{$property->purpose}}"
                                 title="{{$property->sub_type}} for {{$property->purpose}}">
                        </a>
                </div>
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
                           <div class="col-md-12 mb-1 mt-1"> {{ number_format($property->area_in_sqft,2) }} Sq.Ft.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqyd,2) }} Sq.Yd.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqm,2) }} Sq.M.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_marla,2) }} Marla</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_kanal,2) }} Kanal </div>
                           </div>'>
                                @if($property->price != 0 )
                                    <span aria-label="currency" class="font-size-14 color-blue">PKR </span>
                                    <span aria-label="price" class="color-blue"> {{str_replace('Thousand','K',Helper::getPriceInWords($property->price))}}</span>
                                @else
                                    <span aria-label="currency" class="font-size-14 color-blue"> </span>
                                    <span aria-label="price" class="font-size-14 color-blue">Call Us for Price Details</span>
                                @endif

                            </a>
                            <div class="pull-right" style="font-size: 1rem">
                                @if(isset($property->agency_status)  && $property->agency_status === 'verified')
                                    <span style="color:green" data-toggle="tooltip" data-placement="top"
                                          title="{{$property->agency}} is our verified partner. To become our trusted partner, simply contact us or call us at +92 51 4862317 OR +92 315 5141959"><i
                                            class="far fa-shield-check"></i></span>
                                @endif
                            </div>
                    </h2>
                    <div class="location">
                        <a href="javascript:void(0)" aria-label="Listing location">
                            <i class="fa fa-map-marker"></i>
                            {{ \Illuminate\Support\Str::limit($property->location , 12, $end='...')}}
                            <span class="grid-area hidden-md">,{{ \Illuminate\Support\Str::limit($property->city, 11, $end='...') }}</span>
                        </a>
                    </div>
                    <ul class="facilities-list clearfix grid-view-facilities">
                        @if(request()->query('area_unit') != null)
                            <li aria-label="land area" style="width:100%;" data-toggle="tooltip" data-placement="right" data-html="true"
                                title='<div class="row mt-1">
                           <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>
                           <div class="col-md-12 mb-1  mt-1"> {{ number_format($property->area_in_sqft,2) }} Sq.Ft.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqyd,2) }} Sq.Yd.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqm,2) }} Sq.M.</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_marla,2) }} Marla</div>
                           <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_kanal,2) }} Kanal</div>
                           </div>'><i class="fas fa-arrows-alt"></i>
                                <span>
                                    @if(str_replace('-',' ',request()->query('area_unit')) == 'marla'){{ number_format($property->area_in_new_marla,2) }} Marla
                                                                        @elseif(str_replace('-',' ',request()->query('area_unit')) == 'new kanal (16 marla)'){{ number_format($property->area_in_new_kanal,2) }} Kanal
                                                                        @elseif(str_replace('-',' ',request()->query('area_unit')) == 'marla'){{ number_format($property->area_in_marla,2) }} Old Marla (272 sqft)
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'kanal'){{ number_format($property->area_in_kanal,2) }} Kanal
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'square feet'){{ number_format($property->area_in_sqft,2) }} Sq.F.
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'square meters'){{ number_format($property->area_in_sqm,2) }} Sq.M
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) == 'square yards'){{ number_format($property->area_in_sqyd,2) }} Sq.Yd.
                                    @endif
                                </span>
                            </li>
                                                    @elseif(isset($property->land_area))
                                                        <li aria-label="land area" data-toggle="tooltip" data-placement="right" data-html="true"
                                                            title='<div class="row mt-1">
                                                       <div class="col-md-12 color-white"><h6 class="color-white">Area Info</h6> <hr class="solid"></div>
                                                       <div class="col-md-12 mb-1 mt-1"> {{ number_format($property->area_in_sqft,2) }} Sq.Ft.</div>
                                                       <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqyd,2) }} Sq.Yd.</div>
                                                       <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqm,2) }} Sq.M.</div>
                                                       <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_marla,2) }} Marla</div>
                                                       <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_kanal,2) }} Kanal </div>
                                                       </div>'>
                                                            <i class="fas fa-arrows-alt"></i>
                                                            {{ number_format($property->land_area, 2) }} @if($property->area_unit === 'Square Meters') Sq.M. @elseif($property->area_unit === 'Square Feet')
                                                                Sq.F. @elseif ($property->area_unit === 'Square Yards') Sq.Yd. @else {{$property->area_unit}} @endif
                                                        </li>
                        @endif
                    </ul>
                </div>
                <div class="row contact-container" style="padding: 0 20px;">
                    {{ Form::hidden('phone',$property->cell, array_merge(['class'=>'number']))}}
                    {{ Form::hidden('reference',$property->reference)}}
                    {{ Form::hidden('title',$property->title)}}
                    @if(!empty($agency))
                        {{ Form::hidden('agent',$agency->id)}}
                    @else
                        {{ Form::hidden('property',$property->id)}}
                    @endif
                    <div class="col-sm-6 p-1">
                        <button class="btn btn-block btn-call mb-1 call-model-btn" data-toggle="modal" data-target="{{'#CallModel2'.$property->reference}}" aria-label="Call">Call</button>
                    </div>
                    @if($property->email !== null)
                        <div class="col-sm-6 p-1">
                            <button class="btn btn-block mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</button>
                        </div>
                    @else
                        <div class="col-sm-6 p-1" data-toggle="tooltip" data-placement="top" data-html="true" title="<div>Currently not available</div>">
                            <button
                                class="btn btn-block  mb-1 btn-email disabled" aria-label="Email">Email
                            </button>
                        </div>

                    @endif
                </div>
                <div class="footer clearfix" style="line-height: 30px;">
                    <ul class="float-right">
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
                                                    @else
                                                        <li>
                                                            <div class="favorite-property font-20">
                                                                <a data-toggle="modal" data-target="#exampleModalCenter" class="favourite color-black" title="Add to favorite">
                                                                    <i class="fal fa-heart empty-heart"></i>
                                                                </a>
                                                            </div>
                                                        </li>
                        @endif
                    </ul>
                    <div class="days">
                        @if($property->contact_person != '' || $property->agent!= '' )
                            <a><i class="fa fa-user"></i>
                                <span data-toggle="tooltip" data-placement="top" data-html="true" title="<div>{{ucwords($property->contact_person)}}</div>">
                                {{ $property->contact_person != ''? \Illuminate\Support\Str::limit(ucwords($property->contact_person), 20, $end='...'):\Illuminate\Support\Str::limit(ucwords($property->agent), 20, $end='...') }}
                                </span>
                            </a>
                        @else
                            <a><i class="fa fa-user"></i>
                                @if($property->user_nick_name !== '')
                                    <span data-toggle="tooltip" data-placement="top" data-html="true" title="<div>{{ucwords($property->user_nick_name)}}</div>">
                                {{ $property->user_nick_name != ''? \Illuminate\Support\Str::limit(ucwords($property->user_nick_name), 20, $end='...'):\Illuminate\Support\Str::limit(ucwords($property->user_name), 20, $end='...') }}
                                </span>
                                @endif
                            </a>
                        @endif
                    </div>
                    <div>
                        <div class=" float-left mt-0">
                            <a aria-label="Listing creation date"><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($property->activated_at))->diffForHumans(['parts' => 2])}}</a>
                        </div>
                        <div class="float-right mt-0">
                            <a aria-label="Listing creation date"><i class="far fa-eye"></i> {{ $property->views}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{'CallModel2'.$property->reference}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    <td class="font-weight-bold">  {{ $property->contact_person != ''? ucwords($property->contact_person):ucwords($property->agent)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

