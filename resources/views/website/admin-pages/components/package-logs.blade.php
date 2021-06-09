@foreach($package_log as  $package)
    <tr>
        <td>{{$package['id']}}</td>
        <td>{{$package['type']}}</td>
        <td>{{$package['cost']}}</td>
        <td>{{ucwords($package['status'])}}</td>
        <td>
            @if($package['is_complementary'] == 1)
                Yes
            @else
                No
            @endif

        </td>
        <td>
            {{ (new \Illuminate\Support\Carbon($package['activation']))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
    </tr>
@endforeach
