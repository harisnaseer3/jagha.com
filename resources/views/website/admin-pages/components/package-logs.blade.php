@foreach($package_log as $package)
    <tr>
        <td>{{$package->id}}</td>
        <td>{{ucwords((new \App\Models\Admin)->getAdminById($package->admin_id)->name)}}</td>
        <td>{{$package->type}}</td>
        <td>{{$package->package_for}}</td>
        <td>{{$package->duration}}</td>
        <td>{{$package->property_count}}</td>
        <td>{{ucwords($package->status)}}</td>
        <td>{{$package->activated_at}}</td>
        <td>{{$package->rejection_reason}}</td>
        <td>{{ (new \Illuminate\Support\Carbon($package->created_at))->isoFormat('DD-MM-YYYY, h:mm a') }}</td>
    </tr>
@endforeach
