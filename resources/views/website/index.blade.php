@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('json-ld')
    <?php echo $localBusiness->toScript()  ?>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
	<meta name="facebook-domain-verification" content="s0pvft8wezz41p9826lxvw9nfwb8t3" />


@endsection
@section('content')

    @include('website.includes.nav')

    <!-- Video Popup Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Centering -->
            <div class="modal-content">
                <div class="modal-body text-center"> <!-- Center content -->

                    <!-- Embedded Video -->
                    <iframe id="video" class="embed-responsive-item" width="100%" height="400"
                            src="https://www.youtube.com/embed/EImSiv5PTwc?autoplay=1&mute=1&rel=0&modestbranding=1&playsinline=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            loading="lazy"
                            allowfullscreen>
                    </iframe>

                    <!-- Don't show again checkbox -->
                    <div class="mt-3">
                        <input type="checkbox" id="dontShowAgain">
                        <label for="dontShowAgain">Don't show me again</label>
                    </div>

                    <!-- Close Button -->
                    <button type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal" aria-label="Close">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Banner start -->
    <div class="container-fluid">
    @include('website.includes.index-page-banner')
    <!-- Search Section start -->
    @include('website.includes.index-search')

        <!-- Featured properties start -->
    @include('website.includes.property_counter')
    <!-- Featured properties start -->
    @include('website.includes.featured_properties')
    <!-- featured agencies -->
    @include('website.includes.partner')
    <!-- Key agencies -->
    @include('website.includes.featured_agencies')
    <!-- Most popular places start -->
        @include('website.includes.popular_places_listing')
        <div class="clearfix"></div>
        <!-- Blog start -->
        @include('website.includes.recent_blogs')
    </div>
    <!-- Footer start -->
    @include('website.includes.footer')
    <div class="fly-to-top back-to-top">
        <i class="fa fa-angle-up fa-3"></i>
        <span class="to-top-text">To Top</span>
    </div><!--fly-to-top-->
    <div class="fly-fade">
    </div><!--fly-fade-->
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/rangeslider.js')}}" defer></script>
    <script src="{{asset('website/js/popper.min.js')}}" defer></script>
    <script src="{{asset('website/js/index-page.js')}}" defer></script>
    <script src="{{asset('website/js/script-custom.js')}}" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let videoModal = new bootstrap.Modal(document.getElementById("videoModal"));
            let videoFrame = document.getElementById("video");

            // Show modal if user has not opted out
            if (!localStorage.getItem("hideVideoModal")) {
                videoModal.show();
            }

            // "Don't Show Again" checkbox
            document.getElementById("dontShowAgain").addEventListener("change", function () {
                if (this.checked) {
                    localStorage.setItem("hideVideoModal", "true");
                } else {
                    localStorage.removeItem("hideVideoModal");
                }
            });

            // Manually close modal if needed
            document.querySelector(".btn-danger").addEventListener("click", function () {
                videoModal.hide();
            });
        });

    </script>

@endsection
