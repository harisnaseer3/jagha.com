@php
    $type=''; $subtype = ''; $purpose = '';$selected_city ='';
if(request()->segment(2) !== 'partners_results' ){
    if(request()->segment(1) !== 'properties' &&
 !(strpos( request()->segment(1), 'agents-' ) !== false) &&
 !(strpos( request()->segment(1), 'partners' ) !== false))
 {
    $type=''; $subtype = ''; $purpose = '';$selected_city ='';
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
          $selected_city =  ucwords(str_replace('-',' ',request()->segment(2)));}
}

}
@endphp
<div class="banner" id="banner">
    <div class="text-center detail-page-banner none-992 sticky">
        <div class="containers inline-search-area none-992">
            {{ Form::open(['route' => 'properties.search', 'method' => 'get', 'role' => 'form', 'class' => 'index-form']) }}

            <div class="row">
                <div class="col-lg-2 col-sm-1 col-2 search-col" style="border-right:1px solid #ced4da">
                    <div class="label-container"><label class="input-label" for="property-purpose">PURPOSE</label></div>
                    <div class="index-page-select" style="font-weight:800; font-size:14px">
                        <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-purpose-select2"
                                style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                name="property_purpose" id="property-purpose">
                            {{--                            <option disabled>Purpose</option>--}}
                            @foreach(['Buy', 'Rent', 'Wanted'] as $key => $option)

                                <option value="{{$option}}" {{$purpose === $option ? 'selected' : ''}}
                                data-index={{$key}}>{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-3 col-6 search-col" style="border-right:1px solid #ced4da">
                    <div class="label-container"><label class="input-label" for="property-type">PROPERTY TYPE</label></div>
                    <div class="index-page-select">
                        <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-type-select2"
                                style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                name="property_type" id="property-type">
                            {{--                            <option disabled>Property Type</option>--}}
                            @foreach(['Homes', 'Plots', 'Commercial'] as $option)
                                <option value="{{$option}}" {{$type === $option ? 'selected' : ''}}
                                data-index={{$key}}>{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-3 col-6 search-col middle-col-1" style="border-right:1px solid #ced4da">
                    <div class="label-container"><label class="input-label" for="city">CITY</label></div>
                    <div class="index-page-select">
                        <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible city-select2" id="city" style="width: 100%; border: 0" tabindex="-1"
                                aria-hidden="true" aria-describedby="city-error" aria-invalid="false" name="city" required>
                            {{--                            <option value disabled>Select city</option>--}}
                            @foreach(['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro',
                                                           'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah',
                                                            'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'] as $city)
                                <option value="{{ $city }}" {{ $selected_city === $city|| $city === 'Islamabad' ? 'selected' : '' }}>
                                    {{ $city}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-8 search-col middle-col-2" style="border-right:1px solid #ced4da;">
                    <div class="label-container"><label class="input-label" for="location">LOCATION</label></div>
                    <input type="text" class="index-page-text-area" id="location" name="location" list="locations"
                           value="{{ucwords(str_replace('-',' ',request()->query('location')))}}"
                           style="color: #555;">
                    <datalist id="locations" class="location-datalist"></datalist>
                </div>
                <div class="col-lg-2 col-sm-1 col-2 search-col border-right">
                    <div class="label-container"><label class="input-label" for="property-purpose">AREA UNIT</label></div>
                    <div class="index-page-select" style="font-weight:800; font-size:14px">
                        <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-area-unit-select2"
                                style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                name="property_area_unit" id="property-area-unit">
                            {{--                            <option disabled>Select unit</option>--}}
                            @foreach(['Square Feet','Square Yards','Square Meters','Marla','Kanal'] as $key=>$option)
                                @if(ucwords(str_replace('-',' ', request()->query('area_unit'))) == $option)
                                    <option selected value={{str_replace(' ','-',$option)}} data-index={{$key}}>
                                        {{$option}}
                                    </option>
                                @elseif(request()->query('area_unit') == '' && $option == 'Marla')
                                    <option selected value={{str_replace(' ','-',$option)}} data-index={{$key}}>
                                        {{$option}}
                                    </option>
                                @else
                                    <option value={{str_replace(' ','-',$option)}} data-index={{$key}}>
                                        {{$option}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-1 col-4 search-col">
                    <button class="btn btn-search btn-block transition-background" type="submit">
                        <i class="fa fa-search green-color"></i><strong>Find</strong>
                    </button>
                </div>
            </div>
            <div class="row advance-search-options" style="margin-top: 10px; display: none">
                <div class="col-lg-3 col-sm-4 col-6 search-col property-subtype-div" style="border-right:1px solid #ced4da; display: block">
                    <div class="label-container"><label class="input-label" for="property_subtype-">PROPERTY SUBTYPE</label></div>
                    <div class="index-page-select">
                        @foreach($property_types as $property_type)
                            <div id="property_subtype-{{ $property_type->name }}" style="display:none;">
                                <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"
                                        aria-describedby="unit-error" aria-invalid="false" name="{{'property_subtype-' . $property_type->name}}">
                                    {{--                                    <option value {{request()->query('property_subtype-'.$property_type->name)? '' : 'selected'}} data-index="0" disabled>{{$property_type->name}}</option>--}}
                                    @foreach(json_decode($property_type->sub_types) as $type)
                                        <option value="{{$type}}" {{ $subtype === $type? 'selected' : ''}}>{{$type}}</option>
                                    @endforeach
                                </select>

                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-6 search-col middle-col-1" style="border-right:1px solid #ced4da">
                    <div class="row">
                        <div class="label-container"><label class="input-label" for="select-min-price" style="padding-left: 28px">MIN PRICE (PKR)</label></div>
                        <div class="col-sm-6" style="padding-right:0; border-right:1px solid #ced4da">
                            <div class="index-page-select">
                                <input type="number" class="index-page-num-area" id="select-min-price"
                                       aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="min_price" list="select-min-price-datalist"
                                       style="color: #555;" min=0>
                                <datalist id="select-min-price-datalist" class="areas-datalist">
                                    <option value=500000>500000</option>
                                    <option value=1000000>1000000</option>
                                    <option value=2000000>2000000</option>
                                    <option value=3500000>3500000</option>
                                    <option value=5000000>5000000</option>
                                    <option value=6500000>6500000</option>
                                    <option value=8000000>8000000</option>
                                    <option value=10000000>10000000</option>
                                    <option value=12500000>12500000</option>
                                    <option value=15000000>15000000</option>
                                    <option value=17500000>17500000</option>
                                </datalist>

                            </div>
                        </div>
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="label-container"><label class="input-label" for="select-max-price">MAX PRICE (PKR)</label></div>
                            <div class="index-page-select">
                                <input type="number" class="index-page-num-area"
                                       id="select-max-price" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="max_price"
                                       list="select-max-price-datalist"
                                       style="color: #555;" min=0>

                                <datalist id="select-max-price-datalist" class="areas-datalist">
                                    <option value=1000000>1000000</option>
                                    <option value=2000000>2000000</option>
                                    <option value=3500000>3500000</option>
                                    <option value=5000000>5000000</option>
                                    <option value=6500000>6500000</option>
                                    <option value=8000000>8000000</option>
                                    <option value=10000000>10000000</option>
                                    <option value=12500000>12500000</option>
                                    <option value=15000000>15000000</option>
                                    <option value=17500000>17500000</option>
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-8 search-col middle-col-2" style="border-right:1px solid #ced4da" id="area-container">
                    <div class="row">
                        <div class="col-sm-6" style="padding-right:0; border-right:1px solid #ced4da">
                            <div class="label-container"><label class="input-label min-area-label" for="select-min-area">MIN AREA</label></div>
                            <div class="index-page-select"><input type="number" class="index-page-num-area" id="select-min-area" name="min_area" list="select-min-areas-datalist"
                                                                  style="color: #555;" min="0">
                                <datalist id="select-min-areas-datalist">
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

                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="label-container"><label class="input-label max-area-label" for="select-max-area">MAX AREA</label></div>
                            <div class="index-page-select"><input type="number" class="index-page-num-area" id="select-max-area" name="max_area" list="select-max-areas-datalist"
                                                                  style="color: #555;" min="0">
                                <datalist id="select-max-areas-datalist">
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
                {{ Form::bsHidden('area_unit','Marla',['id' => 'input-area-unit']) }}

                <div class="col-lg-3 col-sm-3 col-6 search-col middle-col-1 beds-block" style="border-right:1px solid #ced4da; display: block">
                    <div class="label-container"><label class="input-label" for="beds">BEDROOMS</label></div>
                    <div class="index-page-select">
                        <input type="number" class="index-page-num-area" id="beds" name="bedrooms" list="select-beds-datalist" aria-describedby="unit-error" aria-invalid="false"
                               style="color: #555;" min="0">
                        <datalist id="select-beds-datalist" class="areas-datalist">
                            @foreach(['1','2','3','4','5'] as $beds)
                                <option value="{{$beds}}">{{$beds}}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>
            {{ Form::hidden('sort','newest')}}
            {{ Form::close() }}
        </div>
        <div class="containers inline-search-area none-992" style="padding-left: 0px; padding-right: 0px;">
            <div class="text-left" style="margin-top:8px !important;">
                <a type="button" class="btn btn-outline-primary reset-search-btn text-transform" id="reset-search-banner2lg"
                   style="margin:0; background: #b79c35">
                    <span class="reset-search">Reset Search</span>
                </a>
                <a type="button" class="btn search-options-btn text-transform"
                   style="margin:0; background-color: #b79c35; padding:7px 12px !important;">
                    <span class="reset-search">Search Options</span>
                    <i class="fa fa-chevron-down animated fadeInUp"></i>
                </a>
                {{--                <a type="button" class="search-options-btn">--}}
                {{--                    <span class="text-transform font-12">Search Options</span>--}}
                {{--                    <i class="fa fa-chevron-down animated fadeInUp"></i>--}}
                {{--                </a>--}}
                {{--                <a type="button" class="btn btn-outline-primary reset-search-btn text-transform" data-toggle="modal" data-target="#modalCart"--}}
                {{--                   style="margin-left: 5px;background-color: #274abb;">--}}
                {{--                    <span style="padding: 2px; color: white; font-size: 12px; font-weight: 600">Change Area Unit</span>--}}
                {{--                </a>--}}
            </div>
        </div>
    </div>
</div>
