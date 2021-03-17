@if(count($register_users) === 0)
    <tr>
        <td colspan="6">No Users Found</td>
    </tr>
@else
    @foreach($register_users as $user)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->community_nick}}</td>
            <td>{{$user->email}}</td>
            <td>{{str_replace('-','',$user->cell)}}</td>
            <td>{{$user->country}}</td>
            <td>{{$user->address}}</td>


            <td>@if($user->is_active === '1') Active @else Inactive @endif</td>
            <td>

                {!! Form::open(['route' => ['admins.destroy-user', $user->id], 'method' => 'delete']) !!}
                @if($user->is_active === '0')
                    <div class='btn-group'>
                        {!! Form::button('Activate', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'onclick' => 'return confirm("'.__('Are you sure you want to activate user account?').'")']) !!}
                    </div>
                @elseif($user->is_active === '1')
                    <div class='btn-group'>
                        {!! Form::button('Deactivate', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("'.__('Are you sure you want to deactivate user account?').'")']) !!}
                    </div>
                @endif
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
@endif
