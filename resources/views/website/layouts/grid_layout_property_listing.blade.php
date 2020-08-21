<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
            <span class="heading-icon"><i class="fa fa-th-large"></i></span>
            <span class="title-name text-transform">Properties Grid</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <select class="sorting record-limit none-992">
                <option value="15" {{request()->query('limit') === '15'  ? 'selected' : '' }}>15 Records</option>
                <option value="30" {{request()->query('limit') === '30'  ? 'selected' : '' }}>30 Records</option>
                <option value="45" {{request()->query('limit') === '45'  ? 'selected' : '' }}>45 Records</option>
                <option value="60" {{request()->query('limit') === '60'  ? 'selected' : '' }}>60 Records</option>
            </select>
            <select class="sorting area-filter none-992">
                <option value="higher_area" {{request()->query('area_sort') === 'higher_area' ? 'selected' : '' }}>Area (High To Low)</option>
                <option value="lower_area" {{ request()->query('area_sort') === 'lower_area'? 'selected' : '' }}>Area (Low To High)</option>
            </select>
            <select class="sorting">
                <option value="newest" {{ $params['sort'] === 'newest' || request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ $params['sort'] === 'oldest' || request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest</option>
                <option value="high_price" {{ $params['sort'] === 'high_price' || request()->query('sort') === 'high_price' ? 'selected' : '' }}>Price (High To Low)</option>
                <option value="low_price" {{ $params['sort'] === 'low_price' || request()->query('sort') === 'low_price'? 'selected' : '' }}>Price (Low To High)</option>
            </select>
            <a class="change-view-btn  list-layout-btn" role="button" aria-label="List view"><i class="fa fa-th-list"></i></a>
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
                    <a href="{{$property->property_detail_path()}}" class="property-img" title="{{$property->sub_type}} for {{$property->purpose}}">
                        <div class="listing-badges">
                            @if($property->premium_listing == 1)
                                <span class="featured bg-red" aria-label="premium label">Premium</span>
                            @elseif($property->super_hot_listing == 1)
                                <span class="featured bg-red" aria-label="super hot label">Super Hot</span>

                            @elseif($property->hot_listing  == 1)
                                <span class="featured" aria-label="hot label">Hot</span>
                            @endif
                            @if(isset($property->featured_listing)  && $property->featured_listing)
                                <span class="featured float-right tag-padding" style="background-color: #555">
                                    <span style="color:#ffcc00 ;"><i class="fas fa-star"></i>
                                        <span class="color-white">FEATURED PARTNER</span>
                                    </span>
                                </span>
                            @endif
                        </div>

                        <div class="price-ratings-box">
                            <p class="price">
                                <span aria-label="currency" class="color-white">
                                    PKR </span> <span aria-label="price" class="color-white">{{ $property->price}}</span>
                            </p>
                            <div class="ratings grid-stars" data-rating="{{$property->views > 0 ? (($property->favorites/$property->views)*5) : 0}}"
                                 data-num-stars="5" aria-label="rating"></div>
                        </div>
                        <img class="d-block w-100"
                             src="{{ isset($property->image)? asset('thumbnails/properties/'.explode('.',$property->image)[0].'-450x350.webp'): asset("img/logo/dummy-logo.png")}}"
                             alt="{{$property->sub_type}} for {{$property->purpose}}"
                             title="{{$property->sub_type}} for {{$property->purpose}}">
                    </a>
                </div>
                <div class="detail">
                    <h2 class="title">
                        <a href="{{$property->property_detail_path()}}" data-toggle="tooltip" data-placement="right" data-html="true"
                           title='<div class="row">
                                                <div class="col-md-12 color-white"><h5 class="color-white">Area Info</h5></div>
                                                <div class="col-md-12 color-white tooltip-divider"></div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_marla,2) }} New Marla (225 sqft)</div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_new_kanal,2) }} New Kanal (16 Marla)</div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_marla,2) }} Marla </div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_kanal,2) }} Kanal </div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqft,2) }} Sq.Ft.</div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqm,2) }} Sq.M.</div>
                                                <div class="col-md-12 mb-1"> {{ number_format($property->area_in_sqyd,2) }} Sq.Yd.</div>
                                               </div>'>
                            <span aria-label="currency" class="font-size-14 color-blue">PKR </span>
                            <span aria-label="price" class="color-blue"> {{str_replace('Thousand','K',Helper::getPriceInWords($property->price))}}</span>
                        </a>
                        <div class="pull-right" style="font-size: 1rem">
                            @if(isset($property->agency_status)  && $property->agency_status === 'verified')
                                <span style="color:green" data-toggle="tooltip" data-placement="top"
                                      title="{{$property->agency}} is our verified agent. To become our trusted agent, simply contact us or call us at +92 51 4862317 OR +92 301 5993190"><i
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
                            <li aria-label="land area" style="width:100%;"><i class="fas fa-arrows-alt"></i>
                                <span>
                                    @if(str_replace('-',' ',request()->query('area_unit')) === 'new marla (225 sqft)'){{ number_format($property->area_in_new_marla,2) }} New Marla
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) === 'new kanal (16 marla)'){{ number_format($property->area_in_new_kanal,2) }} New Kanal
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) === 'marla'){{ number_format($property->area_in_marla,2) }} Marla
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) === 'kanal'){{ number_format($property->area_in_kanal,2) }} Kanal
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) === 'square feet'){{ number_format($property->area_in_sqft,2) }} Sq.F.
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) === 'square meters'){{ number_format($property->area_in_sqm,2) }} Sq.M
                                    @elseif(str_replace('-',' ',request()->query('area_unit')) === 'square yards'){{ number_format($property->area_in_sqyd,2) }} Sq.Yd.
                                    @endif
                                </span>
                            </li>
                        @elseif(isset($property->land_area))
                            <li aria-label="land area">
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
                    <div class="col-sm-6 p-1"><a class="btn btn-block btn-call mb-1" data-toggle="modal" data-target="{{'#CallModel2'.$property->reference}}" aria-label="Call">Call</a></div>
                    <div class="col-sm-6 p-1"><a class="btn btn-block mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
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
                        <a>
                            <i class="fa fa-user"></i>
                            {{ $property->contact_person != ''? \Illuminate\Support\Str::limit($property->contact_person, 20, $end='...')
                                    :\Illuminate\Support\Str::limit($property->agent, 20, $end='...') }}
                        </a>
                    </div>
                    <div>
                        <div class=" float-left mt-0">
                            <a aria-label="Listing creation date"><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($property->created_at))->diffForHumans(['parts' => 2])}}</a>
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
                                <div class="mb-2"><a href="{{$property->property_detail_path()}}" class="font-weight-bold title-font"
                                                     title="{{$property->sub_type}} for {{$property->purpose}}">{{ $property->title }}</a></div>
                                <div class="mb-2 font-weight-bold"> {{ $property->agency !== null ? $property->agency: '' }} </div>
                                <div class="mb-2">Please use property reference</div>
                                <div class="mb-2" style="font-weight: bold"> {{ $property->reference }} </div>
                                <div class="mb-2">While calling please mention <a class="hover-color link-font" href="https://www.aboutpakistan.com/">https://www.aboutpakistan.com</a></div>
                            </div>

                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td class="w-30">Mobile</td>
                                    <td class="w-70 font-weight-bold">{{ $property->cell !== null  ? $property->cell: '-'}}</td>
                                </tr>
                                <tr>
                                    <td>Phone No</td>
                                    @if($property->phone !== null)
                                        <td class="font-weight-bold">{{$property->phone}}</td>
                                    @elseif($property->agency_phone !== null)
                                        <td class="font-weight-bold">{{$property->phone}}</td>
                                    @else
                                        <td class="font-weight-bold">-</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Agent</td>
                                    <td class="font-weight-bold">  {{ $property->contact_person != ''? $property->contact_person:$property->agent}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="EmailConfirmModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
                <div class="modal-content">
                    <!--Body-->
                    <div class="modal-body">
                        <div class="container">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>
                                <div class="m-3" style="font-size: 14px">Message sent successfully</div>
                                <div class="mb-2">Add email@aboutpakistan.com to your white list to get email from us.</div>
                                <button class="btn btn-success" data-dismiss="modal">Dismiss</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
</div>

