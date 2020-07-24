<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
            <span class="heading-icon"><i class="fa fa-th-list"></i></span>
            <span class="title-name">Properties List</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <select class="sorting">
                <option value="popular" {{ $params['sort']  === 'popular' || request()->query('sort') === 'popular'  ? 'selected' : '' }}>Popular</option>
                <option value="newest" {{ $params['sort'] === 'newest' || request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>
                <option value="high_price" {{ $params['sort'] === 'high_price' || request()->query('sort') === 'high_price' ? 'selected' : '' }}>Price (High To Low)</option>
                <option value="low_price" {{ $params['sort'] === 'low_price' || request()->query('sort') === 'low_price'? 'selected' : '' }}>Price (Low To High)</option>
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
                <a href="{{$property->property_detail_path()}}" class="property-img" title="{{$property->sub_type}} for {{$property->purpose}}">
                    <img src="{{ isset($property->image)? asset('thumbnails/properties/'.explode('.',$property->image)[0].'-450x350.webp'): asset("storage/properties/default-image.png")}}"
                         alt="{{$property->sub_type}} for {{$property->purpose}}"
                         title="{{$property->sub_type}} for {{$property->purpose}}" class="img-fluid" aria-label="Listing photo">
                    @if($property->premium_listing === 1)
                        <div class="listing-badges"><span aria-label="premium label" class="featured">Premium</span></div>
                    @elseif($property->super_hot_listing === 1)
                        <div class="listing-badges"><span aria-label="super hot label" class="featured">Super Hot</span></div>
                    @elseif($property->hot_listing  === 1)
                        <div class="listing-badges"><span aria-label="hot label" class="featured">Hot</span></div>
                    @endif
                    <div class="listing-time opening" aria-label="purpose label">For {{ $property->purpose }}</div>
                    <div class="price-ratings-box">
                        <p class="price">
                            <span class="color-white" aria-label="currency">PKR</span> <span class="color-white" aria-label="price"> {{ $property->price }}</span>
                        </p>
                        <div class="ratings stars" data-rating="{{$property->views > 0 ? (($property->favorites/$property->views)*5) : 0}}" data-num-stars="5" aria-label="rating"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-7 col-md-7 col-pad">
                <div class="detail">
                    <h2 class="title">
                        <a href="{{$property->property_detail_path()}}" title="{{$property->sub_type}} for {{$property->purpose}}">
                            <span aria-label="currency" class="font-16"> PKR </span>
                            <span aria-label="price"> {{Helper::getPriceInWords($property->price)}} </span>
                        </a>
                        <div class="pull-right" style="font-size: 1rem">
                            {{--                            <span style="color: red"><i class="fas fa-fire"></i></span>--}}
                            @if(isset($property->agency_status) && $property->agency_status === 'verified')
                                <span style="color:green"><i class="far fa-shield-check"></i></span>
                            @endif
                            @if(isset($property->featured_listing) && $property->featured_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> FEATURED</span></span>
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
                        @if($property->bedrooms > 0)
                            <li aria-label="bedrooms"><i class="flaticon-furniture"></i>
                                <span>{{ number_format($property->bedrooms) }} Beds</span>
                            </li>
                        @endif
                        @if($property->bathrooms > 0)
                            <li aria-label="baths"><i class="flaticon-holidays"></i>
                                <span>{{ number_format($property->bathrooms) }} Baths</span>
                            </li>
                        @endif
                        @if(isset($property->land_area))
                            <li aria-label="land area" style="width:50%;"><i class="fal fa-ruler-combined"></i>
                                <span> {{ number_format($property->land_area) }} @if($property->area_unit === 'Square Meters') Sq.M. @elseif($property->area_unit === 'Square Feet')
                                        Sq.F. @elseif ($property->area_unit === 'Square Yards') Sq.Yd. @else {{$property->area_unit}} @endif </span>
                            </li>
                        @endif
                    </ul>
                    <div class="row call-email-container contact-container">
                        {{ Form::hidden('phone',$property->cell, array_merge(['class'=>'number']))}}
                        {{ Form::hidden('reference',$property->reference)}}
                        @if(!empty($agency))
                            {{ Form::hidden('agent',$agency->id)}}
                        @else
                            {{ Form::hidden('property',$property->id)}}
                        @endif
                        <div class="col-sm-6 p-1"><a class="btn btn-block btn-outline-success mb-1" data-toggle="modal" data-target="#CallModelCenter" aria-label="Call">Call</a></div>
                        <div class="col-sm-6 p-1"><a class="btn btn-block btn-success mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
                    </div>
                </div>
                <div class="footer clearfix">
                    <div class="pull-left days">
                        <a><i class="fa fa-user"></i> {{ $property->contact_person != ''? $property->contact_person: $property->agent }}</a>
                    </div>
                    <div class="pull-right">
                        <a aria-label="Listing creation date"><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($property->created_at))->diffForHumans() }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="CallModelCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
            <div class="modal-content" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">
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
                            <div> {{ $property->agency !== null ? $property->agency: '' }} </div>
                            <div>Please use property reference</div>
                            <div style="font-weight: bold"> {{ $property->reference }} </div>
                            <div>while calling us</div>
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
                                <td class="font-weight-bold">  {{ $property->contact_person != ''? \Illuminate\Support\Str::limit($property->contact_person, 20, $end='...')
                                    :\Illuminate\Support\Str::limit($property->agent, 20, $end='...') }}</td>
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
                <div class="modal-body" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">
                    <div class="container">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>
                            <div class="m-3" style="font-size: 14px">Message sent successfully</div>
                            <div class="mb-2">Add info@aboutpakistan.com to your white list to get email from us.</div>
                            <button class="btn btn-success" data-dismiss="modal">Dismiss</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach





