@foreach($notifications as $notification)
    <div>
        @if(isset($notification->data['status']))
            <div class="alert alert-block mark-as-read" style="background-color:  #ffe14d">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <div style="color: black;">
                    Status of Property having Reference <strong> {{$notification->data['title']}} </strong> has been changed to
                    <strong>{{ucwords($notification->data['status'])}}</strong> by the Admin.
                    <a class="btn-read btn-sm btn-outline-info mr-auto" href="javascript:void(0)"
                       data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                       data-id={{$notification->data['id']}}> Mark as read</a>
                </div>
            </div>
        @else
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
        @endif
    </div>
@endforeach
