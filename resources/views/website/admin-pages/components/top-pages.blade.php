@foreach($top_pages as $index=>$page)
    <tr>
        <td>{{$index+1}}</td>
        <td>{{$page->uri}}</td>
        <td>{{$page->uri}}</td>
        <td>{{$page->count_sum}}</td>

    </tr>
@endforeach
