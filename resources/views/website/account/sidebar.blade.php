<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Profile & user settings</div>
    @php
        $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName();
        $user_id = \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier();
        $agency_user  = App\Models\Agency::where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->count();
        $agency_id =(new \App\Models\Agency)->select('id')->where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->pluck('id')->toArray();
    @endphp

    <ul class="list-group">
        <li class="list-group-item {{ $current_route_name === 'users.edit' ? 'active' : '' }}"><a
                href="{{ route('users.edit', ['user' => $user_id]) }}" class="{{ $current_route_name === 'users.edit' ? 'text-white' : '' }}">User Profile</a></li>
        <li class="list-group-item {{ $current_route_name === 'user_roles.edit' ? 'active' : '' }}"><a
                href="{{ route('user_roles.edit') }}" class="{{ $current_route_name === 'user_roles.edit' ? 'text-white' : '' }}">User Roles</a></li>
        <li class="list-group-item {{ $current_route_name === 'settings.edit' ? 'active' : '' }}"><a
                href="{{ route('settings.edit') }}" class="{{ $current_route_name === 'settings.edit' ? 'text-white' : '' }} text-capitalize">User & Communication Settings</a></li>
        <li class="list-group-item {{ $current_route_name === 'password.edit' ? 'active' : '' }}"><a
                href="{{ route('password.edit') }}" class="{{ $current_route_name === 'password.edit' ? 'text-white' : '' }}">Change Password</a></li>
{{--        @if(!empty($agency_id))--}}
{{--            <li class="list-group-item {{ $current_route_name === 'agencies.edit' ? 'active' : '' }}" style="display: {{$agency_user > 0 ? 'block':'none'}} ">--}}
{{--                <a href="{{ route('agencies.edit', ['agency' => $agency_id[0] ]) }}" class="{{ $current_route_name === 'agencies.edit' ? 'text-white' : '' }}">Agency Profile</a>--}}
{{--            </li>--}}
{{--        @else--}}
{{--            <li class="list-group-item {{ $current_route_name === 'agencies.create' ? 'active' : '' }}">--}}
{{--                <a href="{{ route('agencies.create') }}" class="{{ $current_route_name === 'agencies.create' ? 'text-white' : '' }}">Add Agency</a>--}}
{{--            </li>--}}
{{--        @endif--}}
    </ul>
</div>
