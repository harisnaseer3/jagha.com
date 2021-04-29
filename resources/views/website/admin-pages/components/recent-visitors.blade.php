@foreach($recent_visitors as $index=>$page)
    <tr>
        <td>
            <img src="{{asset('img/browser/'.$page['browser']['name'].'.png')}}" title="{{$page['browser']['name']}}" alt="{{$page['browser']['name']}}">

        </td>
        <td>
            <img src="{{asset('img/flags/'.$page['country']['location'].'.png')}}" title="{{$page['country']['name']}}" alt="{{$page['country']['name']}}">
        </td>
        <td>{{$page['city']}}</td>
        <td>{{$page['date']}}</td>
        <td>{{$page['ip']}}</td>
        <td>
            {!! $page['referred'] !!}
        </td>

    </tr>
@endforeach
