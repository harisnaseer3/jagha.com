<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Manage Packages</div>
    <ul class="list-group">
{{--        <li class="list-group-item  {{ $current_route_name === 'package.create' ? 'active' : '' }}">--}}
{{--            <a href="{{ route('package.create') }}" class="{{ $current_route_name === 'package.create' ? 'text-white' : '' }}">Buy Packages</a></li>--}}
        <li class="list-group-item {{ $current_route_name === 'admin.package.index' ? 'active' : '' }}"><a
                href="{{ route('admin.package.index') }}" class="{{ $current_route_name === 'admin.package.index' ? 'text-white' : '' }}">Packages Listings</a></li>

    </ul>
</div>
