<div class="featured-properties content-area-12">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h2><a href="{{route('featured',['sort'=>'newest', 'limit'=>15])}}" title="Check out famous of all properties">Popular Properties</a></h2>
        </div>
        <div id="ajax-loader-properties" class="ajax-loader"></div>
        <div class="slick-slider-area" aria-label="popular properties">
            <div class="row slick-carousel" id="featured-properties-section"
                 data-slick='{"slidesToShow": 4, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
            </div>
            <div class="slick-btn">
                <div class="slick-prev slick-arrow-buton">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div class="slick-next slick-arrow-buton">
                    <i class="fa fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>
