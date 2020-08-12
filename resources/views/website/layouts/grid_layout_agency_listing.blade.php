<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
            <span class="heading-icon"><i class="fa fa-th-large"></i></span>
            <span class="title-name text-transform">Agencies Grid</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <a class="change-view-btn list-layout-btn" role="button" aria-label="List view"><i class="fa fa-th-list"></i></a>
            <a class="change-view-btn active-view-btn grid-layout-btn" role="button" aria-label="Grid view"><i class="fa fa-th-large"></i></a>
        </div>
    </div>
</div>
@if($agencies->isEmpty())
    <div> No results to show</div>
@endif
<!-- Property section start -->
<div class="row property-section">
    @foreach($agencies as $agency)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="property-box">
                <div class="property-thumbnail">
                    <a href="javascript:void(0)" class="agency-img" title="{{$agency->title}}">
                        <div class="listing-badges pull-right">
                            @if(isset($agency->status) &$agency->status === 'verified')
                                <span style="color:green"><i class="far fa-shield-check"></i></span>
                            @endif
                            @if(isset($agency->featured_listing) && $agency->featured_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> FEATURED</span></span>
                           </span>
                            @endif
                        </div>
                        <img src="{{ isset($agency->logo)? asset('thumbnails/agency_logos/'.explode('.',$agency->logo)[0].'-450x350.webp'): asset("/img/logo/dummy-logo.png")}}"
                             alt="{{$agency->title}}" title="{{$agency->title}}" class="img-fluid" aria-label="Listing photo">
                    </a>
                </div>
                <div class="detail">
                    <h2 class="title" style="height:25px">
                        <a href="javascript:void(0)" title="{{$agency->title}}">
                            {{$agency->title}}
                        </a>
                    </h2>
                    <div class="location mt-4">
                        <a href="javascript:void(0)" aria-label="Agency location">
                            <i class="fa fa-map-marker"></i>
                            {{implode(', ', json_decode($agency->city))}}
                        </a>
                    </div>
                </div>
                <div class="row contact-container" style="padding: 0 20px;">
                    {{ Form::hidden('phone',$agency->phone, array_merge(['class'=>'number']))}}
                    @if(!empty($agency))
                        {{ Form::hidden('agent',$agency->id)}}
                    @endif
                    <div class="col-sm-6 p-1"><a class="btn btn-block btn-call mb-1" data-toggle="modal" data-target="{{'#CallModel2'.$agency->id}}" aria-label="Call">Call</a>
                    </div>
                    <div class="col-sm-6 p-1"><a class="btn btn-block  mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{'CallModel2'.$agency->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <div class="container color-555 font-12">
                            <div class="text-center">
                                <div> {{ $agency->title }} </div>
                            </div>
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td class="w-30">Mobile</td>
                                    <td class="w-70 font-weight-bold">{{ $agency->cell !== null  ? $agency->cell: '-'}}</td>
                                </tr>
                                <tr>
                                    <td>Phone No</td>
                                    @if($agency->phone !== null)
                                        <td class="font-weight-bold">{{$agency->phone}}</td>
                                    @else
                                        <td class="font-weight-bold">-</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Agent</td>
                                    <td class="font-weight-bold"> {{ $agency->agent != ''? $agency->agent:'-'}}</td>
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

