@if(count($users) === 0)
    <tr>
        <td colspan="6">No Users Found</td>
    </tr>
@else
    @foreach($users as $user)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$user->user_id}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->ip}}</td>
            <td>{{$user->ip_location}}</td>
            <td>{{$user->city}}</td>
            <td>{{$user->os}}</td>
            <td>{{$user->browser}}</td>
            <td>{{ (new \Illuminate\Support\Carbon($user->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>

            @if($user->logout_at !== null)
                <td>{{ (new \Illuminate\Support\Carbon($user->logout_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
            @elseif(now() > \Illuminate\Support\Carbon::parse($user->created_at)->addHours(2))
                <td><span class="badge-danger p-1">Session Expired</span></td>
            @else
                <td><span class="badge-success p-1">Connected</span></td>
            @endif
        </tr>
    @endforeach
@endif
