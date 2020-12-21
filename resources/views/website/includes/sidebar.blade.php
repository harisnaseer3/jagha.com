<div class="card" id="sidebar-property-management">
    @php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
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
                    @foreach(['active', 'edited', 'pending', 'expired', 'deleted', 'rejected','sold'] as $status)
                        <div class="card-header {{ $params['status'] === $status ? 'secondary-grey' : '' }}" id="headingListing{{ ucfirst($status) }}">
                            <a href="#collapseListing{{ ucfirst($status) }}" class="{{ $params['status'] === $status ? '' : 'collapsed' }} {{ $params['status'] === $status ? 'text-white' : '' }}"
                               role="button" data-toggle="collapse" aria-expanded="{{ $params['status'] === $status ? 'true' : 'false' }}" aria-controls="collapseExample">{{ ucfirst($status) }}
                                ({{ $counts[$status]['all'] == null ? 0 : $counts[$status]['all']}})</a>
                        </div>
                        <div id="collapseListing{{ ucfirst($status) }}" class="collapse {{ $params['status'] === $status ? 'show' : '' }}" aria-labelledby="headingListing{{ ucfirst($status) }}"
                             data-parent="#accordionListings">
                            <?php $route_params = ['status' => $status, 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 10]; ?>
                            <div class="nav flex-column nav-pills" id="listings-tab" role="tablist" aria-orientation="vertical">
                                @if (\Illuminate\Support\Facades\Request::segment($listings_segment_index) === 'listings' && $params['status'] === $status)
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'all' ? 'active' : '' }}" id="listings-all-tab"
                                       href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'all'])) }}" role="tab"
                                       aria-controls="listings-all" aria-selected="{{ $params['purpose'] === 'all' ? 'true' : 'false' }}">All Listings</a>
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'sale' ? 'active' : '' }}" id="listings-sale-tab"
                                       href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'sale'])) }}" role="tab"
                                       aria-controls="listings-sale" aria-selected="{{ $params['purpose'] === 'sale' ? 'true' : 'false' }}">For Sale ({{ $counts[$status]['sale'] == null ? 0:$counts[$status]['sale']}})</a>
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'rent' ? 'active' : '' }}" id="listings-rent-tab"
                                       href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'rent'])) }}" role="tab"
                                       aria-controls="listings-rent" aria-selected="{{ $params['purpose'] === 'rent' ? 'true' : 'false' }}">For Rent ({{ $counts[$status]['rent']  == null ? 0:$counts[$status]['rent']}})</a>
                                    <a class="nav-link side-link-style {{ $params['purpose'] === 'wanted' ? 'active' : '' }}" id="listings-wanted-tab"
                                       href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'wanted'])) }}"
                                       role="tab"
                                       aria-controls="listings-wanted" aria-selected="{{ $params['purpose'] === 'wanted' ? 'true' : 'false' }}">Wanted ({{ $counts[$status]['wanted']  == null ? 0:$counts[$status]['wanted']  }})</a>
                                    @if ($status === 'active')
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'basic' ? 'active' : '' }}" id="listings-basic-tab"
                                           href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'basic'])) }}"
                                           role="tab"
                                           aria-controls="listings-basic" aria-selected="{{ $params['purpose'] === 'basic' ? 'true' : 'false' }}">Basic Listing ({{ $counts[$status]['basic']  == null ? 0:$counts[$status]['basic']}})
                                        </a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'bronze' ? 'active' : '' }}" id="listings-bronze-tab"
                                           href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'bronze'])) }}"
                                           role="tab"
                                           aria-controls="listings-bronze" aria-selected="{{ $params['purpose'] === 'bronze' ? 'true' : 'false' }}">Bronze Listing ({{ $counts[$status]['bronze']  == null ? 0:$counts[$status]['bronze'] }})
                                        </a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'silver' ? 'active' : '' }}" id="listings-silver-tab"
                                           href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'silver'])) }}"
                                           role="tab"
                                           aria-controls="listings-silver" aria-selected="{{ $params['purpose'] === 'silver' ? 'true' : 'false' }}">Silver Listing ({{ $counts[$status]['silver']  == null ? 0:$counts[$status]['silver']  }})
                                        </a>

                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'golden' ? 'active' : '' }}" id="listings-golden-tab"
                                           href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'golden'])) }}"
                                           role="tab"
                                           aria-controls="listings-golden" aria-selected="{{ $params['purpose'] === 'golden' ? 'true' : 'false' }}">Golden Listing ({{ $counts[$status]['golden']  == null ? 0: $counts[$status]['golden']  }})
                                        </a>
                                        <a class="nav-link side-link-style {{ $params['purpose'] === 'platinum' ? 'active' : '' }}" id="listings-platinum-tab"
                                           href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'platinum'])) }}"
                                           role="tab"
                                           aria-controls="listings-platinum" aria-selected="{{ $params['purpose'] === 'platinum' ? 'true' : 'false' }}">Platinum Listing
                                            ({{ $counts[$status]['platinum']  == null ? 0 :$counts[$status]['platinum'] }})
                                        </a>

                                    @endif
                                @else
                                    <?php $route_params = ['status' => $status, 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 10]; ?>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'all'])) }}">All Listings</a>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'sale'])) }}">For Sale
                                        ({{ $counts[$status]['sale']  == null ? 0:$counts[$status]['sale'] }})</a>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'rent'])) }}">For Rent
                                        ({{ $counts[$status]['rent']  == null ? 0: $counts[$status]['rent']}})</a>
                                    <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'wanted'])) }}">Wanted
                                        ({{ $counts[$status]['wanted'] == null ? 0:  $counts[$status]['wanted']}})</a>
                                    @if ($status === 'active')
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'basic'])) }}">Basic Listing
                                            ({{ $counts[$status]['basic']  == null ? 0:$counts[$status]['basic']  }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'bronze'])) }}">Bronze Listing
                                            ({{ $counts[$status]['bronze']  == null ? 0:$counts[$status]['bronze'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'silver'])) }}">Silver Listing
                                            ({{ $counts[$status]['silver']  == null ? 0:$counts[$status]['silver'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'golden'])) }}">Golden Listing
                                            ({{ $counts[$status]['golden']  == null ? 0:$counts[$status]['golden'] }})</a>
                                        <a class="nav-link side-link-style" href="{{ route('properties.listings', array_merge($route_params, ['purpose' => 'platinum'])) }}">Platinum Listing
                                            ({{ $counts[$status]['platinum']  == null ? 0:$counts[$status]['platinum'] }})</a>
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

{{--    <div class="card-header theme-grey text-white">Credit Expiry Log</div>--}}
{{--    <ul class="list-group">--}}
{{--        <li class="list-group-item {{ $current_route_name === 'user.logs' ? 'active' : '' }}"><a class="{{ $current_route_name === 'user.logs' ? 'text-white' : '' }}" href="{{route('user.logs')}}">View--}}
{{--                Log</a></li>--}}
{{--    </ul>--}}
</div>
