<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
            <span class="heading-icon"><i class="fa fa-th-list"></i></span>
            <span class="title-name text-transform">Partners List</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <select class="record-limit">
                <option value="15" {{request()->query('limit') === '15'  ? 'selected' : '' }}>15 Records</option>
                <option value="30" {{request()->query('limit') === '30'  ? 'selected' : '' }}>30 Records</option>
                <option value="45" {{request()->query('limit') === '45'  ? 'selected' : '' }}>45 Records</option>
                <option value="60" {{request()->query('limit') === '60'  ? 'selected' : '' }}>60 Records</option>
            </select>
            <select class="sorting">
                <option value="newest" {{ request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest</option>
            </select>
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
            <div class="col-lg-4 col-md-4 col-pad">
                <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}" class="agency-logo" title="{{$agency->title}}">
                    <img src="{{ isset($agency->logo)? asset('thumbnails/agency_logos/'.explode('.',$agency->logo)[0].'-450x350.webp'): asset("/img/logo/dummy-logo.png")}}" alt="{{$agency->title}}"
                         title="{{$agency->title}}" onerror="this.src='{{asset("/img/logo/dummy-logo.png")}}'" class="d-block ml-auto mr-auto w-50 mt-5 mb-5" aria-label="Listing photo">
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-pad">
                <div class="detail">
                    <h2 class="title">
                        <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}" title="{{$agency->title}}">
                            {{$agency->title}}
                        </a>
                        <div class="pull-right" style="font-size: 1rem">
                            @if(isset($agency->status) & $agency->status === 'verified')
                                <span style="color:green" data-toggle="tooltip" data-placement="top"
                                      title="{{$agency->title}} is our verified partner. To become our trusted partner, simply contact us or call us at +92 51 4862317 OR +92 301 5993190">
                                    <i class="far fa-shield-check"></i>
                                </span>
                            @endif
                            @if(isset($agency->featured_listing) && $agency->featured_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> FEATURED PARTNER</span></span></span>
                            @endif
                            @if(isset($agency->key_listing) && $agency->key_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00"><i class="fas fa-star"></i><span class="color-white"> KEY PARTNER</span></span></span>
                            @endif
                        </div>
                    </h2>
                    <h5 class="location mb-2">
                        <span><a href="{{route('city.wise.partners',['agency'=>explode('-', request()->segment(1))[0],'city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
                                 aria-label="Agency location" title="{{$agency->title}}">
                                <i class="flaticon-location"></i>{{$agency->city}}</a>
                        </span>
                        @if( $agency->agent != '')
                            <span class="m-2">|</span>
                            <span><a><i class="fa fa-user"></i><span class="m-1"> {{$agency->agent}}</span></a></span>
                        @endif
                    </h5>
                    <div class="row">
                        @if($agency->count != null)
                            <div class="col-md-4 color-blue">
                                <span class="color-blue">Total Properties:</span> {{ $agency->count }}
                            </div>
                        @endif
                        <div class="col-md-8 color-blue">
                            <span class="color-blue">Partner Since: </span>{{ (new \Illuminate\Support\Carbon($agency->created_at))->diffForHumans(['parts' => 2]) }}
                        </div>
                    </div>

                    <div class="row call-email-container contact-container">
                        {{ Form::hidden('phone',$agency->phone, array_merge(['class'=>'number']))}}

                        @if(!empty($agency))
                            {{ Form::hidden('agent',$agency->id)}}
                        @endif
                        @if($agency->description !='')
                            <div class="col-sm-12 my-2">
                                <a href="javascript:void(0)" title="{{$agency->title}}" class="custom-font text-transform">
                                    <h6 class="custom-font text-transform agent-description">{{\Illuminate\Support\Str::limit(strtolower($agency->description), 300, $end='...')}}
                                        @if(strlen($agency->description) > 300 )
                                            <span class="hover-color" data-toggle="popover" data-trigger="hover" title="{{$agency->title}}" data-content="{{$agency->description}}"> More </span> @endif
                                    </h6>
                                </a>
                            </div>
                            <div class="col-sm-6 p-1"><a class="btn btn-block btn-call mb-1" data-toggle="modal" data-target="{{'#CallModelCenter'.$agency->id}}" aria-label="Call">Call</a></div>
                            @if($agency->email !== null)
                                <div class="col-sm-6 p-1"><a class="btn btn-block  mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
                            @else
                                <div class="col-sm-6 p-1" data-toggle="tooltip" data-placement="top" data-html="true" title="<div>Currently not available</div>"><a
                                        class="btn btn-block  mb-1 btn-email disabled" aria-label="Email">Email</a></div>
                            @endif                        @else
                            <div class="col-sm-12 my-2 agency-description-height">
                                <a href="javascript:void(0)" title="{{$agency->title}}" class="custom-font text-transform">
                                    <h6 class="custom-font text-transform agent-description">No Description Added..</h6>
                                </a>
                            </div>
                            <div class="col-sm-6 p-1"><a class="btn btn-block  mb-1 btn-call" data-toggle="modal" data-target="{{'#CallModelCenter'.$agency->id}}" aria-label="Call">Call</a></div>
                            @if($agency->email !== null)
                                <div class="col-sm-6 p-1"><a class="btn btn-block  mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
                            @else
                                <div class="col-sm-6 p-1" data-toggle="tooltip" data-placement="top" data-html="true" title="<div>Currently not available</div>"><a
                                        class="btn btn-block  mb-1 btn-email disabled" aria-label="Email">Email</a></div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="{{'CallModelCenter'.$agency->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <div class="text-center mb-2">
                            <div class="mb-2 font-weight-bold title-font">{{ $agency->title }}</div>
                            <div class="mb-2">While calling please mention <a class="hover-color link-font" href="https://www.aboutpakistan.com/">https://www.aboutpakistan.com</a></div>

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
                                    <td class="font-weight-bold">{{$agency->phone}} </td>
                                @else
                                    <td class="font-weight-bold"> -</td>
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
@endforeach
