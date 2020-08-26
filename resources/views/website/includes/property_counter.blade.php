<div class="counters" style="background-color: white">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="media counter-box">
                    <div class="media-left">
                        <img src="img/property-icon.png">
{{--                        <i class="flaticon-tag"></i>--}}
                    </div>
                    <div class="media-body">
                    <h1 class="timer  counter Starting" data-to="{{$total_count[0]->property_count}}" data-speed="1500"></h1>
                     <h5 class="count-text">Properties</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="media counter-box">
                    <div class="media-left">
{{--                        <i class="flaticon-business"></i>--}}
                        <img src="img/partner-icon.png">

                    </div>
                    <div class="media-body">
                    <h1 class="timer counter Starting" data-to="{{$total_count[0]->agency_count}}" data-speed="1500"></h1>
                     <h5 class="count-text">Partners</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="media counter-box">
                    <div class="media-left">
{{--                        <i class="flaticon-people"></i>--}}
                        <img src="img/city-icon.png">
                    </div>
                    <div class="media-body">
                    <h1 class="timer counter Starting" data-to="{{$total_count[0]->city_count}}" data-speed="1500"></h1>
                     <h5 class="count-text">Cities</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
