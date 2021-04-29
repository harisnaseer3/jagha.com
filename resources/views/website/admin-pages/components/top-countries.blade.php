@foreach($top_countries as $index=>$page)
    <tr>
        <td>{{$index+1}}</td>
        <td style="text-align: left;"><img src="{{asset('img/flags/'.$page['location'].'.png')}}" title="{{$page['location']}}" alt="{{$page['location']}}"></td>
        <td>{{$page['name']}}</td>
        <td>{{$page['number']}}</td>

    </tr>
@endforeach
