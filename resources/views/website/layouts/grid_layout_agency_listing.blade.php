<!-- Option bar start -->
<div class="option-bar">
    <div class="float-left">
        <h4>
            {{--            <span class="heading-icon"><i class="fa fa-th-large"></i></span>--}}
            <span class="title-name ml-2 text-transform">Partners Grid</span>
        </h4>
    </div>
    <div class="float-right cod-pad">
        <div class="sorting-options" role="button" aria-label="sort by filter">
            <select class="record-limit none-992">
                <option value="15" {{request()->query('limit') === '15'  ? 'selected' : '' }}>15 Records</option>
                <option value="30" {{request()->query('limit') === '30'  ? 'selected' : '' }}>30 Records</option>
                <option value="45" {{request()->query('limit') === '45'  ? 'selected' : '' }}>45 Records</option>
                <option value="60" {{request()->query('limit') === '60'  ? 'selected' : '' }}>60 Records</option>
            </select>
            <select class="sorting">
                <option value="newest" {{ request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest</option>
            </select>
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
                <div class="property-thumbnail image-padding">
                    <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}" class="agency-img" title="{{$agency->title}}">
                        <div class="listing-badges pull-right">
                            @if(isset($agency->status) &$agency->status === 'verified')
                                <span style="color:green" data-toggle="tooltip" data-placement="top"
                                      title="{{$agency->title}} is our verified partner. To become our trusted partner, simply contact us or call us at +92 51 4862317 OR +92 315 5141959"><i
                                        class="far fa-shield-check"></i></span>

                            @endif
                            @if(isset($agency->featured_listing) && $agency->featured_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> FEATURED PARTNER</span></span>
                           </span>
                            @endif
                            @if(isset($agency->key_listing) && $agency->key_listing === 1)
                                <span class="premium-badge">
                               <span style="color:#ffcc00 ;"><i class="fas fa-star"></i><span class="color-white"> KEY PARTNER</span></span>
                           </span>
                            @endif
                        </div>
                        <img
                            src="{{ isset($agency->logo)&& $agency->user_id !== 1? asset('thumbnails/agency_logos/'.explode('.',$agency->logo)[0].'-450x350.webp'): asset("/img/logo/dummy-logo.png")}}"
                            alt="{{$agency->title}}" title="{{$agency->title}}" class="img-fluid" aria-label="Listing photo" onerror="this.src='{{asset("/img/logo/dummy-logo.png")}}'">
                    </a>
                </div>
                <div class="detail">
                    <h2 class="title" style="height:25px">
                        <a href="{{route('agents.ads.listing',
                                            [ 'city'=>strtolower(Str::slug($agency->city)),
                                               'slug'=>\Illuminate\Support\Str::slug($agency->title),
                                               'agency'=> $agency->id ,
                                               ])}}" title="{{$agency->title}}">
                            {{$agency->title}}
                        </a>
                    </h2>
                    <div class="location mt-4">
                        <a href="{{route('city.wise.partners',['agency'=>explode('-', request()->segment(1))[0],'city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
                           aria-label="Agency location">
                            <i class="fa fa-map-marker"></i>
                            {{$agency->city}}
                        </a>z
                    </div>
                    <div class="color-555 mt-2 date-box"><span>Total Properties: </span> {{ $agency->count }}</div>
                    {{--                    <div class="color-555 mt-2 date-box"><span>Added on: </span> {{ Carbon\Carbon::parse($agency->created_at)->format('d.m.Y') }}</div>--}}
                    <div class="color-555 mt-2 date-box"><span>Partner Since: </span>{{ (new \Illuminate\Support\Carbon($agency->created_at))->diffForHumans(['parts' => 2]) }}</div>
                </div>
                <div class="row contact-container" style="padding: 0 20px;">
                    {{ Form::hidden('phone',$agency->phone, array_merge(['class'=>'number']))}}
                    @if(!empty($agency))
                        {{ Form::hidden('agent',$agency->id)}}
                    @endif
                    <div class="col-sm-6 p-1"><a class="btn btn-block btn-call mb-1" data-toggle="modal" data-target="{{'#CallModel2'.$agency->id}}" aria-label="Call">Call</a>
                    </div>
                    @if($agency->email !== null)
                        <div class="col-sm-6 p-1"><a class="btn btn-block  mb-1 btn-email" data-toggle="modal" data-target="#EmailModelCenter" aria-label="Email">Email</a></div>
                    @else
                        <div class="col-sm-6 p-1" data-toggle="tooltip" data-placement="top" data-html="true" title="<div>Currently not available</div>"><a
                                class="btn btn-block  mb-1 btn-email disabled" aria-label="Email">Email</a></div>

                    @endif
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
                        <div class="container" style="font-size: 12px; color: #555">
                            <div class="text-center mb-2">
                                <div class="mb-2 font-weight-bold title-font">{{ $agency->title }}</div>
                                <div class="mb-2">While calling please mention <a class="hover-color link-font" href="https://www.aboutpakistan.com/">https://www.aboutpakistan.com</a></div>

                            </div>
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td class="w-30">Mobile</td>
                                    @if(isset($agency->cell) && $agency->cell !== '')
                                        <td class="w-70 font-weight-bold">{{ $agency->cell}}  {{isset($agency->optional_number) ? ' ,'.$agency->optional_number: ''}}</td>
                                    @else
                                        <td class="font-weight-bold"> -</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Phone No</td>

                                    @if(isset($agency->phone) && $agency->phone !== '')
                                        <td class="font-weight-bold">{{$agency->phone}}</td>
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
</div>

