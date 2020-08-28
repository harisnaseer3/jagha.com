<!-- <div class="counters" style="background-color: white"> -->
    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center">
                <div class="media counter-box">
                    <div class="media-left">
                        <img src="img/property-icon.png">
                    </div>
                    <div class="media-body">
                        <h1 class="timer  counter Starting" data-to="{{$total_count[0]->property_count}}" data-speed="1500"></h1>
                        <h5 class="count-text">Properties</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center">
                <div class="media counter-box">
                    <div class="media-left">
                        <img src="img/partner-icon.png">

                    </div>
                    <div class="media-body">
                        <h1 class="timer counter Starting" data-to="{{$total_count[0]->agency_count}}" data-speed="1500"></h1>
                        <h5 class="count-text">Partners</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center">
                <div class="media counter-box">
                    <div class="media-left">
                        <img src="img/city-icon.png">
                    </div>
                    <div class="media-body">
                        <h1 class="timer counter Starting" data-to="{{$total_count[0]->city_count}}" data-speed="1500"></h1>
                        <h5 class="count-text">Cities</h5>
                    </div>
                </div>
            </div>

        </div>
    </div> -->
<!-- </div> -->

<section class="wow fadeIn animated counters" style="visibility: visible; animation-name: fadeIn;">
    <div class="container">
        <div class="row">
{{--            {{dd($rent_property_count[0]->rent_property_count)}}--}}
        <div class="col-md-3 col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\sale-count.png')}}" alt="" aria-label="properties to sale"></i> <span id="anim-number-pizza" class="counter-number"></span> <span class="timer counter alt-font appear" data-to="{{$sale_property_count[0]->sale_property_count}}" data-speed="7000">{{$sale_property_count[0]->sale_property_count}}</span>
                <p class="counter-title">Properties To Sale</p>
            </div> <!-- end counter -->
            <!-- counter -->
            <div class="col-md-3  col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\rental-count.png')}}" alt="" aria-label="properties to rent"></i> <span id="anim-number-pizza" class="counter-number"></span> <span class="timer counter alt-font appear" data-to="{{$rent_property_count[0]->rent_property_count}}" data-speed="7000">{{$rent_property_count[0]->rent_property_count}}</span>
                <p class="counter-title">Properties To Rent</p>
            </div> <!-- end counter -->
            <!-- counter -->
            <div class="col-md-3  col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="600ms" style="visibility: visible; animation-duration: 600ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\handshake.png')}}" alt="" aria-label="partners"></i> <span class="timer counter alt-font appear" data-to="{{$total_count[0]->agency_count}}" data-speed="7000">{{$total_count[0]->agency_count}}</span> <p class="counter-title">Partners</p> </div> <!-- end counter -->
            <!-- counter -->
            <div class="col-md-3  col-sm-6 bottom-margin-small text-center counter-section wow fadeInUp xs-margin-bottom-ten animated" data-wow-duration="900ms" style="visibility: visible; animation-duration: 900ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\apartment.png')}}" alt="" aria-label="cities"></i> <span class="timer counter alt-font appear" data-to="{{$total_count[0]->city_count}}" data-speed="7000">{{$total_count[0]->city_count}}</span> <p class="counter-title">Cities</p> </div> <!-- end counter -->

        </div>
    </div>
</section>
