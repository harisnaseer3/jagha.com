<div class="card mb-3">
    {{--        {{dd($agency_detail)}}--}}
    <div class="card-header bg-white">
        <h2 class="pull-left all-cities-header title">{{ucwords($agency_detail['title'])}}</h2>
        <span class="btn btn-sm btn-outline pull-right clickable" id="close-icon" data-effect="fadeOut">close</span>
    </div>

    <div class="card-body" id="locations-card">
        <div class="row">
            <div class="col-sm-12">
                <span class="float-left color-blue">Total Properties: {{$agency_detail->count}}</span>
                <span class="float-right color-blue">Partner Since: {{ (new \Illuminate\Support\Carbon($agency_detail->created_at))->diffForHumans(['parts' => 2]) }}</span>
                <br>
                <div class="property-description" style="line-height: 1.5rem; font-size: 14px;">{{$agency_detail->description}}</div>
            </div>
        </div>
    </div>
</div>
