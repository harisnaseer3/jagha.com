@foreach($notifications as $notification)
    <div>
        @if(isset($notification->data['type']) && $notification->data['type'] === 'property')
            <div class="alert alert-block" style="background-color:  #FCF3CF">
                <button type="button" class="close" data-dismiss="alert">×</button>

                <div style="color: black;">
                    <span>Status of Property ID = <strong> {{$notification->data['id']}} </strong> having Reference <strong> {{$notification->data['reference']}} </strong>
                    has been changed to <strong>{{ucwords($notification->data['status'])}}</strong>.</span>

                    <span><a class="btn-read btn-sm btn-outline-info  pull-right mr-2 mark-as-read font-weight-bolder" href="javascript:void(0)"
                             data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                             data-id={{$notification->data['id']}}>Mark as read</a></span>

                </div>
            </div>
        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'agency')
            <div class="alert alert-block" style="background-color:  #FCF3CF">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <div style="color: black;">
                    <div class="row">
                        <div class="col-md-8 mt-2">
                               <span>Status of Agency ID = <strong> {{$notification->data['id']}} </strong> named <strong> {{$notification->data['title']}} </strong> has been changed to
                        <strong>{{ucwords($notification->data['status'])}}</strong>.</span>

                        </div>
                        <div class="col-md-4">
                            <a class=" btn-sm btn btn-primary pull-right mr-2 mark-as-read" href="javascript:void(0)"
                               data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                               data-id={{$notification->data['id']}}> Mark as read</a>

                        </div>

                    </div>


                </div>
            </div>
        @else
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <div><span>
                        Agency named <strong> {{$notification->data['name']}}</strong> wants to add you as an agent. Do you accept the invitation ?</span>
                    <span><a class="btn-accept btn-sm btn-success" data-id="{{$notification->id}}"
                             data-agency="{{$notification->data['id']}}"
                             data-user="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}"
                             href="javascript:void(0)">Accept</a></span>
                    <span><a class="btn-reject btn-sm btn-danger" data-id="{{$notification->id}}" href="javascript:void(0)">Reject</a></span>
                </div>
            </div>
        @endif
    </div>
@endforeach
