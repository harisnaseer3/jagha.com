@foreach($package_log as $index=> $package)
    <tr>
        <td>{{$index + 1}}</td>
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
            {{ (new \Illuminate\Support\Carbon($package['activation']))->isoFormat('DD-MM-YYYY, h:mm a') }}
        </td>
        <td>
            <button class="btn btn-sm btn-primary mb-1 form-history-btn" data-attr="{{$package['id']}}">Show Details</button>
        </td>
    </tr>
@endforeach
