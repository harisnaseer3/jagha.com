@php
    $type=''; $subtype = ''; $purpose = '';$selected_city ='';
    if(request()->segment(1) !== 'properties' &&
    !(strpos( request()->segment(1), 'agents-' ) !== false)
     && !(strpos( request()->segment(1), 'partners' ) !== false)
     && (request()->segment(2) !== 'partners_results' ))
    {
      if(request()->segment(2) == 'null' || request()->segment(2) == '')
        $type = ucfirst(explode('_',request()->segment(1))[0]);
      else {
          if(in_array(ucfirst(explode('_',request()->segment(1))[0]),['Homes', 'Plots','Commercial']))
            $type = ucfirst(explode('_',request()->segment(1))[0]);
          else
              $subtype = ucwords(str_replace('-',' ',explode('_',request()->segment(1))[0]));
          if($subtype != ''){
              if(in_array($subtype,['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Room', 'Penthouse']))
                  $type = 'Homes';
              else if(in_array($subtype,['Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other']))
                   $type = 'Commercial';
              else $type = 'Plots';
          }
          if(explode('_',request()->segment(1))[2] === 'sale') $purpose = 'Buy';
          else
            $purpose = ucwords(explode('_',request()->segment(1))[2]);
          $selected_city =  ucwords(str_replace('-',' ',request()->segment(2)));
      }
    }
@endphp


<div class="search-section search-area-2 index-search bg-grea sa2">
    <div class="container">
        <div class="search-section-area">
            <div class="search-area-inner">
                <div class="search-contents">
                    {{ Form::open(['route' => 'properties.search', 'method' => 'get', 'role' => 'form', 'class' => 'index-form-2',]) }}

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select select2-purpose">
                                    <label class="search2-input-label" for="search2-property-purpose">PURPOSE</label>
                                    <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-purpose-select2"
                                            style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                            name="property_purpose" id="search2-property-purpose">
                                        {{--                                        <option disabled>Purpose</option>--}}
                                        @foreach(['Buy', 'Rent', 'Wanted'] as $key => $option)
                                            <option value="{{$option}}" {{$purpose === $option ? 'selected' : ''}}
                                            data-index={{$key}}>{{$option}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-property-type">PROPERTY TYPE</label>
                                    <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-type-select2"
                                            style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                            name="property_type" id="search2-property-type">
                                        {{--                                        <option disabled>Property Type</option>--}}
                                        @foreach(['Homes', 'Plots', 'Commercial'] as $option)
                                            <option value="{{$option}}" {{$type === $option ? 'selected' : ''}}
                                            data-index={{$key}}>{{$option}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-city">CITY</label>
                                    <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible city-select2" id="search2-city" style="width: 100%; border: 0" tabindex="-1"
                                            aria-hidden="true" aria-describedby="city-error" aria-invalid="false" name="city" required>
                                        {{--                                        <option value selected disabled data-index="0">Select city</option>--}}
                                        @foreach(['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro',
                                                           'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah',
                                                            'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'] as $city)
                                            <option value="{{ $city }}" {{$selected_city === $city|| $city === 'Islamabad' ? 'selected' : '' }}>
                                                {{ $city}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-1">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <div class="search2-input-label"><label class="input-label p-0 m-0" for="search2-property_subtype-">PROPERTY SUBTYPE</label></div>
                                    @foreach($property_types as $property_type)
                                        <div id="search2-property_subtype-{{ $property_type->name }}" style="display:none;">
                                            <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1"
                                                    id="{{'search2-subtype-'.$property_type->name}}"
                                                    aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="{{'property_subtype-' . $property_type->name}}">
                                                {{--                                                <option value selected disabled>{{ $property_type->name}}</option>--}}
                                                @foreach(json_decode($property_type->sub_types) as $type)
                                                    <option value="{{$type}}" {{ $subtype === $type? 'selected' : ''}}>{{$type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-location">LOCATION</label>
                                    <input type="text" class="search2-index-page-text-area color-555 search-location" id="search2-location" name="location" list="locations"
                                           value="{{ucwords(str_replace('-',' ',request()->query('location')))}}">
                                    <datalist id="locations" class="location-datalist"></datalist>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 beds-block">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-bedrooms">BEDROOMS</label>
                                    <input type="number" class="index-page-num-area" id="search2-beds" name="bedrooms" list="select2-beds-datalist"
                                           aria-describedby="unit-error" aria-invalid="false"
                                           style="color: #555;" min="0">
                                    <datalist id="select2-beds-datalist" class="areas-datalist">
                                        @foreach(['1','2','3','4','5',] as $beds)
                                            <option value="{{$beds}}"> {{$beds}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-bedrooms">AREA UNIT</label>
                                    <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible" id="search2-input-area-unit" style="width: 100%;" tabindex="-1"
                                            aria-hidden="true"
                                            aria-describedby="unit-error" aria-invalid="false" name="search2-unit">
                                        @foreach(['Square Feet','Square Yards','Square Meters','Marla','Kanal'] as $key => $unit)
                                            <option value="{{$unit}}"
                                                    {{ucwords(str_replace('-', ' ', request()->query('area_unit'))) === $unit || $unit == 'Marla'? 'selected' : ''}}
                                                    data-index="{{$unit}}"> {{$unit}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6" id="search2-min-area">
                            <div class="form-group">
                                <div class="index-page-select" style="padding: 0;"><label class="search2-input-label min-area-label" for="search2-select-min-area"> MIN AREA</label>
                                    <input type="number" class="index-page-num-area" id="search2-select-min-area" name="min_area" list="min-areas" style="color: #555;" min="0">
                                    <datalist id="min-areas" class="min-areas-datalist">
                                        <option value=1>1</option>
                                        <option value=2>2</option>
                                        <option value=3>3</option>
                                        <option value=4>4</option>
                                        <option value=5>5</option>
                                        <option value=6>6</option>
                                        <option value=8>8</option>
                                        <option value=10>10</option>
                                        <option value=12>12</option>
                                        <option value=15>15</option>
                                    </datalist>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6" id="search2-max-area">
                            <div class="form-group">
                                <div class="index-page-select" style="padding: 0">
                                    <label class="search2-input-label max-area-label" for="search2-select-max-area">MAX AREA</label>
                                    <input type="number" class="index-page-num-area" id="search2-select-max-area" name="max_area" list="max-areas" style="color: #555;" min="0">
                                    <datalist id="max-areas" class="max-areas-datalist">
                                        <option value=1>1</option>
                                        <option value=2>2</option>
                                        <option value=3>3</option>
                                        <option value=4>4</option>
                                        <option value=5>5</option>
                                        <option value=6>6</option>
                                        <option value=8>8</option>
                                        <option value=10>10</option>
                                        <option value=12>12</option>
                                        <option value=15>15</option>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-select-min-price">MIN PRICE</label>
                                    <input type="number" class="index-page-num-area" id="search2-select-min-price" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                           name="min_price"
                                           list="select-min-price-datalist" style="color: #555;" min=0>
                                    <datalist id="select-min-price-datalist" class="max-areas-datalist">
                                        @foreach([500,000, 1,000,000, 2,000,000, 3,500,000, 5,000,000, 6,500,000, 8,000,000, 10,000,000, 12,500,000, 15,000,000, 17,500,000,20,000,000, 25,000,000, 30,000,000, 40,000,000, 50,000,000, 75,000,000, 100,000,000, 250,000,000, 500,000,000, 1,000,000,000, 5,000,000,000] as $price)
                                            <option value="{{$price}}" {{request()->query('max_price') === $price? 'selected' : ''}}>{{$price}}</option>
                                        @endforeach
                                    </datalist>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <div class="index-page-select p-0">
                                    <label class="search2-input-label" for="search2-select-max-price">MAX PRICE</label>
                                    <input type="number" class="index-page-num-area" id="search2-select-max-price" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                           name="max_price"
                                           list="select-max-price-datalist" style="color: #555;" min=0>
                                    <datalist id="select-max-price-datalist" class="areas-datalist">
                                        @foreach([1,000,000, 2,000,000, 3,500,000, 5,000,000, 6,500,000, 8,000,000, 10,000,000, 12,500,000, 15,000,000, 17,500,000,20,000,000, 25,000,000, 30,000,000, 40,000,000, 50,000,000, 75,000,000, 100,000,000, 250,000,000, 500,000,000, 1,000,000,000, 5,000,000,000] as $price)
                                            <option value="{{$price}}" {{request()->query('max_price') === $price? 'selected' : ''}}>{{$price}}</option>
                                        @endforeach
                                    </datalist>

                                </div>
                            </div>
                        </div>

                        {{--                        {{ Form::bsHidden('search2-area_unit','Marla',['id' => 'search2-input-area-unit']) }}--}}
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group mt-2">
                                <div class="reset-search-banner2 search-button" style="text-transform:none;">
                                    <strong style="color: white">Reset Search</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <button class="search-button" style="margin-top:10px;text-transform:none;" type="submit">
                                    <i class="fa fa-search"></i><strong style="color: white">Find</strong>
                                </button>
                            </div>
                        </div>
                        {{--                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">--}}
                        {{--                            <div class="form-group" style="background-color:#274abb; border-radius: 3px;">--}}
                        {{--                                <div class="reset-search-banner2 search-button" style="text-transform:none;">--}}
                        {{--                                    <strong style="color: white">Reset Search</strong>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                                 <div class="form-group" style="background-color: #274abb; border-radius: 3px;">--}}
                        {{--                                     <div class="padding-5" type="btn" data-toggle="modal" data-target="#modalCart">--}}
                        {{--                                         <strong style="color: white;">Change Area Unit</strong>--}}
                        {{--                                     </div>--}}
                        {{--                                 </div>--}}
                        {{--                        </div>--}}

                    </div>
                    {{ Form::hidden('sort','newest')}}
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
{{--Modal--}}
{{--<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--     aria-hidden="true">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <!--Header-->--}}
{{--            <div class="modal-header">--}}
{{--                <h4 class="modal-title" id="myModalLabel">Change area unit</h4>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">×</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <!--Body-->--}}
{{--            <div class="modal-body">--}}
{{--                <div class="container">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12 justify-content-center">--}}
{{--                            <div class="form-group">--}}
{{--                                <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1"--}}
{{--                                        aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="unit" id="area-unit">--}}
{{--                                    <option value selected disabled>Select unit</option>--}}
{{--                                    <option value="Square Feet">Square Feet</option>--}}
{{--                                    <option value="Square Yards">Square Yards</option>--}}
{{--                                    <option value="Square Meters">Square Meters</option>--}}
{{--                                    <option value="Marla" selected>Marla</option>--}}
{{--                                    <option value="Kanal">Kanal</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #274abb; color: white"--}}
{{--                               data-dismiss="modal" id="area-unit-save">Save</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
