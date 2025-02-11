<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Manage Packages</div>
    <ul class="list-group">
        <li class="list-group-item transition-background {{ $current_route_name === 'package.create' ? 'active' : '' }}">
            <a href="{{ route('package.create') }}" class="{{ $current_route_name === 'package.create' ? 'color-green' : '' }}">Buy Package</a></li>
        <li class="list-group-item {{ $current_route_name === 'package.index' ? 'active' : '' }}"><a
                href="{{ route('package.index') }}" class="{{ $current_route_name === 'package.index' ? 'text-white' : '' }}">Package Listing</a></li>

    </ul>
</div>
