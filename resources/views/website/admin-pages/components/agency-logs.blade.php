@foreach($agency_log as $agency)
    <tr>
        <td>{{$agency->id}}</td>
        <td>{{$agency->admin_id}}</td>
        <td>{{ucwords($agency->admin_name)}}</td>
        <td>{{$agency->agency_id}}</td>
        <td>{{$agency->agency_title}}</td>
        <td>{{ucwords($agency->status)}}</td>
        <td>{{$agency->rejection_reason}}</td>
        <td>{{ (new \Illuminate\Support\Carbon($agency->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
    </tr>
@endforeach
