@foreach($societies as $index=> $society)
    <tr>
        <td>{{$society->id}}</td>
        <td>{{$society->name}}</td>
        <td>{{$society->status}}</td>
        <td>{{$society->city}}</td>
        <td>{{$society->authority}}</td>
        <td>{{ $society->area}} Kanal(s)</td>
    </tr>
@endforeach
