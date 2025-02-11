<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">My Account Settings</div>
    @php
        $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName();
        $user_id = \Illuminate\Support\Facades\Auth::guard('web')->user()->getAuthIdentifier();
        $agency_user  = App\Models\Agency::where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->count();
        $agency_id =(new \App\Models\Agency)->select('id')->where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->pluck('id')->toArray();
    @endphp

    <ul class="list-group">
{{--        <li class="list-group-item {{ $current_route_name === 'users.edit' ? 'active' : '' }}"><a--}}
{{--                href="{{ route('users.edit', ['user' => $user_id]) }}" class="{{ $current_route_name === 'users.edit' ? 'text-white' : '' }}">Current User Profile</a></li>--}}
        <li class="list-group-item transition-background {{ $current_route_name === 'account.wallet' ? 'active' : '' }}"><a
                href="{{ route('account.wallet') }}" class="{{ $current_route_name === 'account.wallet' ? 'color-green' : '' }}">My Wallet</a></li>
{{--        <li class="list-group-item {{ $current_route_name === 'user_roles.edit' ? 'active' : '' }}"><a--}}
{{--                href="{{ route('user_roles.edit') }}" class="{{ $current_route_name === 'user_roles.edit' ? 'text-white' : '' }}">Current User Role</a></li>--}}
{{--        <li class="list-group-item {{ $current_route_name === 'settings.edit' ? 'active' : '' }}"><a--}}
{{--                href="{{ route('settings.edit') }}" class="{{ $current_route_name === 'settings.edit' ? 'text-white' : '' }} text-capitalize">User & Communication Settings</a></li>--}}
{{--        <li class="list-group-item {{ $current_route_name === 'password.edit' ? 'active' : '' }}"><a--}}
{{--                href="{{ route('password.edit') }}" class="{{ $current_route_name === 'password.edit' ? 'text-white' : '' }}">Change Current Password</a></li>--}}
    </ul>
</div>
