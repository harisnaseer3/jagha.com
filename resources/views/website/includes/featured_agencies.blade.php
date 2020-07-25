<div class="featured-agencies">
    <div class="container content-area-12">
        <div class="main-title">
            <h2>Key Partners</h2></div>
        <!-- <div class="slider"></div> -->
        <div class="slick-slider-area" id="featured-agency-slider">
            <div class="row slick-carousel" id="feature-agency-row-1" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next" data-cycle-prev="slick-prev"
                 data-cycle-carousel-horizontal="true"
                 data-slick='{"slidesToShow": 3, "rows":4,"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}}, {"breakpoint": 768,"settings":{"slidesToShow": 2}}]}'>
                @foreach($key_agencies as $agency)
                    <div class="slick-slide-item" aria-label="key agency">
                    @if($agency->logo !== null)
                        <!-- <img src="{{asset('thumbnails/agency_logos/'.$agency->logo)}}" alt="{{$agency->title}}"   title='<div class="row p-2"><div class="col-md-12"><img class= "tool-image" src="{{asset("thumbnails/agency_logos/".$agency->logo)}}" alt="{{$agency->title}}"/><p class="color-white mb-2">{{$agency->title}}</p><p class="color-white"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i>{{implode(", ", json_decode($agency->city))}}</p><p class="color-white mb-2"><i class="fa fa-phone mr-2" aria-hidden="true"></i>{{$agency->phone}}</p></div></div>' data-toggle="tooltip" data-html="true" data-placement="top"  class="img-fluid featured-agency-image"
                                 style="height:53px; width: 53px ;"> -->
                            <div class="service-box">
                                <div class="row">
                                    <div class="col-12">
                                        <h4><a href="#">{{$agency->title}}</a></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{asset('thumbnails/agency_logos/'.$agency->logo)}}" alt="{{$agency->title}}" class="img-fluid featured-agency-image"
                                             style="height:53px; width: 60px ;">
                                    </div>
                                    <div class="col-9">
                                        <p><i class="fa fa-map-marker mr-2 mt-2 fa-2x" aria-hidden="true"></i>{{implode(", ", json_decode($agency->city))}}</p>
                                        <p>
                                            @if($agency->phone == null || preg_match('/\+92$/', $agency->phone))
                                            @else
                                                <i class="fa fa-phone mr-2 fa-2x" aria-hidden="true"></i>{{$agency->phone}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <img src="{{asset('storage/agency_logos/'.'img256by256_1588397752.jpg')}}" alt="{{$agency->title}}"
                                 title='<div class="row p-2"><div class="col-md-12"><p class="color-white mb-2">{{$agency->title}}</p><p class="color-white"> <i class="fa fa-map-marker mr-2" aria-hidden="true"></i>{{implode(", ", json_decode($agency->city))}}</p><p class="color-white mb-2"><i class="fa fa-phone mr-2" aria-hidden="true"></i>{{$agency->phone}}</p></div></div>'
                                 data-toggle="tooltip" data-html="true" data-placement="top" class="img-fluid featured-agency-image" style="height:53px; width: 53px ;">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="controls">
                <div class="slick-prev slick-arrow-buton top-style-prev" id="featured-agency-prev">
                    <i class="fas fa-angle-left"></i>
                </div>
                <div class="slick-next slick-arrow-buton top-style-next" id="featured-agency-next">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>
