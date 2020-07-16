<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="font-size: 14px">
    <li class="nav-item active">
        <a class="nav-link  active" id="pills-location-tab" data-toggle="pill" href="#pills-location" role="tab" aria-controls="pills-location" aria-selected="true">Location</a>
    </li>
    <li class="nav-item map-canvas" data-value="school">
        <a class="nav-link" id="pills-school-tab" data-toggle="pill" href="#pills-school" role="tab" aria-controls="pills-school" aria-selected="false">Schools</a>
    </li>
    <li class="nav-item map-canvas" data-value="restaurant">
        <a class="nav-link" id="pills-restaurant-tab" data-toggle="pill" href="#pills-restaurant" role="tab" aria-controls="pills-restaurant" aria-selected="false">Restaurants</a>
    </li>
    <li class="nav-item map-canvas" data-value="hospital">
        <a class="nav-link" id="pills-hospital-tab" data-toggle="pill" href="#pills-hospital" role="tab" aria-controls="pills-hospital" aria-selected="false">Hospitals</a>
    </li>
    <li class="nav-item map-canvas" data-value="park">
        <a class="nav-link" id="pills-park-tab" data-toggle="pill" href="#pills-park" role="tab" aria-controls="pills-park" aria-selected="false">Parks</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-location" role="tabpanel" aria-labelledby="pills-location-tab">
        <div class="map">
            <div class="contact-map">
                <iframe
                    height="400px"
                    width="auto"
                    style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?&amp;zoom=15&amp;q={{$property->latitude}},{{$property->longitude}}&amp;key={{env('GOOGLE_API_KEY')}}"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-school" role="tabpanel" aria-labelledby="pills-school-tab">
        <div class="map">
            <div class="contact-map">
                <div id="school" data-lat="{{$property->latitude}}" data-lng="{{$property->longitude}}" style="height: 450px; width: auto"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-restaurant" role="tabpanel" aria-labelledby="pills-restaurant-tab">
        <div class="map">
            <div class="contact-map">
                <div id="restaurant" style="height: 450px; width: auto"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-hospital" role="tabpanel" aria-labelledby="pills-hospital-tab">
        <div class="map">
            <div class="contact-map">
                <div id="hospital" style="height: 450px; width: auto"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-park" role="tabpanel" aria-labelledby="pills-park-tab">
        <div class="map">
            <div class="contact-map">
                <div id="park" style="height: 450px; width: auto"></div>
            </div>
        </div>
    </div>
</div>
