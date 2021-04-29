@foreach($sites as $index=>$page)
    <tr>
        <td>
            <img src="{{'https://www.google.com/s2/favicons?domain='. $page['domain']}}" width="16" height="16" alt="www.google.com" style="vertical-align: -3px;">
            <a href=" {{$page['domain']}}" title="Google">  {{$page['domain']}}</a><span class="wps-cursor-default wps-referring-widget-ip">{{$page['ip']}}</span>
        </td>
        <td>{{$page['number']}}</td>
    </tr>
@endforeach
