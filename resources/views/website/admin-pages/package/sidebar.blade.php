<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Manage Packages</div>
    <ul class="list-group">
{{--        <li class="list-group-item  {{ $current_route_name === 'package.create' ? 'active' : '' }}">--}}
{{--            <a href="{{ route('package.create') }}" class="{{ $current_route_name === 'package.create' ? 'text-white' : '' }}">Buy Packages</a></li>--}}
        <li class="list-group-item {{ $current_route_name === 'admin.package.index' ? 'active' : '' }}"><a
                href="{{ route('admin.package.index') }}" class="{{ $current_route_name === 'admin.package.index' ? 'text-white' : '' }}">Packages Listings</a></li>
        <li class="list-group-item {{ $current_route_name === 'admin.package.price.index' ? 'active' : '' }}"><a
                href="{{ route('admin.package.price.index') }}" class="{{ $current_route_name === 'admin.package.price.index' ? 'text-white' : '' }}">Packages Pricing</a></li>

        <li class="list-group-item {{ $current_route_name === 'admin.package.complementary' ? 'active' : '' }}"><a
                href="{{ route('admin.package.complementary') }}" class="{{ $current_route_name === 'admin.package.complementary' ? 'text-white' : '' }}">Complementary Package</a></li>

    </ul>
</div>
