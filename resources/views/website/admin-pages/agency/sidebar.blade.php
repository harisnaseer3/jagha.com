<div class="card" id="sidebar-property-management">
    @php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName();
        $user_id = \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier();
        $agency_user  = App\Models\Agency::where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->count();
        $agency_id =(new \App\Models\Agency)->select('id')->where('user_id',\Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier())->pluck('id')->toArray();
    @endphp

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
                    {{--verified--}}
                    <div class="card-header {{ $params['status'] === 'verified_agencies' ? 'bg-secondary' : '' }}" id="headingListingVerifiedAgency">
                        <a href="#collapseListingVerifiedAgency"
                           class="{{ $params['status'] === 'verified_agencies' ? '' : 'collapsed' }} {{ $params['status'] === 'verified_agencies' ? 'text-white' : '' }}" role="button"
                           data-toggle="collapse" aria-expanded="{{ $params['status'] === 'verified_agencies' ? 'true' : 'false' }}" aria-controls="collapseExample">Verified
                            ({{ $counts['verified']['all'] }})</a>
                    </div>
                    <div id="collapseListingVerifiedAgency" class="collapse {{ $params['status'] === 'verified_agencies' ? 'show' : '' }}" aria-labelledby="headingListingVerifiedAgency"
                         data-parent="#accordionListings">
                        <div class="nav flex-column nav-pills" id="listings-tab" role="tablist" aria-orientation="vertical">
                            @if ($params['status'] === 'verified_agencies')
                                <a class="nav-link side-link-style {{ $params['purpose'] === 'all' ? 'active' : '' }}" id="listings-all-tab" data-toggle="pill" href="#listings-all" role="tab"
                                   aria-controls="listings-all" aria-selected="{{ $params['purpose'] === 'all' ? 'true' : 'false' }}">All Listings</a>
                                <a class="nav-link  side-link-style {{ $params['purpose'] === 'key' ? 'active' : '' }}" id="listings-key-tab" data-toggle="pill" href="#listings-key" role="tab"
                                   aria-controls="listings-key" aria-selected="{{ $params['purpose'] === 'key' ? 'true' : 'false' }}"> Key Agencies ({{ $counts['verified']['key']}})</a>
                                <a class="nav-link  side-link-style {{ $params['purpose'] === 'featured' ? 'active' : '' }}" id="listings-featured-tab" data-toggle="pill" href="#listings-featured"
                                   role="tab" aria-controls="listings-featured" aria-selected="{{ $params['purpose'] === 'featured' ? 'true' : 'false' }}">Featured Agencies
                                    ({{ $counts['verified']['featured']}})</a>
                            @else
                                <?php $route_params = ['status' => 'verified_agencies', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 50]; ?>
                                <a class="nav-link side-link-style" href="{{ route('admin.agencies.listings', array_merge($route_params, ['purpose' => 'all'])) }}">All Listings</a>
                                <a class="nav-link side-link-style" href="{{ route('admin.agencies.listings', array_merge($route_params, ['purpose' => 'key'])) }}">Key Agencies (0)</a>
                                <a class="nav-link side-link-style" href="{{ route('admin.agencies.listings', array_merge($route_params, ['purpose' => 'featured'])) }}">Featured Agencies (0)</a>
                            @endif
                        </div>
                    </div>

                    @foreach(['pending', 'expired', 'rejected', 'deleted'] as $status)
                        <div class="card-header {{ $params['status'] === $status.'_agencies' ? 'bg-secondary' : '' }}"
                             id="headingListing{{ucfirst($status)}}Agency">

                            @if ($params['status'] === $status.'_agencies')
                                <a href="#collapseListing{{ucfirst($status)}}Agency"
                                   class="{{ $params['status'] === $status.'_agency' ? '' : 'collapsed' }} {{ $params['status'] === $status.'_agencies' ? 'text-white' : '' }} {{ $params['purpose'] === 'all' ? 'active' : '' }}"
                                   role="button"
                                   aria-expanded="{{ $params['status'] === ucfirst($status).'Agency' ? 'true' : 'false' }}">
                                    {{ucfirst($status)}}({{ $counts[$status]['all'] }})
                                </a>
                            @else
                                <?php $route_params = ['status' => $status . '_agencies', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 50]; ?>
                                <a href="{{ route('admin.agencies.listings', array_merge($route_params, ['purpose' => 'all'])) }}"
                                   class="{{ $params['status'] === $status.'_agency' ? '' : 'collapsed' }} {{ $params['status'] === $status.'_agencies' ? 'text-white' : '' }}" role="button"
                                   aria-expanded="{{ $params['status'] === ucfirst($status).'Agency' ? 'true' : 'false' }}">
                                    {{ucfirst($status)}}({{ $counts[$status]['all'] }})
                                </a>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </li>
    </ul>
    <div class="card-header theme-grey text-white">Tools</div>
    <ul class="list-group">
        <li class="list-group-item {{ in_array($current_route_name, ['admin-agencies-create', 'admin-agencies-edit']) ? 'active' : '' }}"><a
                href="{{ route('admin-agencies-create') }}" class="{{ in_array($current_route_name, ['admin-agencies-create', 'admin-agencies-edit']) ? 'text-white' : '' }}">
                @if ($current_route_name === 'admin-agencies-edit') Edit Agency @else Add New Agency @endif</a></li>
    </ul>
</div>
