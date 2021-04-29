@foreach($top_visitors as $index=>$page)
    <tr>
        <td>{{$index+1}}</td>
        <td>
            {{$page['hits']}}
        </td>
        <td style="text-align: left;">
            <img src="{{asset('img/flags/'.$page['country']['location'].'.png')}}" title="{{$page['country']['name']}}" alt="{{$page['country']['name']}}">
        </td>

        <td>
            {{$page['country']['name']}}
        </td>
        <td>
            {{$page['city']}}
        </td>
        <td>
            {{$page['ip']}}
        </td>
        <td>
            {{$page['agent']}}
        </td>
        <td>
            {{$page['platform']}}
        </td>
        <td>
            {{$page['version']}}
        </td>

    </tr>
@endforeach
