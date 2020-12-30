<section class="wow fadeIn animated counters" style="visibility: visible; animation-name: fadeIn;">
    <div class="container">
        <div class="row">
        <div class="col-md-3 col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\sale-count.png')}}" alt="properties sale count" aria-label="properties to sale"></i>
            <span id="anim-number-pizza" class="counter-number"></span>
            <span class="timer counter alt-font appear" data-to="{{$total_count->sale_property_count}}" data-speed="2000">
                {{$total_count->sale_property_count}}</span>
                <p class="counter-title">Properties For Sale</p>
            </div> <!-- end counter -->
            <!-- counter -->
            <div class="col-md-3  col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\rental-count.png')}}" alt="properties rental count" aria-label="properties to rent"></i> <span id="anim-number-pizza" class="counter-number"></span> <span class="timer counter alt-font appear" data-to="{{$total_count->rent_property_count}}" data-speed="2000">{{$total_count->rent_property_count}}</span>
                <p class="counter-title">Properties For Rent</p>
            </div> <!-- end counter -->
            <!-- counter -->
            <div class="col-md-3  col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="400ms" style="visibility: visible; animation-duration: 600ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\handshake.png')}}" alt="" aria-label="partners count"></i> <span class="timer counter alt-font appear" data-to="{{$total_count->agency_count}}" data-speed="2000">{{$total_count->agency_count}}</span> <p class="counter-title">Partners</p> </div> <!-- end counter -->
            <!-- counter -->
            <div class="col-md-3  col-sm-6 bottom-margin-small text-center counter-section wow fadeInUp xs-margin-bottom-ten animated" data-wow-duration="900ms" style="visibility: visible; animation-duration: 900ms; animation-name: fadeInUp;"> <i class="medium-icon"><img  src="{{asset('img\apartment.png')}}" alt="cities count" aria-label="cities"></i> <span class="timer counter alt-font appear" data-to="{{$total_count->city_count}}" data-speed="2000">{{$total_count->city_count}}</span> <p class="counter-title">Cities</p> </div> <!-- end counter -->

        </div>
    </div>
</section>
