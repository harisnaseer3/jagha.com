@foreach($top_pages as $index=>$page)
    <tr>
        <td>{{$index+1}}</td>
        <td>{{$page->hits}}</td>
        <td>{{$page->flag}}</td>
        <td>{{$page->country}}</td>
        <td>{{$page->city}}</td>
        <td>{{$page->ip}}</td>
        <td>{{$page->agent}}</td>
        <td>{{$page->platfrom}}</td>
        <td>{{$page->version}}</td>

    </tr>
@endforeach
