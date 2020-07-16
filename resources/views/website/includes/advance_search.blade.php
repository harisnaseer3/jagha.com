@if ($errors->any())
    <div class="alert alert-danger" xmlns:>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="sidebar widget advanced-search">
    <h3 class="sidebar-title">Advanced Search</h3>
    <div class="s-border"></div>
    <div class="m-border"></div>

    {{ Form::open(['route' => 'properties.search', 'method' => 'get', 'role' => 'form']) }}

    <div class="form-group">
        <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="property-status">
            <option value selected disabled>Property Status</option>
            <option value="sale">For Sale ({{ $aggregates['sale_count'] }})</option>
            <option value="rent">For Rent ({{ $aggregates['rent_count'] }})</option>
        </select>
    </div>

    <div class="form-group">
        <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible city-select2" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="city-error" aria-invalid="false" name="city" required>
            <option value selected disabled>Select city</option>
            @foreach($aggregates['cities'] as $city)
                <option value="{{ $city->city_name }}" {{ request()->query('city') === $city->city_name ? 'selected' : '' }}>{{ $city->city_name }} ({{ $city->count }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group property">
        <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible property-type-select2" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="property_type">
            <option value selected disabled>Property Type</option>
            <option value="Homes">Homes ({{ $aggregates['homes_count'] }})</option>
            <option value="Plots">Plots ({{ $aggregates['plots_count'] }})</option>
            <option value="Commercial">Commercial ({{ $aggregates['commercial_count'] }})</option>
        </select>

    </div>

    @foreach($property_types as $property_type)
        <div id="property_subtype-{{ $property_type->name }}" style="display:none;">
            <div class="form-group">
                <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="{{'property_subtype-' . $property_type->name}}">
                    <option value selected disabled>{{$property_type->name}}</option>
                    @foreach(json_decode($property_type->sub_types) as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="bedrooms">
                    <option value="0" selected>Bedrooms</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="bathrooms">
                    <option value="0" selected>Bathrooms</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
    </div>
    <div class="range-slider">
        <label>Area</label>
        <div data-min="0" data-max="99"
{{--        <div data-min="{{ number_format($aggregates['min_area']) }}" data-max="{{ number_format($aggregates['max_area']) }}"--}}
             data-min-name="min_area" data-max-name="max_area" data-unit="" class="range-slider-ui ui-slider" aria-disabled="false"></div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="unit">
            <option value selected disabled>Select unit</option>
            <option value="square_feet">Square Feet</option>
            <option value="square_yards">Square Yards</option>
            <option value="square_meters">Square Meters</option>
            <option value="marla" selected>Marla</option>
            <option value="kanal">Kanal</option>
        </select>

    </div>
    <div class="range-slider">
        <label>Price</label>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" id="select-min-price" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="min_price">
                        <option value selected disabled>Select min</option>
                        <option value="500,00" data-index="1">500,00</option>
                        <option value="1,000,00" data-index="2">1,000,00</option>
                        <option value="2,000,00" data-index="3">2,000,00</option>
                        <option value="3,500,00" data-index="4">3,500,00</option>
                        <option value="5,000,00" data-index="5">5,000,00</option>
                        <option value="6,500,00" data-index="6">6,500,00</option>
                        <option value="8,000,00" data-index="7">8,000,00</option>
                        <option value="10,000,00" data-index="8">10,000,00</option>
                        <option value="12,500,00" data-index="9">12,500,00</option>
                        <option value="15,000,00" data-index="10">15,000,00</option>
                        <option value="17,500,00" data-index="11">17,500,00</option>
                        <option value="20,000,00" data-index="12">20,000,00</option>
                        <option value="25,000,00" data-index="13">25,000,00</option>
                        <option value="30,000,00" data-index="14">30,000,00</option>
                        <option value="40,000,00" data-index="15">40,000,00</option>
                        <option value="50,000,00" data-index="16">50,000,00</option>
                        <option value="75,000,00" data-index="17">75,000,00</option>
                        <option value="100,000,00" data-index="18">100,000,00</option>
                        <option value="250,000,00" data-index="19">250,000,00</option>
                        <option value="500,000,00" data-index="20">500,000,00</option>
                        <option value="1,000,000,00" data-index="21">1,000,000,00</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" id="select-max-price" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="max_price">
                        <option value selected disabled>Select Max</option>
                        <option value="500,000">500,000</option>
                        <option value="1,000,000">1,000,000</option>
                        <option value="2,000,000">2,000,000</option>
                        <option value="3,500,000">3,500,000</option>
                        <option value="5,000,000">5,000,000</option>
                        <option value="6,500,000">6,500,000</option>
                        <option value="8,000,000">8,000,000</option>
                        <option value="10,000,000">10,000,000</option>
                        <option value="12,500,000">12,500,000</option>
                        <option value="15,000,000">15,000,000</option>
                        <option value="17,500,000">17,500,000</option>
                        <option value="20,000,000">20,000,000</option>
                        <option value="25,000,000">25,000,000</option>
                        <option value="30,000,000">30,000,000</option>
                        <option value="40,000,000">40,000,000</option>
                        <option value="50,000,000">50,000,000</option>
                        <option value="75,000,000">75,000,000</option>
                        <option value="100,000,000">100,000,000</option>
                        <option value="250,000,000">250,000,000</option>
                        <option value="500,000,000">500,000,000</option>
                        <option value="1,000,000,000">1,000,000,000</option>
                        <option value="5,000,000,000">5,000,000,000</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group mb-0">
        {{ Form::submit('Find', ['class' => 'btn button-theme search-button btn-search btn-block']) }}
    </div>
    {{ Form::close() }}
</div>
