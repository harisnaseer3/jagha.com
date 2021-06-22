@if($data !== null)

    @forelse($data as $all_listing)
        <tr>
            <td>
                <a type="button" target="_blank"
                   href="{{$all_listing['link']}}"
                   data-toggle-1="tooltip"
                   data-placement="bottom" title="View Property">
                    <span>{{ $all_listing['id'] }}</span>
                </a>

            </td>
            <td>{{ $all_listing['duration']}}</td>
            <td>
                <div>
                    {{ (new \Illuminate\Support\Carbon($all_listing['activation']))->isoFormat('DD-MM-YYYY  h:mm a') }}
                </div>
            </td>
            <td>
                <div>
                    {{ (new \Illuminate\Support\Carbon($all_listing['expire']))->isoFormat('DD-MM-YYYY  h:mm a') }}
                </div>

                <div class="badge badge-success p-2">
                    @if(str_contains ( (new \Illuminate\Support\Carbon($all_listing['expire']))->diffForHumans(['parts' => 1]), 'ago' ))
                        <strong
                            class="color-white font-12">
                            Expired {{(new \Illuminate\Support\Carbon($all_listing['expire']))->diffForHumans(['parts' => 1])}}</strong>
                    @else
                        <strong
                            class="color-white font-12"> Expire
                            in {{(new \Illuminate\Support\Carbon($all_listing['expire']))->diffForHumans(['parts' => 1])}}</strong>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="12" class="p-4 text-center">No Listings Found!</td>
        </tr>
    @endforelse
@endif
