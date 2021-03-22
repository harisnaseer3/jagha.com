<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Manage Packages</div>
    <ul class="list-group">
        <li class="list-group-item  {{ $current_route_name === 'package.add.properties' ? 'active' : '' }}">
            <a href="{{route('package.add.properties', $package->id)}}" class="{{ $current_route_name === 'package.add.properties' ? 'text-white' : '' }}">
                Add Properties</a></li>
        <li class="list-group-item {{ $current_route_name === 'package.index' ? 'active' : '' }}"><a
                href="{{ route('package.index') }}" class="{{ $current_route_name === 'package.index' ? 'text-white' : '' }}">Package Listing </a></li>
    </ul>
</div>
