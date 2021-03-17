@foreach($property_log as $property)
    <tr>
        <td>{{$property->id}}</td>
        <td>{{$property->admin_id}}</td>
        <td>{{ucwords($property->admin_name)}}</td>
        <td>{{$property->property_id}}</td>
        <td>{{$property->property_title}}</td>
        <td>@if($property->status == 'active') Activated @else {{ucwords($property->status)}} @endif</td>
        <td>{{$property->rejection_reason}}</td>
        <td>{{ (new \Illuminate\Support\Carbon($property->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
    </tr>
@endforeach
