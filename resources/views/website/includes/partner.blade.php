<div class="partners">
    <div class="container">
        <div class="main-title">
            <h2><a class="hover-color" href="{{route('featured-partners',['sort'=>'newest'])}}" title="Featured Partners">Our Featured Partners</a></h2></div>
        <div class="slick-slider-area" id="agency-slider">
            <div class="row slick-carousel" id="featured-agencies-section" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next" data-cycle-prev="slick-prev"
                 data-cycle-carousel-horizontal="true"
                 data-slick='{"slidesToShow": 5, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 5}}, {"breakpoint": 768,"settings":{"slidesToShow": 3}}]}'>

                <!-- TODO: add loader -->
            </div>
            <div class="controls">
                <div class="slick-prev slick-arrow-buton" id="agency-prev">
                    <i class="fas fa-angle-left"></i>
                </div>
                <div class="slick-next slick-arrow-buton" id="agency-next">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        <div>
            <h2 id="middle-agency-name"></h2>
            <h5 class="pt-1" id="agency-phone"></h5>
            <h5 class="pt-1" id="sale-count"></h5>
        </div>

    </div>
</div>


