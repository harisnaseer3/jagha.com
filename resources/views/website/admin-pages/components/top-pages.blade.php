@foreach($top_pages as $index=>$page)
    <tr>
        <td>{{$index+1}}</td>
        <td>{{$page->type}}</td>
        <td><a class="breadcrumb-link" href=" {{url('/').$page->uri}}" target="_blank">{{$page->uri}}</a></td>
        <td>{{$page->count_sum}}</td>

    </tr>
@endforeach
