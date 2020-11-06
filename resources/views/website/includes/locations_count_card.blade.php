
<div class="card mb-3">
    <div class="card-header bg-white">
        <h2 class="pull-left all-cities-header title">{{ucwords($locations_data['type'])}} locations  for {{$locations_data['purpose']}} in {{$locations_data['city']}}</h2>
        <span class="btn btn-sm btn-outline pull-right clickable" id="close-icon" data-effect="fadeOut">close</span>
    </div>

    <div class="card-body" id="locations-card">
        <div class="row">
            @foreach($locations_data['count'] as $location)
                <div class="col-sm-6  mb-3">
                    <a href="{{route('sale.property.search',['sub_type' => lcfirst($location->property_sub_type),'city' => lcfirst($locations_data['city']),
                                                'purpose'=>lcfirst($locations_data['purpose']), 'sort'=>'newest','limit'=>15])}}"
                       class="breadcrumb-link">
                        {{$location->location_name}} ({{$location->property_count}})
                    </a>

                </div>
                @endforeach

        </div>
    </div>
</div>
