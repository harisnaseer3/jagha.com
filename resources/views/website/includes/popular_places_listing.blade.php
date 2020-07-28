<div class="categories content-area-8 pt-5">
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
                    <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Houses & Flats</h4>
                        <ul>
                            @foreach($popular_cities_homes_on_sale as $key => $property_data)
                                <li>
                                    <h6 class="custom-font">
                                        <a href="{{route('sale.property.search', ['sub_type' => lcfirst($property_data->property_sub_type), 'city' => lcfirst($property_data->city_name) ,
                                                    'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_sub_type}}  in {{$property_data->city_name}}">
                                            {{$property_data->property_sub_type}} in {{$property_data->city_name}}
                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                </li>
                            @endforeach
                            <li><a href="javascript:void(0)" class="more-popular-cities font-weight-bold" title="View All Cities">View all Cities</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Plots</h4>
                        <ul>
                            @foreach($popular_cities_plots_on_sale as $key => $property_data)
                                <li>
                                    <h6 class="custom-font">
                                        <a href="{{route('sale.property.search', ['sub_type' => 'plots','city' => lcfirst($property_data->city_name),
                                                'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_type}}  in {{$property_data->city_name}}">
                                            {{$property_data->property_type}} in {{$property_data->city_name}}
                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                    @endforeach
                                </li>
                                <li><a href="javascript:void(0)" class="more-popular-cities font-weight-bold" title="View All Cities">View all Cities</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Commercial</h4>
                        <ul>
                            @foreach($popular_cities_commercial_on_sale as $key => $property_data)
                                <li>
                                    <h6 class="custom-font">
                                        <a href="{{route('sale.property.search',['sub_type' => lcfirst($property_data->property_sub_type),'city' => lcfirst($property_data->city_name),
                                                'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_sub_type}} in {{$property_data->city_name}}">

                                            {{$property_data->property_sub_type}} in {{$property_data->city_name}}

                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                </li>
                            @endforeach
                            <li><a href="javascript:void(0)" class="more-popular-cities font-weight-bold" title="View All Cities">View all Cities</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                        <h4 class="font-16 color-555 pb-3">Rentals</h4>
                        <ul>
                            @foreach($popular_cities_property_on_rent as $key => $property_data)
                                <li><h6 class="custom-font">
                                        <a href="{{route('sale.property.search',['sub_type' => strtolower(str_replace(' ','-',$property_data->property_sub_type)),'city' => lcfirst($property_data->city_name),
                                                'purpose'=>lcfirst($property_data->property_purpose), 'sort'=>'newest'])}}"
                                           title="{{$property_data->property_sub_type}} in {{$property_data->city_name}}">

                                            {{$property_data->property_sub_type}} in {{$property_data->city_name}}

                                            <span>({{$property_data->property_count}})</span>
                                        </a>
                                    </h6>
                                </li>
                            @endforeach
                            <li><a href="javascript:void(0)" class="more-popular-cities font-weight-bold" title="View All Cities">View all Cities</a></li>

                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <h4 class="font-16 color-555">Popular Locations to Buy Houses</h4>
                        <hr>
                    </div>
                    {{--                    {{dd($city_wise_homes_data['Islamabad/Rawalpindi'])}}--}}

                    @foreach($city_wise_homes_data as $key_value => $value)
                        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                            <h4 class="font-16 color-555 pb-3"><a
                                    href="{{route('sale.property.search', ['sub_type' => 'homes', 'city' => str_replace('/','-',$key_value),'purpose'=>'sale', 'sort'=>'newest'])}}"
                                    title="{{ucfirst($key_value)}}">{{ucfirst($key_value)}}</a></h4>
                            <ul>
                                @foreach($value as $key => $property_data)
                                    <li>
                                        <h6 class="custom-font">
                                            <a href="{{route('search.houses.plots', ['type'=>lcfirst($property_data->property_type),'city' => lcfirst($property_data->city_name),'location'=> str_replace(' ', '-',str_replace('-','_',$property_data->location_name)), 'sort'=>'newest'])}}"
                                               title="{{$property_data->property_type}} in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 17, $end='...')}}">
                                                {{$property_data->property_type}}
                                                @if($key_value == 'Islamabad/Rawalpindi' && $key < 3 && $property_data->location_name === 'Bahria Town')
                                                    in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 30, $end='...').' Islamabad'}}
                                                @else
                                                    in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 30, $end='...')}}
                                                @endif
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
                    <div class="col-sm-12"><h4 class="font-16 color-555">Popular Locations to Buy Plots</h4>
                        <hr>
                    </div>
                    @foreach($city_wise_plots_data as $key_value => $value)
                        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                            <h6 class="font-16 color-555 pb-3"><a
                                    href="{{route('sale.property.search', ['sub_type' => 'plots', 'city' => str_replace('/','-',$key_value),'purpose'=>'sale', 'sort'=>'newest'])}}"
                                    title="{{ucfirst($key_value)}}">{{ucfirst($key_value)}}</a></h6>
                            <ul>

                                @foreach($value as $key => $property_data)
                                    <li>
                                        <h6 class="custom-font">
                                            <a href="{{route('search.houses.plots',['type'=>lcfirst($property_data->property_type),'city' => lcfirst($property_data->city_name), 'location'=> str_replace(' ', '-',str_replace('-','_',$property_data->location_name)), 'sort'=>'newest'])}}"
                                               title="{{$property_data->property_type}} in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 17, $end='...')}}">
                                                {{$property_data->property_type}}
                                                @if($key_value == 'Islamabad/Rawalpindi' && $key < 3 && $property_data->location_name === 'Bahria Town')
                                                    in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 30, $end='...').' Islamabad' }}
                                                @else
                                                    in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 30, $end='...') }}
                                                @endif
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
                    <div class="col-sm-12">
                        <h4 class="font-16 color-555">Popular Locations to Buy Commercial Properties</h4>
                        <hr>
                    </div>
                    {{--                    {{dd($city_wise_commercial_data['Islamabad/Rawalpindi'])}}--}}
                    @foreach($city_wise_commercial_data as $key_name => $value)
                        <div class="col-lg-3 col-md-6 col-sm-6 p-3">
                            <h4 class="font-16 color-555 pb-3"><a
                                    href="{{route('sale.property.search', ['sub_type' => 'commercial', 'city' => str_replace('/','-',$key_name),'purpose'=>'sale', 'sort'=>'newest'])}}"
                                    title="{{ucfirst($key_name)}}">{{ucfirst($key_name)}}</a>
                            </h4>
                            <ul>
                                @foreach($value as $key => $property_data)
                                    <li>
                                        <h6 class="custom-font">
                                            <a href="{{route('search.houses.plots', ['type'=>lcfirst($property_data->property_type),'city' => lcfirst($property_data->city_name),'location'=> str_replace(' ', '-',str_replace('-','_',$property_data->location_name)), 'sort'=>'newest'])}}"
                                               title="{{$property_data->property_type}} in {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 35, $end='...')}}">
                                                @if($key_name == 'Islamabad/Rawalpindi' && $key < 3 && $property_data->location_name === 'Bahria Town')
                                                    {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 35, $end='...').' Islamabad'}}
                                                @else
                                                    {{\Illuminate\Support\Str::limit(strip_tags($property_data->location_name), 35, $end='...')}}
                                                @endif

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
