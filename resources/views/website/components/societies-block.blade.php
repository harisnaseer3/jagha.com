@foreach($societies as $index => $society)
    <tr>
        <td>{{$index + 1}}</td>
        <td>{{$society->name}}</td>
        <td>{{$society->status}}</td>
        <td>{{$society->city}}</td>
        <td>{{$society->authority}}</td>

        <td>{{ $society->area}}
            @if($society->authority == 'Punjab Housing & Town Planning Agency (PHATA)')
                Acre(s)
            @else
                Kanal(s)
            @endif


        </td>
    </tr>
@endforeach
