
<div class="agency-properties detail-page-agency-properties" style="margin-top: 100px " data-val="{{$property->agency->id}}">
    <!-- Main title -->

    <div class="row agency-properties" style="margin-right: -5px;margin-left: -5px;">
        <h3 class="heading-2 display-data-2" style="display: none"> More Properties by {{$property->agency->title}}</h3>
        <div class="container-fluid">
            <div class="slick-slider-area">
                <div class="row slick-carousel" id="agency-properties-section"
                     data-slick='{"slidesToShow": 3, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
                </div>
                <div id="ajax-loader-properties" class="ajax-loader-2 mt-3" style="display: block"></div>
                <div class="slick-btn">
                    <div class="slick-prev slick-arrow-buton display-data" style="display: none">
                        <i class="fa fa-angle-left"></i>
                    </div>
                    <div class="slick-next slick-arrow-buton display-data" style="display: none">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
