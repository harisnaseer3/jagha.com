@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    @if ($current_route_name === 'properties.create')   <title> Post New Listing : Property Management Software By https://www.aboutpakistan.com</title>
    @elseif ($current_route_name === 'properties.edit') <title> Edit Listing : Property Management Software By https://www.aboutpakistan.com </title>
    @endif
@endsection

@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <style>
        .map-iframe {
            border: 0;
            height: inherit !important;
            width: 100%
        }
    </style>
@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
        @include('website.admin-pages.includes.admin-nav')
        <!-- Top header start -->
            <div style="min-height:90px"></div>
            <!-- Submit Property start -->
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" id="portfolioTabContent">
                                <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.includes.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            @include('website.admin-pages.property_management')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('plugins/intl-tel-input/js/intlTelInput.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/script-modal-features.js')}}"></script>
    @if(isset($property))
        <script src="{{asset('website/js/admin-portfolio.js')}}"></script>
    @else
        <script src="{{asset('website/js/admin-create-portfolio.js')}}"></script>
    @endif
@endsection



@if(isset($property) && $property->location->is_active == 0)
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places" async defer></script>
    <script>
        (function ($) {
            let map;
            let service;
            var infowindow;
            var get_location;
            let container = $('#property_map');
            var latitude = container.data('lat');
            var longitude = container.data('lng');

            function initMap(value) {
                map = '';
                service = '';
                _markers = [];
                // let place;
                // if (value === 'school') place = 'school college and university';
                // else if (value === 'park') place = 'park';
                // else if (value === 'hospital') place = 'hospital, medical center and  Naval Hospital'
                // else if (value === 'restaurant') place = 'restaurant and cafe'
                get_location = new google.maps.LatLng(latitude, longitude);
                infowindow = new google.maps.InfoWindow();
                map = new google.maps.Map(
                    document.getElementById(value), {center: get_location, zoom: 15});
                var request = {
                    location: get_location,
                    radius: '500',
                    // query: place,
                };
                service = new google.maps.places.PlacesService(map);
                service.textSearch(request, callback);

                function callback(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        for (let i = 0; i < results.length; i++) {
                            createMarker(results[i], value);
                        }
                        // const markerCluster = new MarkerClusterer(map, _markers,
                        //     {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                    }
                }
            }

            function createMarker(place, value) {
                var marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location,
                    icon: {url: '../website/img/marker/' + value + '.png', scaledSize: new google.maps.Size(45, 45)},
                });
                _markers.push(marker);
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.setContent(place.name);
                    infowindow.open(map, this);
                });
            }
        })
        (jQuery);

    </script>
@endsection
@endif


