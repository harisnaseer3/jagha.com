@if(isset($locations_data))
    @if($locations_data['count']->isNotEmpty())
        <div class="card mb-3">
            <div class="card-header bg-white">
                <h2 class="pull-left all-cities-header title">{{ucwords($locations_data['type'])}} locations for {{$locations_data['purpose']}} in {{$locations_data['city']}}</h2>
                <span class="btn btn-sm btn-outline pull-right clickable" id="close-icon" data-effect="fadeOut">close</span>
            </div>

            <div class="card-body" id="locations-card">
                <div class="row">
                    @foreach($locations_data['count'] as $location)
                        <div class="col-sm-6  mb-3">
                            <a href="{{route('search.houses.plots',['type'=>lcfirst($locations_data['type']),'city' => lcfirst($locations_data['city']), 'location'=> str_replace(' ', '-',str_replace('-','_',$location->location_name)), 'sort'=>'newest','limit'=>15])}}"
                               class="breadcrumb-link">
                                {{ \Illuminate\Support\Str::limit($location->location_name , 40, $end='...')}} ({{$location->property_count}})
                            </a>
                        </div>
                    @endforeach
                    <div class="col-sm-12 text-center color-blue">
                        <a class="color-blue" href="{{route('all.locations',['type'=>$locations_data['type'],'purpose'=>$locations_data['purpose'],'city'=>$locations_data['city']])}}">
                            View All locations of {{ucfirst($locations_data['type'])}} for {{ucfirst($locations_data['purpose'])}} in {{$locations_data['city']}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
