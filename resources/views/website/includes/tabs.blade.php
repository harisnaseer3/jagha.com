@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
<ul class="nav nav-tabs portfolio-tabs" id="portfolioTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false" style="border-radius: 0">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ in_array($current_route_name, ['properties.create', 'properties.edit', 'properties.listings']) ? 'active' : '' }}" id="property_management-tab" href="{{route('properties.create')}}" role="tab"
           aria-selected="{{ in_array($current_route_name, ['properties.create', 'properties.edit', 'properties.listings']) ? 'true' : 'false' }}" style="border-radius: 0">Property Management</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="message_center-tab" data-toggle="tab" href="#message_center" role="tab" aria-controls="message_center" aria-selected="false" style="border-radius: 0">Message Center</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ in_array($current_route_name, ['users.edit', 'agencies.edit','user_roles.edit','settings.edit','password.edit','agencies.create']) ? 'active' : '' }}" id="account_profile-tab" href="{{route('users.edit', ['user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()])}}" role="tab"
           aria-selected="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'users.edit' ? 'true' : 'false' }}" style="border-radius: 0">My Accounts &amp; Profiles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="reports-tab" data-toggle="tab" href="#reports" role="tab" aria-controls="reports" aria-selected="false" style="border-radius: 0">Reports</a>
    </li>
    @if(Auth::user()->hasRole('Admin'))
    <li class="nav-item">
        <?php $route_params = ['status' => 'verified_agencies', 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(), 'sort' => 'id', 'order' => 'asc', 'page' => 10]; ?>
        <a class="nav-link {{ in_array($current_route_name, ['agencies.listings']) ? 'active' : '' }}" id="agency_staff-tab" href="{{route('agencies.listings', array_merge($route_params, ['purpose' => 'all']))}}" role="tab"
           aria-selected="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'agencies.listing' ? 'true' : 'false' }}" style="border-radius: 0">Agency Listing</a>
    </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" id="clients_leads-tab" data-toggle="tab" href="#clients_leads" role="tab" aria-controls="clients_leads" aria-selected="false" style="border-radius: 0">Clients &amp; Leads</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="agency_website-tab" data-toggle="tab" href="#agency_website" role="tab" aria-controls="agency_website" aria-selected="false" style="border-radius: 0">Agency Website</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="advertise-tab" data-toggle="tab" href="#advertise" role="tab" aria-controls="advertise" aria-selected="false" style="border-radius: 0">Advertise</a>
    </li>
</ul>
