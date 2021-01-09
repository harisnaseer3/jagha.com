<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Manage Agency Staff</div>
    <ul class="list-group">
        <li class="list-group-item  {{ $current_route_name === 'agencies.staff' ? 'active' : '' }}"><a
                href="{{ route('agencies.staff') }}" class="{{ $current_route_name === 'agencies.staff' ? 'text-white' : '' }}">Listings</a></li>
        @php $agencies = Auth::guard('web')->user()->agencies->where('status','verified') @endphp
        @if(count($agencies) > 0)
        <li class="list-group-item {{ $current_route_name === 'agencies.add-staff' ? 'active' : '' }}"><a
                href="{{ route('agencies.add-staff') }}" class="{{ $current_route_name === 'agencies.add-staff' ? 'text-white' : '' }}">Add new Staff</a></li>
        @endif

    </ul>
</div>
