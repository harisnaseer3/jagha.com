<div class="card" id="sidebar-property-management">
    <div class="card-header theme-grey text-white text-capitalize">Message Center</div>
    <ul class="list-group">
        <li class="list-group-item  {{ $current_route_name === 'message-center.inbox' ? 'active' : '' }}"><a
                href="{{ route('message-center.inbox') }}" class="{{ $current_route_name === 'message-center.inbox' ? 'text-white' : '' }}">Inbox</a></li>
            <li class="list-group-item {{ $current_route_name === 'message-center.sent' ? 'active' : '' }}"><a
                    href="{{ route('message-center.sent') }}" class="{{ $current_route_name === 'message-center.sent' ? 'text-white' : '' }}">Support & Inquiry Mails</a></li>
        <li class="list-group-item {{ $current_route_name === 'message-center.notifications' ? 'active' : '' }}"><a
                href="{{ route('message-center.notifications') }}" class="{{ $current_route_name === 'message-center.notifications' ? 'text-white' : '' }}">Notifications</a></li>

    </ul>
</div>
