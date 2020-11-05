<div class="banner" id="banner">
    <div id="bannerCarousole" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item banner-max-height active">
                <img class="d-block w-100" src="{{asset('img/banner/banner-2.webp')}}" alt="banner">
                <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                    <div class="carousel-content container">
                        <div class="text-center">
                            <h1 class="main-page-banner-heading">Search Properties in Pakistan</h1>
                            <h6 class="none-mb-992-0">

                            </h6>
                            <div class="inline-search-area none-992">
                                {{ Form::open(['route' => ['properties.search'], 'method' => 'get', 'role' => 'form', 'class' => 'index-form']) }}
                                <div class="row">
                                    <div class="col-lg-2 col-sm-1 col-2 search-col border-right">
                                        <div class="label-container"><label class="input-label" for="property-purpose">PURPOSE</label></div>
                                        <div class="index-page-select" style="font-weight:800; font-size:14px">
                                            <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-purpose-select2"
                                                    style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                                    name="property_purpose" id="property-purpose">
                                                <option disabled>Purpose</option>
                                                @foreach(['Buy','Rent','Wanted'] as $key=>$option)
                                                    <option {{$option === 'Buy'? 'selected' : '' }} value={{$option}} data-index={{$key}}>{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-3 col-6 search-col border-right">
                                        <div class="label-container"><label class="input-label" for="property-type">PROPERTY TYPE</label></div>
                                        <div class="index-page-select">
                                            <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-type-select2"
                                                    style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                                    name="property_type" id="property-type">
                                                <option disabled>Property Type</option>
                                                @foreach(['Homes','Plots','Commercial'] as $key=>$option)
                                                    <option {{$option === 'Homes'? 'selected' : '' }} value={{$option}} data-index={{$key}}>{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-3 col-6 search-col middle-col-1 border-right">
                                        <div class="label-container"><label class="input-label" for="city">CITY</label></div>
                                        <div class="index-page-select">
                                            <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible city-select2" id="city" style="width: 100%; border: 0" tabindex="-1"
                                                    aria-hidden="true" aria-describedby="city-error" aria-invalid="false" name="city" required>
                                                <option value disabled>Select city</option>
                                                @foreach(['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro',
                                                           'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah',
                                                            'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'] as $city)
                                                    <option value="{{ $city }}" {{ request()->query('city') === $city|| $city === 'Islamabad' ? 'selected' : '' }}
                                                    data-index={{ $city === 'Islamabad' ? '0' : '' }}>
                                                        {{ $city}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-1 col-2 search-col border-right">
                                        <div class="label-container"><label class="input-label" for="property-purpose">AREA UNIT</label></div>
                                        <div class="index-page-select" style="font-weight:800; font-size:14px">
                                            <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible property-area-unit-select2"
                                                    style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                                    name="property_area_unit" id="property-area-unit">
                                                <option disabled>Select unit</option>
{{--                                                @foreach(['Marla','New Marla (225 Sqft)','Square Feet','Square Yards','Square Meters','Kanal'] as $key=>$option)--}}
{{--                                                    <option {{$option === 'Marla'? 'selected' : '' }} value={{str_replace(' ','-',$option)}} data-index={{$key}}>{{$option}}</option>--}}
{{--                                                @endforeach--}}
                                                @foreach(['Marla','Square Feet','Square Yards','Square Meters','Kanal'] as $key=>$option)
                                                    <option {{$option === 'Marla'? 'selected' : '' }} value={{str_replace(' ','-',$option)}} data-index={{$key}}>{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4 col-8 search-col middle-col-2 border-right">
                                        <div class="label-container"><label class="input-label" for="location">LOCATION</label></div>
                                        <input type="text" class="index-page-text-area" id="location" name="location" list="locations" style="color: #555;">
                                        <datalist id="locations" class="location-datalist"></datalist>
                                    </div>
                                    <div class="col-lg-2 col-sm-1 col-4 search-col index-search">
                                        <button class="btn button-theme btn-search btn-block" type="submit">
                                            <i class="fa fa-search"></i><strong>Find</strong>
                                        </button>
                                    </div>
                                </div>
                                <div class="row advance-search-options" style="margin-top: 10px; display: none">
                                    <div class="col-lg-3 col-sm-4 col-6 search-col property-subtype-div border-right" style="display: block">
                                        <div class="label-container"><label class="input-label" for="property_subtype-">PROPERTY SUBTYPE</label></div>
                                        <div class="index-page-select">
                                            @foreach($property_types as $property_type)
                                                <div id="property_subtype-{{ $property_type->name }}" style="display:none;">
                                                    <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                            aria-describedby="unit-error" aria-invalid="false" name="{{'property_subtype-' . $property_type->name}}">
                                                        <option value selected disabled>{{$property_type->name}}</option>
                                                        @foreach(json_decode($property_type->sub_types) as $type)
                                                            <option value="{{$type}}">{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-6 search-col middle-col-1 border-right">
                                        <div class="row">
                                            <div class="label-container"><label class="input-label" for="select-min-price" style="padding-left: 28px">MIN PRICE (PKR)</label></div>
                                            <div class="col-sm-6" style="padding-right:0; border-right:1px solid #ced4da">
                                                <div class="index-page-select">
                                                    <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible" id="select-min-price" style="width: 100%;" tabindex="-1"
                                                            aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="min_price">
                                                        <option value="0" data-index="0" {{request()->query('min_price')? '' : 'selected'}} >0</option>
                                                        @foreach(['500,000', '1,000,000', '2,000,000', '3,500,000', '5,000,000', '6,500,000', '8,000,000', '10,000,000', '12,500,000', '15,000,000', '17,500,000', '20,000,000', '25,000,000', '30,000,000', '40,000,000', '50,000,000', '75,000,000', '100,000,000', '250,000,000', '500,000,000', '1,000,000,000'] as $key => $price)
                                                            as $key => $price)
                                                            <option value="{{$price}}" {{request()->query('min_price') === $price? 'selected' : ''}} data-index="{{$key+1}}">{{$price}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-0">
                                                <div class="label-container"><label class="input-label" for="select-max-price">MAX PRICE (PKR)</label></div>
                                                <div class="index-page-select">
                                                    <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" id="select-max-price" style="width: 100%;" tabindex="-1"
                                                            aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="max_price">
                                                        <option value="Any" data-index="0" selected>Any</option>
                                                        @foreach(['500,000', '1,000,000', '2,000,000', '3,500,000', '5,000,000', '6,500,000', '8,000,000', '10,000,000', '12,500,000', '15,000,000', '17,500,000', '20,000,000', '25,000,000', '30,000,000', '40,000,000', '50,000,000', '75,000,000', '100,000,000', '250,000,000', '500,000,000', '1,000,000,000', '5,000,000,000'] as $price)
                                                            as $price)
                                                            <option value="{{$price}}" {{request()->query('max_price') === $price? 'selected' : ''}}>{{$price}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-8 search-col middle-col-2 border-right" id="area-container"></div>
                                    {{ Form::bsHidden('area_unit','Marla',['id' => 'input-area-unit']) }}

                                    <div class="col-lg-3 col-sm-3 col-6 search-col middle-col-1 beds-block" style="border-right:1px solid #ced4da; display: block">
                                        <div class="label-container"><label class="input-label" for="beds">BEDROOMS</label></div>
                                        <div class="index-page-select">
                                            <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible" id="beds" style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                    aria-describedby="unit-error" aria-invalid="false" name="bedrooms">
                                                @foreach(['All','1','2','3','4','5','6','7','8','9','10'] as $beds)
                                                    <option value="{{$beds}}" {{request()->query('bedrooms') === $beds? 'selected' : ''}} data-index={{$key}}>{{$beds}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::hidden('sort','newest')}}
                                {{ Form::close() }}
                            </div>
                            <div class="inline-search-area none-992 show-advance-search-options">
                                <div class="search-options-btn-area">
                                    <a class="search-options-btn">
                                        <span class="text-transform font-12">Search Options</span>
                                        <i class="fa fa-chevron-down animated fadeInUp"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="inline-search-area none-992 show-advance-search-options">
                                <div class="search-options-btn-area" style="margin-top:8px !important;">
                                    <a class="btn btn-outline-primary reset-search-btn reset-search-option">
                                        <span class="reset-search">Reset Search</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="card" id="popular-cities">

                            <div class="card-header">
                                <h6 class="popular-cities-heading">Popular Cities</h6>
                            </div>
                            <div class="card-body">
                                <div class="main-title">
                                    <!-- <div class="slider"></div> -->
                                    <div class="slick-slider-area" id="popular-city-slider">
                                        <div class="row slick-carousel" id="popular-cities-row-1" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next"
                                             data-cycle-prev="slick-prev"
                                             data-cycle-carousel-horizontal="true"
                                             data-slick='{"slidesToShow": 4, "rows":1,"responsive":[{"breakpoint": 1440,"settings":{"slidesToShow": 3}}, {"breakpoint": 1024,"settings":{"slidesToShow": 2}}]}'>
                                            @foreach($cities_count as $city)
                                                <div class="slick-slide-item" aria-label="key agency">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="{{route('cities.sale.property',['city'=> strtolower(str_replace(' ','_',$city->city)), 'sort'=>'newest','limit'=>15])}}"
                                                               class="popular-city-font mb-2 mt-5">{{$city->city}}</a>
                                                            <p class="popular-count-font">({{$city->count}})</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="controls">
                                            <div class="slick-prev slick-arrow-buton top-style-prev" id="popular-city-left">
                                                <i class="fas fa-angle-left"></i>
                                            </div>
                                            <div class="slick-next slick-arrow-buton top-style-next" id="popular-city-right">
                                                <i class="fas fa-angle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
