<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
            <span class="heading-icon"><i class="fa fa-th-list"></i></span>
            <span class="title-name text-transform">Featured Agencies List</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            {{--            <select class="sorting">--}}
            {{--                --}}{{--                <option value="popular" {{ $params['sort']  === 'popular' || request()->query('sort') === 'popular'  ? 'selected' : '' }}>Popular</option>--}}
            {{--                <option value="newest" {{ $params['sort'] === 'newest' || request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>--}}
            {{--                <option value="high_price" {{ $params['sort'] === 'high_price' || request()->query('sort') === 'high_price' ? 'selected' : '' }}>Price (High To Low)</option>--}}
            {{--                <option value="low_price" {{ $params['sort'] === 'low_price' || request()->query('sort') === 'low_price'? 'selected' : '' }}>Price (Low To High)</option>--}}
            {{--            </select>--}}
            <a class="change-view-btn active-view-btn list-layout-btn" role="button" aria-label="List view"><i class="fa fa-th-list"></i></a>
            <a class="change-view-btn grid-layout-btn" role="button" aria-label="Grid view"><i class="fa fa-th-large"></i></a>
        </div>
    </div>
</div>

@if($agencies->isEmpty())
    <div> No results to show</div>
@endif
<!-- Property box 2 start -->
@foreach($agencies as $agency)
    <div class="property-box-2">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-pad">
                <a href="javascript:void(0)" class="agency-logo" title="{{$agency->title}}">
                    <img src="{{ isset($agency->logo)? asset('thumbnails/agency_logos/'.$agency->logo): asset("storage/properties/default-image.png")}}"
                         alt="{{$agency->title}}" title="{{$agency->title}}" class="img-fluid" aria-label="Listing photo">
                </a>
            </div>
            <div class="col-lg-7 col-md-7 col-pad">
                <div class="detail">
                    <h2 class="title">
                        <a href="javascript:void(0)" title="{{$agency->title}}">
                            {{$agency->title}}
                        </a>
                        <div class="pull-right" style="font-size: 1rem">
                            @if(isset($agency->status) &$agency->status === 'verified')
                                <span style="color:green"><i class="far fa-shield-check"></i></span>
                            @endif
                            @if(isset($agency->featured_listing) && $agency->featured_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> FEATURED</span></span>
                           </span>
                            @endif
                        </div>
                    </h2>
                    <h5 class="location mb-2">
                        <span><a aria-label="Listing location" title="{{$agency->title}}">
                            <i class="flaticon-location"></i>
                            {{implode(', ', json_decode($agency->city))}}
                            </a></span>
                        <span class="m-2">|</span>
                        <span> <a aria-label="Listing location" title="{{$agency->title}}">
                            <i class="fa fa-phone"></i>
                            {{$agency->phone}}
                           </a></span>
                    </h5>
                    <h5 class="location mb-2" ><a><i class="fa fa-user"></i><span class="m-1"> {{ $agency->agent != ''? $agency->agent: '' }}</span></a></h5>
                    <div class="row call-email-container contact-container">
                        {{ Form::hidden('phone',$agency->phone, array_merge(['class'=>'number']))}}
                        @if(!empty($agency))
                            {{ Form::hidden('agent',$agency->id)}}
                        @endif
                        <div class="col-sm-12">
                            <a href="javascript:void(0)" title="{{$agency->title}}" class="custom-font text-transform">
                                <h6 class="custom-font text-transform">{{\Illuminate\Support\Str::limit(strtolower($agency->description), 200, $end='...more')}}</h6>
                            </a>
                        </div>
                        <div class="col-sm-6 p-1"><a class="btn btn-block btn-outline-success mb-1" data-toggle="modal" data-target="#CallModelCenter" aria-label="Call">Call</a></div>
                        <div class="col-sm-6 p-1"><a class="btn btn-block btn-success mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
                    </div>
                </div>
{{--                <div class="footer clearfix">--}}
{{--                    <div class="pull-left days">--}}
{{--                        <a><i class="fa fa-user"></i> {{ $agency->agent != ''? $agency->agent: '' }}</a>--}}
{{--                    </div>--}}
{{--                    --}}{{--                    <div class="pull-right">--}}
{{--                    --}}{{--                        <a aria-label="Listing creation date"><i class="flaticon-time"></i> {{ (new \Illuminate\Support\Carbon($property->created_at))->diffForHumans() }}</a>--}}
{{--                    --}}{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    {{--    <div class="modal fade" id="CallModelCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">--}}
    {{--            <div class="modal-content" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">--}}
    {{--                <!--Header-->--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="myModalLabel">Contact Us</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">×</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <!--Body-->--}}
    {{--                <div class="modal-body">--}}
    {{--                    <div class="container" style="font-size: 12px; color: #555">--}}
    {{--                        <div class="text-center">--}}
    {{--                            <div> {{ $property->agency !== null ? $property->agency: '' }} </div>--}}
    {{--                            <div>Please use property reference</div>--}}
    {{--                            <div style="font-weight: bold"> {{ $property->reference }} </div>--}}
    {{--                            <div>while calling us</div>--}}
    {{--                        </div>--}}

    {{--                        <table class="table table-borderless">--}}
    {{--                            <tbody>--}}
    {{--                            <tr>--}}
    {{--                                <td class="w-30">Mobile</td>--}}
    {{--                                <td class="w-70 font-weight-bold">{{ $property->cell !== null  ? $property->cell: '-'}}</td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td>Phone No</td>--}}
    {{--                                @if($property->phone !== null)--}}
    {{--                                    <td class="font-weight-bold">{{$property->phone}}</td>--}}
    {{--                                @elseif($property->agency_phone !== null)--}}
    {{--                                    <td class="font-weight-bold">{{$property->phone}}</td>--}}
    {{--                                @else--}}
    {{--                                    <td class="font-weight-bold">-</td>--}}
    {{--                                @endif--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td>Agent</td>--}}
    {{--                                <td class="font-weight-bold">  {{ $property->contact_person != ''? \Illuminate\Support\Str::limit($property->contact_person, 20, $end='...')--}}
    {{--                                    :\Illuminate\Support\Str::limit($property->agent, 20, $end='...') }}</td>--}}
    {{--                            </tr>--}}
    {{--                            </tbody>--}}
    {{--                        </table>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="modal fade" id="EmailConfirmModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">--}}
    {{--            <div class="modal-content">--}}
    {{--                <!--Body-->--}}
    {{--                <div class="modal-body" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">--}}
    {{--                    <div class="container">--}}
    {{--                        <div class="text-center">--}}
    {{--                            <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>--}}
    {{--                            <div class="m-3" style="font-size: 14px">Message sent successfully</div>--}}
    {{--                            <div class="mb-2">Add info@aboutpakistan.com to your white list to get email from us.</div>--}}
    {{--                            <button class="btn btn-success" data-dismiss="modal">Dismiss</button>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endforeach





