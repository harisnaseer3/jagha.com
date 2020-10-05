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
                                        {{--                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'super_hot_listing' ? 'active' : '' }}" id="listings-super_hot-tab" data-toggle="pill"--}}
                                        {{--                                           href="#listings-super_hot"--}}
                                        {{--                                           role="tab" aria-controls="listings-super_hot" aria-selected="{{ $params['purpose'] === 'super_hot' ? 'true' : 'false' }}">Super Hot Listing--}}
                                        {{--                                            ({{ $counts[$status]['super_hot'] }})</a>--}}
                                        {{--                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'hot_listing' ? 'active' : '' }}" id="listings-hot-tab" data-toggle="pill" href="#listings-hot"--}}
                                        {{--                                           role="tab"--}}
                                        {{--                                           aria-controls="listings-hot" aria-selected="{{ $params['purpose'] === 'hot' ? 'true' : 'false' }}">Hot Listing ({{ $counts[$status]['hot'] }})--}}
                                        {{--                                        </a>--}}
                                        {{--                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'basic_listing' ? 'active' : '' }}" id="listings-basic-tab" data-toggle="pill"--}}
                                        {{--                                           href="#listings-basic"--}}
                                        {{--                                           role="tab"--}}
                                        {{--                                           aria-controls="listings-basic" aria-selected="{{ $params['purpose'] === 'basic' ? 'true' : 'false' }}">Basic Listing ({{ $counts[$status]['basic'] }})--}}
                                        {{--                                        </a>--}}
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'basic_listing' ? 'active' : '' }}" id="listings-basic-tab" data-toggle="pill"
                                           href="#listings-basic"
                                           role="tab"
                                           aria-controls="listings-basic" aria-selected="{{ $params['purpose'] === 'basic' ? 'true' : 'false' }}">Basic Listing ({{ $counts[$status]['basic'] }})
                                        </a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'bronze_listing' ? 'active' : '' }}" id="listings-bronze-tab" data-toggle="pill"
                                           href="#listings-bronze"
                                           role="tab"
                                           aria-controls="listings-bronze" aria-selected="{{ $params['purpose'] === 'bronze' ? 'true' : 'false' }}">Bronze Listing ({{ $counts[$status]['bronze'] }})
                                        </a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'silver_listing' ? 'active' : '' }}" id="listings-silver-tab" data-toggle="pill"
                                           href="#listings-silver"
                                           role="tab"
                                           aria-controls="listings-silver" aria-selected="{{ $params['purpose'] === 'silver' ? 'true' : 'false' }}">Silver Listing ({{ $counts[$status]['silver'] }})
                                        </a>

                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'golden_listing' ? 'active' : '' }}" id="listings-golden-tab" data-toggle="pill"
                                           href="#listings-golden"
                                           role="tab"
                                           aria-controls="listings-golden" aria-selected="{{ $params['purpose'] === 'golden' ? 'true' : 'false' }}">Golden Listing ({{ $counts[$status]['golden'] }})
                                        </a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'platinum_listing' ? 'active' : '' }}" id="listings-platinum-tab" data-toggle="pill"
                                           href="#listings-platinum"
                                           role="tab"
                                           aria-controls="listings-platinum" aria-selected="{{ $params['purpose'] === 'platinum' ? 'true' : 'false' }}">Platinum Listing
                                            ({{ $counts[$status]['platinum'] }})
                                        </a>

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
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'basic_listing'])) }}">Basic Listing
                                            ({{ $counts[$status]['basic'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'bronze_listing'])) }}">Bronze Listing
                                            ({{ $counts[$status]['bronze'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'silver_listing'])) }}">Silver Listing
                                            ({{ $counts[$status]['silver'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'golden_listing'])) }}">Golden Listing
                                            ({{ $counts[$status]['golden'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'platinum_listing'])) }}">Platinum Listing
                                            ({{ $counts[$status]['platinum'] }})</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </li>
    </ul>

    <div class="card-header theme-grey text-white">Tools</div>
    <ul class="list-group">
        <!-- <li class="list-group-item"><a href="#">Inventory Search</a></li> -->
        <li class="list-group-item {{ in_array($current_route_name, ['properties.create', 'properties.edit']) ? 'active' : '' }}"><a
                href="{{ route('properties.create') }}" class="{{ in_array($current_route_name, ['properties.create', 'properties.edit']) ? 'text-white' : '' }}">
                @if ($current_route_name === 'properties.edit') Edit Advertisement @else Add New Advertisement @endif</a></li>
        <!-- <li class="list-group-item"><a href="#">Zone Details</a></li>
        <li class="list-group-item"><a href="#">Listing Policy</a></li> -->
    </ul>

    <div class="card-header theme-grey text-white">Credit Expiry Log</div>
    <ul class="list-group">
        <li class="list-group-item {{ $current_route_name === 'user.logs' ? 'active' : '' }}"><a class="{{ $current_route_name === 'user.logs' ? 'text-white' : '' }}" href="{{route('user.logs')}}">View
                Log</a></li>
    </ul>
</div>
