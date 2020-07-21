<div class="categories content-area-8 pt-0">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h2>Popular Locations</h2>
        </div>
        <div class="row wow" aria-label="popular locations">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-sm-12"><h4 class="font-16 color-555">Popular Properties to Buy/Rent Across Pakistan</h4>
                        <hr>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Houses</h4>
                        <ul>
                            @foreach($popular_cities_homes_on_sale as $key => $property_data)
                                <li>
                                    <h6 class="custom-font">
                                        <a href="{{route('sale.property.search', ['sub_type' => 'houses', 'city' => lcfirst($property_data->city_name) ,
                                                    'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_sub_type}} for {{$property_data->property_purpose}} in {{$property_data->city_name}}">
                                            {{$property_data->property_sub_type}} for {{$property_data->property_purpose}} in {{$property_data->city_name}}
                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Flats</h4>
                        <ul>
                            @foreach($popular_cities_flats_on_sale as $key => $property_data)
                                <li>
                                    <h6 class="custom-font">
                                        <a href="{{route('sale.property.search',['sub_type' => 'flats','city' => lcfirst($property_data->city_name),
                                                'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_sub_type}} for {{$property_data->property_purpose}} in {{$property_data->city_name}}">
                                            {{$property_data->property_sub_type}} for {{$property_data->property_purpose}} in {{$property_data->city_name}}
                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Plots</h4>
                        <ul>
                            @foreach($popular_cities_plots_on_sale as $key => $property_data)
                                <li>
                                    <h6 class="custom-font">
                                        <a href="{{route('sale.property.search', ['sub_type' => 'plots','city' => lcfirst($property_data->city_name),
                                                'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_type}} for {{$property_data->property_purpose}} in {{$property_data->city_name}}">
                                            {{$property_data->property_type}} for {{$property_data->property_purpose}} in {{$property_data->city_name}}
                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <h4 class="font-16 color-555">Popular Locations for Homes</h4>
                        <hr>
                    </div>
                    @foreach($city_wise_homes_data as $key => $value)
                        <div class="col-lg-4 col-md-6 col-sm-6 p-3">
                            <h4 class="font-16 color-555 pb-3">{{ucfirst($key)}}</h4>
                            <ul>
                                @foreach($value as $key => $property_data)
                                    <li>
                                        <h6 class="custom-font">
                                            <a href="{{route('search.houses.plots', ['type'=>lcfirst($property_data->property_type),'city' => lcfirst($property_data->city_name),'location'=> str_replace(' ', '-',str_replace('-','_',$property_data->location_name)), 'sort'=>'newest'])}}"
                                               title="{{$property_data->property_type}} for {{$property_data->property_purpose}} in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 27, $end='...') }}">
                                                {{$property_data->property_type}} for {{$property_data->property_purpose}} in {{$property_data->location_name}}
                                                <span>({{$property_data->property_count}})</span>
                                            </a>
                                        </h6>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12"><h4 class="font-16 color-555">Popular Locations for Plots</h4>
                        <hr>
                    </div>
                    @foreach($city_wise_plots_data as $key => $value)
                        <div class="col-lg-4 col-md-6 col-sm-6 p-3">
                            <h6 class="font-16 color-555 pb-3">{{ucfirst($key)}}</h6>
                            <ul>
                                @foreach($value as $key => $property_data)
                                    <li>
                                        <h6 class="custom-font">
                                            <a href="{{route('search.houses.plots',['type'=>lcfirst($property_data->property_type),'city' => lcfirst($property_data->city_name), 'location'=> str_replace(' ', '-',str_replace('-','_',$property_data->location_name)), 'sort'=>'newest'])}}"
                                               title="{{$property_data->property_type}} for {{$property_data->property_purpose}} in {{$property_data->location_name}}">
                                                {{$property_data->property_type}} for {{$property_data->property_purpose}}
                                                in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 27, $end='...') }}
                                                <span>({{$property_data->property_count}})</span>
                                            </a>
                                        </h6>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
