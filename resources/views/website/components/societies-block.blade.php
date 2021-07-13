@foreach($societies as $index=> $society)
    <tr>
        <td>{{$society->id}}</td>
        <td style="white-space:pre;word-wrap:break-word">{{$society->name}}</td>
        <td>{{$society->status}}</td>
        <td style="white-space:pre;word-wrap:break-word">{{$society->city}}</td>
        <td style="white-space:pre;word-wrap:break-word">{{$society->authority}}</td>
        <td>{{ $society->area}} Kanal(s)</td>
    </tr>
@endforeach
