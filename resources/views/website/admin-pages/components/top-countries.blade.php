@foreach($top_pages as $index=>$page)
    <tr>
        <td>{{$index+1}}</td>
        <td>{{$page->flag}}</td>
        <td>{{$page->country}}</td>
        <td>{{$page->visitor_count}}</td>

    </tr>
@endforeach
