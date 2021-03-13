@foreach($admin_log as $admin)
    <tr>
        <td>{{$admin->id}}</td>
        <td>{{$admin->admin_id}}</td>
        <td>{{$admin->email}}</td>
        <td>{{$admin->ip}}</td>
        <td>{{$admin->ip_location}}</td>
        <td>{{$admin->os}}</td>
        <td>{{$admin->browser}}</td>
        <td>{{ (new \Illuminate\Support\Carbon($admin->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
        @if($admin->logout_at !== null)
            <td>{{(new \Illuminate\Support\Carbon($admin->logout_at))->isoFormat('DD-MM-YYYY, h:mm a')  }}</td>

        @elseif(now() > \Illuminate\Support\Carbon::parse($admin->created_at)->addHours(2))
            <td><span class="badge-danger p-1">Session Expired</span></td>
        @else
            <td><span class="badge-success p-1">Connected</span></td>
        @endif
    </tr>
@endforeach
