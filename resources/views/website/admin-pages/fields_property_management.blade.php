<div class="card">

    <div class="card-header theme-blue text-white">User Detail</div>
    <div class="card-body">
        {{ Form::bsEmail('user_email',null, ['required' => true]) }}

    </div>
    <div class="card-header theme-blue text-white">Property Type and Location</div>
    <div class="card-body">
        {{ Form::bsRadio('purpose', isset($property->purpose)? $property->purpose : 'Sale', ['required' => true, 'list' => ['Sale', 'Rent', 'Wanted']]) }}
        {{Form::hidden('purpose-error')}}
        <div id="purpose-Wanted" style="display: none;">
            {{ Form::bsRadio('wanted_for', isset($property->sub_purpose)? $property->sub_purpose : '', ['list' => ['Buy', 'Rent']]) }}
            {{Form::hidden('wanted_for-error')}}
        </div>

        {{ Form::bsRadio('property_type',isset($property->type)? $property->type : 'Homes', ['required' => true, 'list' => ['Homes', 'Plots', 'Commercial']]) }}
        {{Form::hidden('property_type-error')}}
        @foreach($property_types as $property_type)
            <div id="property_subtype-{{ $property_type->name }}" style="display: none;">
                {{ Form::bsRadio('property_subtype-' . $property_type->name, isset($property->sub_type)? $property->sub_type : '',
                ['list' => json_decode($property_type->sub_types)]) }}
            </div>
        @endforeach
        {{Form::hidden('property_subtype-error')}}

        {{ Form::bsSelect2('city', ['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro', 'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah', 'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'],
        isset($property->city) ? str_replace(' ', '_',strtolower($property->city)) : null, ['required' => true, 'placeholder' => 'Select city','id' => 'add_city']) }}

        {{ Form::bsSelect2('location', [], null, ['required' => true, 'placeholder' => 'Select city location','id' => 'add_location']) }}
        <div class="text-center"><span><i class="fa fa-spinner fa-spin" style="font-size:20px; display:none"></i></span></div>

        <div class="font-14 my-3"><span>OR</span></div>

        {{ Form::bsText('add_location',old('add_location'), ['placeholder' => 'Add Location','id' => 'other_location']) }}
        {{--            {{ Form::bsText('add_location', old('add_location'), ['readonly' => 'readonly']) }}--}}

        {{Form::hidden('location-error')}}
    </div>

    <div class="card-header theme-blue text-white">Property Details</div>
    <div class="card-body">
        {{ Form::bsText('property_title', isset($property->title) ? $property->title : null, ['required' => true]) }}
        {{ Form::bsTextArea('description', isset($property->description) ? $property->description : null, ['required' => true,'data-default' => 'Minimum of 50 characters required' ,'minlength' => '50']) }}

        <div class="price-block">
            {{ Form::bsNumber('all_inclusive_price', isset($property->price) ? str_replace(',', '', $property->price) : null, ['required' => true, 'data-default' => 'Price has a minimum value of PKR 1000', 'min' => 0, 'step' => 1000, 'data-help' => 'PKR']) }}
        </div>

        {{ Form::bsNumber('land_area', isset($property->land_area) ? $property->land_area : null, ['required' => true, 'min' => 0, 'step' => 0.01]) }}

        {{ Form::bsSelect2('unit',  ['Square Feet' => 'Square Feet', 'Square Meters' => 'Square Meters', 'Square Yards' => 'Square Yards','Marla' => 'Marla', 'Kanal'=>'Kanal'],
            isset($property->area_unit) ? $property->area_unit : null, ['required' => true, 'placeholder' => 'Select unit']) }}
        <div class="selection-hide" style="display: none">
            {{ Form::bsSelect2('bedrooms', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10+'=>'10+'],
                   isset($property->bedrooms) ? strtolower($property->bedrooms) : null, [ 'placeholder' => 'Select Bedrooms']) }}
            {{ Form::bsSelect2('bathrooms', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10+'=>'10+'],
           isset($property->bathrooms) ? strtolower($property->bathrooms) : null, [ 'placeholder' => 'Select Bathrooms']) }}
        </div>
        @if(isset($property->features))
            <div class="form-group row" style="display:block">
                <label for="features" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
                    Features
                </label>
                <div class="col-sm-8 col-md-5">
                    <button style="background-color: #007bff; color: white" class="btn-sm" data-toggle="modal" data-target="#featuresModalCenter">Add Features</button>
                </div>
            </div>
            <div class="row">
                <label for="features" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
                    Selected Features
                </label>
                <div class="col-sm-8 col-md-5">
                    <div class="feature-tags">
                        <alert class="alert alert-secondary feature-alert"><i class="fa fa-info-circle fa-2x mr-2 theme-dark-blue"></i> All the selected features will appear here</alert>
                    </div>
                </div>
            </div>

        @else
            <div class="form-group row btn-hide" style="display:none">
                <label for="features" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
                    Features
                </label>
                <div class="col-sm-8 col-md-5">
                    <a style="background-color: #007bff; color: white" class="btn-sm" data-toggle="modal" data-target="#featuresModalCenter">Add Features</a>
                </div>
            </div>
            <div class="row btn-hide">
                <label for="features" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
                    Selected Features
                </label>
                <div class="col-sm-8 col-md-5">
                    <div class="feature-tags">
                        <alert class="alert alert-secondary feature-alert"><i class="fa fa-info-circle fa-2x mr-2 theme-dark-blue"></i> All the selected features will appear here</alert>
                    </div>

                </div>
            </div>
        @endif
        {{Form::hidden('features-error')}}
    </div>
    <div class="card-header theme-blue text-white property-media-block" style="display: block">Property Images and Videos</div>
    <div class="card-body property-media-block" style="display: block">

        <div class="text-center"><span><i class="fa fa-spinner fa-spin" id="show_image_spinner" style="font-size:20px; display:none"></i></span></div>
        <div class="add-images" style="display: none">
            <div class="col-sm-12 text-bold my-2">
                <strong>Total Images
                    <span id="image-count" class="badge badge-primary badge-pill ml-2 f-12" style="display: none" data-count=0></span>
                </strong>
            </div>
            <ul id="sortable" class="row border-bottom my-2 ">
            </ul>
        </div>

        {{ Form::bsFile('image[]', null, ['required' => false, 'multiple'=>'multiple', 'data-default' => 'Supported formats: (png, jpg, jpeg), File size: 256 KB']) }}
        {{form::bsHidden('image', old('image'),['id'=>'store-images'])}}

        <div class="mb-2 ">
            <a style="background-color: #007bff; color: white;display: none" id="property-image-btn" class="btn-sm btn image-upload-btn">
                Upload Images</a>
        </div>

        {{ Form::bsSelect2('video_host', ['Youtube' => 'Youtube', 'Vimeo' => 'Vimeo', 'Dailymotion' => 'Dailymotion'], null ,['required' => false,'placeholder' => 'Select video host']) }}
        {{ Form::bsText('video_link', null, ['required' => false]) }}
    </div>
    <div class="card-header theme-blue text-white">Property Advertisement Type</div>
    <div class="card-body">
        @if(isset($property->agency))
            {{ Form::bsRadio('advertisement', 'Agency', ['list' => ['Individual', 'Agency'],'id'=>'ad_type']) }}
        @else
            {{ Form::bsRadio('advertisement', old('advertisement')=='Agency'?'Agency':'Individual', ['list' => ['Individual', 'Agency'],'id'=>'ad_type']) }}
        @endif

    </div>

    <div class="agency_category">
        <div class="card-header theme-blue text-white">Agency Details</div>
        <div class="card-body">
            {{ Form::bsText('property_agency', isset($property->agency)? $property->agency->id .'-' .$property->agency->title : null,
                ['required' => true,'data-id'=>isset($property->agency)?$property->agency->id:null]) }}
            {{Form::hidden('property_agency-error')}}
            {{Form::hidden('property_user-error')}}

            {{Form::hidden('agency',isset($property->agency)?$property->agency->id:null)}}
            <div class="agency-block">
                @if(isset($property->agency))
                    <div class="row">
                        <div class="col-sm-4 col-md-3 col-lg-2  col-xl-2">
                            <div class="my-2"> Agency Information</div>
                        </div>
                        <div class="col-sm-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="col-md-6 my-2">
                                <strong>Title: </strong>{{$property->agency->title}}
                            </div>

                            <div class="col-md-6 my-2">
                                <strong>Address: </strong> {{$property->agency->address}}
                            </div>

                            <div class="col-md-6 my-2">
                                <strong>City: </strong> {{$property->agency->city->name}}
                            </div>

                            <div class="col-md-6 my-2">
                                <strong>Phone: </strong> {{$property->agency->phone}}
                            </div>

                            <div class="col-md-6 my-2">
                                <strong>Cell: </strong> {{$property->agency->cell}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            {{--            @endif--}}
            <div id="agency-loading">
                Fetching Agencies <i class="fa fa-spinner fa-spin" style="font-size:20px;"></i>
            </div>
            <div id="agency-loaded" style="display: none">
                <button style="background-color: #007bff; color: white;" class="btn btn-sm" data-toggle="modal" data-target="#agenciesModalCenter" id="agency-change">
                    Select/Change Agency
                </button>
            </div>

        </div>
    </div>
    <div id="agency-user-block">
        <div class="card-header theme-blue text-white text-capitalize">Contact Details</div>
        <div class="card-body">
            <div class="text-center"><span><i class="fa fa-spinner fa-spin contact_person_spinner" style="font-size:20px; display:none"></i></span></div>
            <div class="agency-user-block" style="display: none">
                <div class="form-group row">
                    <label for="contact_person" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
                        Contact Person
                    </label>
                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                        <select class="custom-select custom-select-sm valid" aria-describedby="contact_person-error" aria-invalid="false"
                                id="contact_person" name="contact_person" required="required"
                                style="border: 1px solid rgb(206, 212, 218); border-radius: 0.25rem;">
                        </select>

                    </div>

                </div>
            </div>
            <div class="text-center"><span><i class="fa fa-spinner fa-spin select_contact_person_spinner" style="font-size:20px; display:none"></i></span></div>


            <div class="contact-person-block" style="display: block">
                {{ Form::bsText('contact_person', isset($property->contact_person) ? $property->contact_person : '', ['required' => true, 'id'=>'contact_person_input']) }}
            </div>
            <div class="user-details-block" style="display:block">
                {{ Form::bsIntlTel('phone_#',isset($property->phone)? $property->phone:'', ['id'=>'phone','value'=>isset($property->phone)?$property->phone:'']) }}

                {{Form::hidden('phone_check')}}

                {{ Form::bsIntlTel('mobile_#', isset($property->cell) ? $property->cell :'',  ['required' => true,'id'=>'cell','value'=>isset($property->cell)?$property->cell:'']) }}
                {{ Form::bsEmail('contact_email', isset($property->email) ? $property->email :'', ['required' => true]) }}
            </div>
        </div>
    </div>

    <div class="card-header theme-blue text-white text-capitalize">Property Status</div>
    <div class="card-body">
        <div class="form-group row">
            <label for="status" class="col-sm-4 col-md-3 col-lg-2  col-xl-2 col-form-label col-form-label-sm">
                Status
                <span class="text-danger">*</span>
            </label>

            <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                <select class="custom-select custom-select-sm select2 select2-hidden-accessible" style="width: 100%; border: 1px solid rgb(206, 212, 218); border-radius: 0.25rem;" tabindex="-1"
                        aria-hidden="true" aria-describedby="status-error" aria-invalid="false" required="" id="status" name="status" data-select2-id="status">
                    <option value="" disabled>Select Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="expired">Expired</option>
                    <option value="sold">Sold</option>
                    <option value="rejected">Rejected</option>
                    @can('Delete Properties')
                        <option value="deleted">Deleted</option>
                    @endcan
                </select>
            </div>

        </div>


        <div id="reason-of-rejection" style="display: none">
            {{ Form::bsText('rejection_reason',isset($property->rejection_reason)? $property->rejection_reason:null) }}
        </div>
        {{--        @if($property->location->is_active == 0)--}}
        {{--            <div class="m-0 pb-2" id="verification-badge" style=""><i class="fas fa-warning color-red"></i> <span class="mx-1 color-red font-12">Verify Property Location</span></div>--}}
        {{--        @endif--}}
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

<!--Agencies modal-->


