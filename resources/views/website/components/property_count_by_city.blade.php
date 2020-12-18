
    <div class="row">
        <div class="col-12">
            <div class="pull-right">

                <strong>Sort Alphabetically</strong>
                <label class="switch">
                    <input name="alpha-switch" id="alpha-switch" type="checkbox" {{$sort}}>
                    <span class="slider round"></span>
                </label>

            </div>
        </div>
    </div>
    @if($properties)
        <div class="row">
            @foreach($properties as  $property)
                <div class="col-sm-3 my-2">
                    <a href="{{route('sale.property.search', ['sub_type' => lcfirst($property->property_type),
                                                                                      'city' => lcfirst($property->city_name) ,
                                                                                      'purpose'=>lcfirst($property->property_purpose), 'sort'=>'newest','limit'=>15])}}"
                       title="{{$property->property_type}}  in {{$property->city_name}}"
                       class="breadcrumb-link">
                        {{$property->city_name}} ({{$property->property_count}})
                    </a>
                </div>
            @endforeach
        </div>
    @endif
