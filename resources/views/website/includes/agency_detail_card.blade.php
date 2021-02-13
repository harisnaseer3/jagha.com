<div class="card mb-3">
    {{--        {{dd($agency_detail)}}--}}
    <div class="card-header bg-white">
        <h2 class="pull-left all-cities-header title">{{ ucwords($agency_detail['title'])}}</h2>
        <span class="btn btn-sm btn-outline pull-right clickable" id="close-icon" data-effect="fadeOut">close</span>
    </div>

    <div class="card-body" id="locations-card">
        <div class="row">
            {{--            <div class="col-sm-12">--}}
            @if($agency_property_count > 0)
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4"><span class="float-left property-title text-transform mb-2">Total Properties</span>
                        </div>
                        <div class="col-sm-8"><span class="float-left property-title text-transform mb-2">{{$agency_property_count}}</span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-sm-6">
                <div class="{{$agency_property_count > 0 ? 'float-right':'float-left'}} property-title text-transform mb-2">Partner
                    Since {{ (new \Illuminate\Support\Carbon($agency_detail->created_at))->diffForHumans(['parts' => 2]) }}</div>
            </div>
            {{--            </div>--}}
            @if(isset($agency_detail->cell) && $agency_detail->cell  !== '')
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4">
                            <span class="{{$agency_property_count > 0 ? 'float-left':'float-right'}} property-title text-transform mb-2">
                                Contact #
                            </span>
                        </div>
                        <div class="col-sm-8">
                             <span class="{{$agency_property_count > 0 ? 'float-left':'float-right'}} property-title text-transform mb-2">
                                {{str_replace('-','',$agency_detail->cell)}}
                            </span>
                        </div>
                    </div>

                </div>
            @endif

            <div class="col-sm-12">
                <div class="property-description" style="line-height: 1.5rem; font-size: 14px;">{{$agency_detail->user_id !== 1? $agency_detail->description : ''}}</div>
            </div>

        </div>
    </div>
</div>
