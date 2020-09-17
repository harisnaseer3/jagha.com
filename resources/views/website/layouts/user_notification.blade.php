@foreach($notifications as $notification)
    <div>
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <div>
                Agency named <strong> {{$notification->data['name']}}</strong> wants to add you as an agent. Do you accept the invitation ?
                <a class="btn-accept btn-sm btn-success" data-id="{{$notification->id}}"
                   data-agency="{{$notification->data['id']}}"
                   data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                   href="javascript:void(0)">Accept</a>
                <a class="btn-reject btn-sm btn-danger" data-id="{{$notification->id}}" href="javascript:void(0)">Reject</a>
            </div>
        </div>
    </div>
@endforeach
