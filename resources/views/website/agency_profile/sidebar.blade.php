<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white">Tools</div>
    @php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName();
        $user_id = \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier();
        $agency_user  = App\Models\Agency::where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->count();
        $agency_id =(new \App\Models\Agency)->select('id')->where('user_id',\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())->pluck('id')->toArray();
    @endphp
    <ul class="list-group">
        @if(!empty($agency_id))
            <li class="list-group-item {{ $current_route_name === 'agencies.edit' ? 'active' : '' }}" style="display: {{$agency_user > 0 ? 'block':'none'}} ">
                <a href="{{ route('agencies.edit', ['agency' => $agency_id[0] ]) }}" class="{{ $current_route_name === 'agencies.edit' ? 'text-white' : '' }}">Agency Profile</a>
            </li>
        @else
            <li class="list-group-item {{ $current_route_name === 'agencies.create' ? 'active' : '' }}">
                <a href="{{ route('agencies.create') }}" class="{{ $current_route_name === 'agencies.create' ? 'text-white' : '' }}">Add Agency</a>
            </li>
        @endif
    </ul>
</div>
