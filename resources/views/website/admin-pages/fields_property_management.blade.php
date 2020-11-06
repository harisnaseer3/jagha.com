<div class="card">
    <div class="card-header theme-blue text-white">Property Type and Location</div>
    <div class="card-body">

        @if(isset($property->id))
            {{ Form::bsText('property_id', isset($property->id)?$property->id:null, ['readonly' => 'readonly']) }}
            {{ Form::bsText('property_reference', isset($property->reference)?$property->reference:null, ['readonly' => 'readonly']) }}
            {{ Form::bsText('purpose', isset($property->purpose)? $property->purpose : 'Sale', ['readonly' => 'readonly']) }}
            @if(isset($property->sub_purpose))
                {{ Form::bsText('wanted_for', $property->sub_type, ['readonly' => 'readonly']) }}
            @endif
            {{ Form::bsText('property_type', isset($property->type)? $property->type : 'Homes', ['readonly' => 'readonly']) }}

            {{ Form::bsText('property_subtype ' . $property->type, isset($property->sub_type)? $property->sub_type : '', ['readonly' => 'readonly']) }}
            {{ Form::bsText('city', isset($property->city)? $property->city : null, ['readonly' => 'readonly']) }}
            {{ Form::bsText('location', isset($property->location)? $property->location : null, ['readonly' => 'readonly']) }}
        @else
            {{ Form::bsRadio('purpose', isset($property->purpose)? $property->purpose : 'Sale', ['required' => true, 'list' => ['Sale', 'Rent', 'Wanted']]) }}

            <div id="purpose-Wanted" style="display: none;">
                {{ Form::bsRadio('wanted_for', isset($property->sub_purpose)? $property->sub_purpose : '', ['list' => ['Buy', 'Rent']]) }}
            </div>

            {{ Form::bsRadio('property_type',isset($property->type)? $property->type : 'Homes', ['required' => true, 'list' => ['Homes', 'Plots', 'Commercial']]) }}

            @foreach($property_types as $property_type)
                <div id="property_subtype-{{ $property_type->name }}" style="display: none;">
                    {{ Form::bsRadio('property_subtype-' . $property_type->name, isset($property->sub_type)? $property->sub_type : '',
                    ['list' => json_decode($property_type->sub_types)]) }}
                </div>
            @endforeach
            {{ Form::bsSelect2('city', ['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro', 'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah', 'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'],
            isset($property->city) ? str_replace(' ', '_',strtolower($property->city)) : null, ['required' => true, 'placeholder' => 'Select city','id' => 'add_city']) }}

            {{ Form::bsSelect2('location', [], null, ['required' => true, 'placeholder' => 'Select city location','id' => 'add_location']) }}
            <div class="text-center"><span><i class="fa fa-spinner fa-spin" style="font-size:20px; display:none"></i></span></div>


        @endif
    </div>

    <div class="card-header theme-blue text-white">Property Details</div>
    <div class="card-body">
        @if(isset($property))
            {{ Form::bsText('property_title', isset($property->title) ? $property->title : null, ['readonly' => 'readonly']) }}
        @else
            {{ Form::bsText('property_title', isset($property->title) ? $property->title : null, ['required' => true]) }}
        @endif
        {{ Form::bsTextArea('description', isset($property->description) ? $property->description : null, ['required' => true,'data-default' => 'Description should have almost 6144 characters']) }}


        @if(isset($property->price) && $property->price == 0)
            <div class="price-block" style="display:none">
                {{ Form::bsNumber('all_inclusive_price', null,['data-default' => 'Enter price in PKR (minimum price must be greater than 1000)', 'min' => 0, 'step' => 1000, 'data-help' => 'PKR']) }}
            </div>
            {{ Form::bsCheckbox('call_for_price_inquiry', ['1'=>'1'], ['required' => false, 'list'=> [(object) ['id' => 1, 'name' => '']], '']) }}
        @else
            <div class="price-block">
                {{ Form::bsNumber('all_inclusive_price', isset($property->price) ? str_replace(',', '', $property->price) : null, ['required' => true, 'data-default' => 'Enter price in PKR (minimum price must be greater than 1000)', 'min' => 0, 'step' => 1000, 'data-help' => 'PKR']) }}
            </div>
            {{ Form::bsCheckbox('call_for_price_inquiry', null, ['required' => false, 'list'=> [(object) ['id' => 1, 'name' => '']], '']) }}
        @endif

        {{ Form::bsNumber('land_area', isset($property->land_area) ? $property->land_area : null, ['required' => true, 'min' => 0, 'step' => 0.01]) }}
        @if(isset($default_area_unit))
            {{ Form::bsSelect2('unit',  ['Marla' => 'Marla', 'Square Feet' => 'Square Feet', 'Square Meters' => 'Square Meters', 'Square Yards' => 'Square Yards','Kanal'=>'Kanal'],
                isset($default_area_unit->default_area_unit) ? $default_area_unit->default_area_unit : null, ['required' => true, 'placeholder' => 'Select unit']) }}
        @else
            {{ Form::bsSelect2('unit',  ['Marla' => 'Marla', 'Square Feet' => 'Square Feet', 'Square Meters' => 'Square Meters', 'Square Yards' => 'Square Yards','Kanal'=>'Kanal'],
                isset($property->area_unit) ? $property->area_unit : null, ['required' => true, 'placeholder' => 'Select unit']) }}
        @endif
        <div class="selection-hide" style="display: none">
            {{ Form::bsSelect2('bedrooms', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10+'=>'10+'],
                   isset($property->bedrooms) ? strtolower($property->bedrooms) : null, [ 'placeholder' => 'Select Bedrooms']) }}
            {{ Form::bsSelect2('bathrooms', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10+'=>'10+'],
           isset($property->bathrooms) ? strtolower($property->bathrooms) : null, [ 'placeholder' => 'Select Bathrooms']) }}
        </div>
        <div class="form-group row btn-hide" style="display:none">
            <label for="features" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
                Features
            </label>
            <div class="col-sm-8 col-md-5">
                <a style="background-color: #007bff; color: white" class="btn-sm" data-toggle="modal" data-target="#featuresModalCenter">Add Features</a>
            </div>

        </div>
    </div>
    <div class="card-header theme-blue text-white">Property Images and Videos</div>
    <div class="card-body">
        @if(isset($property) and !$property->image->isEmpty())
            <div class="row border-bottom my-2">
                <div class="col-sm-12 text-bold my-2">Images</div>
                @foreach($property->image as $available_image)
                    <div class="col-md-4 col-sm-6 my-2">
                        <div style="position: relative; width: 70%; height: 50% ;margin:0 auto;">
                            <a class="btn" data-toggle-1="tooltip" data-placement="bottom" title="delete" data-toggle="modal" data-target="#delete-image" data-record-id="{{$available_image->id}}"
                               style="position: absolute; top: 0; right: 0; z-index: 1">
                                <i class="fad fa-times-circle fa-2x" style="color: red"></i>
                            </a>
                            <img src="{{asset('thumbnails/properties/'.explode('.',$available_image->name)[0].'-450x350.webp')}}" width="100%" class="img-responsive" alt="image not available"/>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        {{ Form::bsFile('image[]', null, ['required' => false, 'multiple'=>'multiple', 'data-default' => 'Image dimension: 750x600, File size: 256 KB']) }}

        <div class="mb-3"><span style="color:red">* </span>Image will be uploaded on form submission</div>

        @if(isset($property) and !$property->video->isEmpty())
            {{ Form::bsSelect2('video host', ['Youtube' => 'Youtube', 'Vimeo' => 'Vimeo', 'Dailymotion' => 'Dailymotion'],$property->video[0]->host,['required' => false, 'placeholder' => 'Select video host']) }}
            <div class="row border-bottom my-2">
                <div class="col-sm-12 text-bold my-2">Video</div>
                <div class="col-md-4 col-sm-6 my-2">
                    <div style="position: relative; width: 70%; height: 50% ;margin:0 auto;">
                        <a class="btn" data-toggle-1="tooltip" data-placement="bottom" title="delete" data-toggle="modal" data-target="#delete-video"
                           data-record-id="{{$property->video[0]->id}}"
                           style="position: absolute; top: 0; z-index: 1">
                            <i class="fad fa-times-circle fa-2x" style="color: red"></i>
                        </a>
                        <div>
                            @if($property->video[0]->host === 'Youtube')
                                <iframe src={{"https://www.youtube.com/embed/".explode('#',explode('?v=',$property->video[0]->name)[1])[0]}}></iframe>
                            @elseif($property->video[0]->host === 'Vimeo')
                                <iframe src={{"https://player.vimeo.com/video/".explode('.com/',$property->video[0]->name)[1]}}></iframe>
                            @else
                                <iframe src={{"//www.dailymotion.com/embed/video/".explode('?',explode('video/',$property->video[0]->name)[1])[0]."?quality=240&info=0&logo=0"}}></iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{ Form::bsSelect2('video host', ['Youtube' => 'Youtube', 'Vimeo' => 'Vimeo', 'Dailymotion' => 'Dailymotion'], null,['required' => false,'placeholder' => 'Select video host']) }}
            {{ Form::bsText('video link', null, ['required' => false]) }}
        @endif

        @if(isset($property) and !$property->floor_plan->isEmpty())
            <div class="row border-bottom my-2">
                <div class="col-sm-12 text-bold my-2">Floor Plans</div>
                @foreach($property->floor_plan as $available_image)
                    <div class="col-md-4 col-sm-6 my-2">
                        <label>{{$available_image->title}}</label>
                        <div style="position: relative; width: 70%; height: 50% ;margin:0 auto;">
                            <a class="btn" data-toggle-1="tooltip" data-placement="bottom" title="delete" data-toggle="modal" data-target="#delete-plan" data-record-id="{{$available_image->id}}"
                               style="position: absolute; top: 0; right: 0; z-index: 1">
                                <i class="fad fa-times-circle fa-2x" style="color: red"></i>
                            </a>
                            {{--                            <img src="{{asset('storage/floor_plans/'.$available_image->name)}}" width="100%" class="img-responsive" alt="image not available"/>--}}
                            <img src="{{asset('thumbnails/floor_plans/'.explode('.',$available_image->name)[0].'-750x600.webp')}}" width="100%" class="img-responsive" alt="image not available"/>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{ Form::bsFile('floor_plans[]', null, ['required' => false, 'multiple'=>'multiple','data-default' => 'Image dimension: 750x400, File size: 256 KB']) }}
        <div><span style="color:red">* </span>Floor plans will be uploaded on form submission</div>
    </div>
    @if(!empty($agencies))
        <div class="card-header theme-blue text-white">Agency Details</div>
        <div class="card-body">
            {{ Form::bsSelect2('agency', $agencies, isset($property->agency)? $property->agency : null, ['placeholder' => 'Select agency', 'data-default' => 'Select agency of the property']) }}
        </div>
    @endif
    <div class="card-header theme-blue text-white text-capitalize">Contact Details</div>
    <div class="card-body">
        {{ Form::bsText('contact_person', isset($property->contact_person) ? $property->contact_person : null, ['required' => true]) }}
        {{ Form::bsTel('phone', isset($property->phone) ? $property->phone : null, ['data-default' => 'E.g. 0511234567']) }}
        {{ Form::bsTel('mobile', isset($property->cell) ? $property->cell : null,  ['required' => true,'data-default' => 'E.g. 03001234567']) }}
        {{ Form::bsTel('fax', isset($property->fax) ? $property->fax : null,  ['data-default' => 'E.g. 0211234567']) }}
        {{ Form::bsEmail('contact_email', isset($property->email) ? $property->email : null, ['required' => true]) }}
    </div>

    <div class="card-header theme-blue text-white text-capitalize">Property Package</div>
    <div class="card-body">
        @if($property->basic_listing)
            {{ Form::bsRadio('property_package','Basic', ['id'=>'property-package','list' => ['Basic', 'Bronze', 'Silver','Golden','Platinum']]) }}
        @elseif($property->bronze_listing)
            {{ Form::bsRadio('property_package','Bronze', ['id'=>'property-package','list' => ['Basic', 'Bronze', 'Silver','Golden','Platinum']]) }}
        @elseif($property->silver_listing)
            {{ Form::bsRadio('property_package','Silver', ['id'=>'property-package','list' => ['Basic', 'Bronze', 'Silver','Golden','Platinum']]) }}
        @elseif($property->golden_listing)
            {{ Form::bsRadio('property_package','Golden', ['id'=>'property-package','list' => ['Basic', 'Bronze', 'Silver','Golden','Platinum']]) }}
        @elseif($property->platinum_listing)
            {{ Form::bsRadio('property_package','Platinum', ['id'=>'property-package','list' => ['Basic', 'Bronze', 'Silver','Golden','Platinum']]) }}
        @else
            {{ Form::bsRadio('property_package','Basic', ['id'=>'property-package','list' => ['Basic', 'Bronze', 'Silver','Golden','Platinum']]) }}
        @endif

    </div>
    <div class="card-header theme-blue text-white text-capitalize">Property Status</div>
    <div class="card-body">
        {{ Form::bsSelect2('status', ['active' => 'Active', 'edited' => 'Edited', 'pending' => 'Pending', 'expired' => 'Expired','sold' => 'Sold','rejected' => 'Rejected', 'deleted'=>'Deleted', 'rejected'=> 'Rejected'],
          isset($property->status) ? strtolower($property->status) : null, ['required' => true, 'placeholder' => 'Select Status','id'=>'status']) }}
        <div id="reason-of-rejection" style="display: none">
            {{ Form::bsText('rejection_reason',isset($property->rejection_reason)? $property->rejection_reason:null,['required'=> 'true']) }}
        </div>
    </div>

    <div class="card-footer">
        {{form::bsHidden('data-index',isset($property->id)? $property->id : null)}}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
    </div>
</div>


<!--Features modal-->

<div class="modal fade" id="featuresModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Select Features</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body" id="features-model"></div>
        </div>
    </div>
</div>
