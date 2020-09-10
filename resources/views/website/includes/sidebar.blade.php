<div class="card" id="sidebar-property-management">
    @php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp

    {{--    <div class="card-header theme-grey text-white">Tools</div>--}}
    {{--    @php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp--}}
    {{--    <ul class="list-group">--}}
    {{--        <!-- <li class="list-group-item"><a href="#">Inventory Search</a></li> -->--}}
    {{--        <li class="list-group-item {{ in_array($current_route_name, ['properties.create', 'properties.edit']) ? 'active' : '' }}"><a--}}
    {{--                href="{{ route('properties.create') }}" class="{{ in_array($current_route_name, ['properties.create', 'properties.edit']) ? 'text-white' : '' }}">--}}
    {{--                @if ($current_route_name === 'properties.edit') Edit Listing @else Post New Listing @endif</a></li>--}}
    {{--        <!-- <li class="list-group-item"><a href="#">Zone Details</a></li>--}}
    {{--        <li class="list-group-item"><a href="#">Listing Policy</a></li> -->--}}
    {{--    </ul>--}}

    <div class="card-header theme-grey text-white">Listings</div>
    <ul class="list-group">
        <li>
            <div class="accordion" id="accordionListings">
                @php
                    $segments = \Illuminate\Support\Facades\Request::segments();
                    $listings_segment_index = 0;
                @endphp
                @for ($i = 0; $i < count($segments); $i++)
                    @if ($segments[$i] === 'listings')
                        @php $listings_segment_index = $i + 1; @endphp
                        @break
                    @endif
                @endfor
                @if (empty($params))
                    @php $params['status'] = ''; @endphp
                @endif
                <div class="card">
{{--                    @foreach(['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected','sold'] as $status)--}}
                    @foreach(['active', 'edited', 'pending', 'expired', 'deleted', 'rejected','sold'] as $status)
                        <div class="card-header {{ $params['status'] === $status ? 'secondary-grey' : '' }}" id="headingListing{{ ucfirst($status) }}">
                            <a href="#collapseListing{{ ucfirst($status) }}" class="{{ $params['status'] === $status ? '' : 'collapsed' }} {{ $params['status'] === $status ? 'text-white' : '' }}"
                               role="button" data-toggle="collapse" aria-expanded="{{ $params['status'] === $status ? 'true' : 'false' }}" aria-controls="collapseExample">{{ ucfirst($status) }}
                                ({{ $counts[$status]['all'] }})</a>
                        </div>
                        <div id="collapseListing{{ ucfirst($status) }}" class="collapse {{ $params['status'] === $status ? 'show' : '' }}" aria-labelledby="headingListing{{ ucfirst($status) }}"
                             data-parent="#accordionListings">
                            <div class="nav flex-column nav-pills" id="listings-tab" role="tablist" aria-orientation="vertical">
                                @if (\Illuminate\Support\Facades\Request::segment($listings_segment_index) === 'listings' && $params['status'] === $status)
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'all' ? 'active' : '' }}" id="listings-all-tab" data-toggle="pill" href="#listings-all" role="tab"
                                       aria-controls="listings-all" aria-selected="{{ $params['purpose'] === 'all' ? 'true' : 'false' }}">All Listings</a>
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'sale' ? 'active' : '' }}" id="listings-sale-tab" data-toggle="pill" href="#listings-sale" role="tab"
                                       aria-controls="listings-sale" aria-selected="{{ $params['purpose'] === 'sale' ? 'true' : 'false' }}">For Sale ({{ $counts[$status]['sale'] }})</a>
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'rent' ? 'active' : '' }}" id="listings-rent-tab" data-toggle="pill" href="#listings-rent" role="tab"
                                       aria-controls="listings-rent" aria-selected="{{ $params['purpose'] === 'rent' ? 'true' : 'false' }}">For Rent ({{ $counts[$status]['rent'] }})</a>
                                    <a class="nav-link side-link-style{{ $params['purpose'] === 'wanted' ? 'active' : '' }}" id="listings-wanted-tab" data-toggle="pill" href="#listings-wanted"
                                       role="tab"
                                       aria-controls="listings-wanted" aria-selected="{{ $params['purpose'] === 'wanted' ? 'true' : 'false' }}">Wanted ({{ $counts[$status]['wanted'] }})</a>
                                    @if ($status === 'active')
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'super_hot_listing' ? 'active' : '' }}" id="listings-super_hot-tab" data-toggle="pill"
                                           href="#listings-super_hot"
                                           role="tab" aria-controls="listings-super_hot" aria-selected="{{ $params['purpose'] === 'super_hot' ? 'true' : 'false' }}">Super Hot Listing
                                            ({{ $counts[$status]['super_hot'] }})</a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'hot_listing' ? 'active' : '' }}" id="listings-hot-tab" data-toggle="pill" href="#listings-hot"
                                           role="tab"
                                           aria-controls="listings-hot" aria-selected="{{ $params['purpose'] === 'hot' ? 'true' : 'false' }}">Hot Listing ({{ $counts[$status]['hot'] }})</a>
                                    <!-- <a class="nav-link side-link-style {{ $params['purpose'] === 'magazine_listing' ? 'active' : '' }}" id="listings-magazine-tab" data-toggle="pill" href="#listings-magazine"
                                           role="tab" aria-controls="listings-magazine" aria-selected="{{ $params['purpose'] === 'magazine' ? 'true' : 'false' }}">Magazine Listing
                                            ({{ $counts[$status]['magazine'] }})</a> -->
                                    @endif
                                @else
                                    <?php $route_params = ['status' => $status, 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 10]; ?>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'all'])) }}">All Listings</a>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'sale'])) }}">For Sale
                                        ({{ $counts[$status]['sale'] }})</a>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'rent'])) }}">For Rent
                                        ({{ $counts[$status]['rent'] }})</a>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'wanted'])) }}">Wanted
                                        ({{ $counts[$status]['wanted'] }})</a>
                                    @if ($status === 'active')
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'super_hot_listing'])) }}">Super Hot Listing
                                            ({{ $counts[$status]['super_hot'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'hot_listing'])) }}">Hot Listing
                                            ({{ $counts[$status]['hot'] }})</a>
                                    <!-- <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'magazine_listing'])) }}">Magazine Listing
                                            ({{ $counts[$status]['magazine'] }})</a> -->
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

{{--                    <div class="card-header {{ $params['status'] === 'rejected_images' ? 'secondary-grey' : '' }}" id="headingListingRejectedImages">--}}
{{--                        <a href="#collapseListingRejectedImages"--}}
{{--                           class="{{ $params['status'] === 'rejected_images' ? '' : 'collapsed' }} {{ $params['status'] === 'rejected_images' ? 'text-white' : '' }}" role="button"--}}
{{--                           data-toggle="collapse" aria-expanded="{{ $params['status'] === 'rejected_images' ? 'true' : 'false' }}" aria-controls="collapseExample">Rejected Images</a>--}}
{{--                    </div>--}}
{{--                    <div id="collapseListingRejectedImages" class="collapse {{ $params['status'] === 'rejected_images' ? 'show' : '' }}" aria-labelledby="headingListingRejectedImages"--}}
{{--                         data-parent="#accordionListings">--}}
{{--                        <div class="nav flex-column nav-pills" id="listings-tab" role="tablist" aria-orientation="vertical">--}}
{{--                            @if (\Illuminate\Support\Facades\Request::segment($listings_segment_index) === 'listings' && $params['status'] === 'rejected_images')--}}
{{--                                <a class="nav-link side-link-style {{ $params['purpose'] === 'all' ? 'active' : '' }}" id="listings-all-tab" data-toggle="pill" href="#listings-all" role="tab"--}}
{{--                                   aria-controls="listings-all" aria-selected="{{ $params['purpose'] === 'all' ? 'true' : 'false' }}">All Listings</a>--}}
{{--                                <a class="nav-link side-link-style {{ $params['purpose'] === 'sale' ? 'active' : '' }}" id="listings-sale-tab" data-toggle="pill" href="#listings-sale" role="tab"--}}
{{--                                   aria-controls="listings-sale" aria-selected="{{ $params['purpose'] === 'sale' ? 'true' : 'false' }}">For Sale (0)</a>--}}
{{--                                <a class="nav-link side-link-style {{ $params['purpose'] === 'rent' ? 'active' : '' }}" id="listings-rent-tab" data-toggle="pill" href="#listings-rent" role="tab"--}}
{{--                                   aria-controls="listings-rent" aria-selected="{{ $params['purpose'] === 'rent' ? 'true' : 'false' }}">For Rent (0)</a>--}}
{{--                                <a class="nav-link side-link-style {{ $params['purpose'] === 'wanted' ? 'active' : '' }}" id="listings-wanted-tab" data-toggle="pill" href="#listings-wanted" role="tab"--}}
{{--                                   aria-controls="listings-wanted" aria-selected="{{ $params['purpose'] === 'wanted' ? 'true' : 'false' }}">Wanted (0)</a>--}}
{{--                            @else--}}
{{--                                <?php $route_params = ['status' => 'rejected_images', 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 10]; ?>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'all'])) }}">All Listings</a>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'sale'])) }}">For Sale (0)</a>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'rent'])) }}">For Rent (0)</a>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'wanted'])) }}">Wanted (0)</a>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{----}}
{{--                    <div class="card-header {{ $params['status'] === 'rejected_videos' ? 'secondary-grey' : '' }}" id="headingListingRejectedVideos">--}}
{{--                        <a href="#collapseListingRejectedVideos"--}}
{{--                           class="{{ $params['status'] === 'rejected_videos' ? '' : 'collapsed' }} {{ $params['status'] === 'rejected_videos' ? 'text-white' : '' }}" role="button"--}}
{{--                           data-toggle="collapse" aria-expanded="{{ $params['status'] === 'rejected_videos' ? 'true' : 'false' }}" aria-controls="collapseExample">Rejected Videos</a>--}}
{{--                    </div>--}}
{{--                    <div id="collapseListingRejectedVideos" class="collapse {{ $params['status'] === 'rejected_videos' ? 'show' : '' }}" aria-labelledby="headingListingRejectedVideos"--}}
{{--                         data-parent="#accordionListings">--}}
{{--                        <div class="nav flex-column nav-pills" id="listings-tab" role="tablist" aria-orientation="vertical">--}}
{{--                            @if (\Illuminate\Support\Facades\Request::segment($listings_segment_index) === 'listings' && $params['status'] === 'rejected_videos')--}}
{{--                                <a class="nav-link side-link-style {{ $params['purpose'] === 'all' ? 'active' : '' }}" id="listings-all-tab" data-toggle="pill" href="#listings-all" role="tab"--}}
{{--                                   aria-controls="listings-all" aria-selected="{{ $params['purpose'] === 'all' ? 'true' : 'false' }}">All Listings</a>--}}
{{--                                <a class="nav-link side-link-style{{ $params['purpose'] === 'sale' ? 'active' : '' }}" id="listings-sale-tab" data-toggle="pill" href="#listings-sale" role="tab"--}}
{{--                                   aria-controls="listings-sale" aria-selected="{{ $params['purpose'] === 'sale' ? 'true' : 'false' }}">For Sale (0)</a>--}}
{{--                                <a class="nav-link side-link-style {{ $params['purpose'] === 'rent' ? 'active' : '' }}" id="listings-rent-tab" data-toggle="pill" href="#listings-rent" role="tab"--}}
{{--                                   aria-controls="listings-rent" aria-selected="{{ $params['purpose'] === 'rent' ? 'true' : 'false' }}">For Rent (0)</a>--}}
{{--                                <a class="nav-link side-link-style{{ $params['purpose'] === 'wanted' ? 'active' : '' }}" id="listings-wanted-tab" data-toggle="pill" href="#listings-wanted" role="tab"--}}
{{--                                   aria-controls="listings-wanted" aria-selected="{{ $params['purpose'] === 'wanted' ? 'true' : 'false' }}">Wanted (0)</a>--}}
{{--                            @else--}}
{{--                                <?php $route_params = ['status' => 'rejected_videos', 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 10]; ?>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'all'])) }}">All Listings</a>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'sale'])) }}">For Sale (0)</a>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'rent'])) }}">For Rent (0)</a>--}}
{{--                                <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'wanted'])) }}">Wanted (0)</a>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
            </div>
        </li>
    </ul>

    <div class="card-header theme-grey text-white">Tools</div>
    <ul class="list-group">
        <!-- <li class="list-group-item"><a href="#">Inventory Search</a></li> -->
        <li class="list-group-item {{ in_array($current_route_name, ['properties.create', 'properties.edit']) ? 'active' : '' }}"><a
                href="{{ route('properties.create') }}" class="{{ in_array($current_route_name, ['properties.create', 'properties.edit']) ? 'text-white' : '' }}">
                @if ($current_route_name === 'properties.edit') Edit Listing @else Post New Listing @endif</a></li>
        <!-- <li class="list-group-item"><a href="#">Zone Details</a></li>
        <li class="list-group-item"><a href="#">Listing Policy</a></li> -->
    </ul>

    <div class="card-header theme-grey text-white">Credit Expiry Log</div>
    <ul class="list-group">
        <li class="list-group-item {{ $current_route_name === 'user.logs' ? 'active' : '' }}"><a  class="{{ $current_route_name === 'user.logs' ? 'text-white' : '' }}" href="{{route('user.logs')}}">View Log</a></li>
    </ul>
</div>
