@foreach($user_visit_log as $visit)
    <tr>
        <td>{{$visit->id}}</td>
        <td>{{$visit->ip}}</td>
        <td>{{$visit->ip_location}}</td>
        <td>{{ (new \Illuminate\Support\Carbon($visit->date))->isoFormat('DD-MM-YYYY') }}, {{ (new \Illuminate\Support\Carbon($visit->visit_time))->isoFormat('h:mm a') }}</td>
        <td>{{$visit->count}}</td>
    </tr>
@endforeach
