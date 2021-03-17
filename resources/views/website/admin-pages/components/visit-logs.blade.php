@foreach($user_visit_log as $visit)
    <tr>
        <td>{{$visit->id}}</td>
        <td>{{$visit->ip}}</td>
        <td>{{$visit->ip_location}}</td>
        <td>{{$visit->date}}, {{ (new \Illuminate\Support\Carbon($visit->visit_time))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
        <td>{{$visit->count}}</td>
    </tr>
@endforeach
