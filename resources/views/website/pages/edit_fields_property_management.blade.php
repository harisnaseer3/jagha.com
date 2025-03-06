<div class="card">
    <div class="card-header transition-background text-white">Property Type and Location</div>
    <div class="card-body">
        {{ Form::bsText('property_id', isset($property->id)?$property->id:null, ['readonly' => 'readonly']) }}
        {{ Form::bsText('property_reference', isset($property->reference)?$property->reference:null, ['readonly' => 'readonly']) }}
        {{ Form::bsText('purpose', isset($property->purpose)? $property->purpose : 'Sale', ['readonly' => 'readonly']) }}
        @if(isset($property->sub_purpose))
            {{ Form::bsText('wanted_for', $property->sub_type, ['readonly' => 'readonly']) }}
        @endif
        {{ Form::bsText('property_type', isset($property->type)? $property->type : 'Homes', ['readonly' => 'readonly']) }}

        {{ Form::bsText('property_subtype ' . $property->type, isset($property->sub_type)? $property->sub_type : '', ['readonly' => 'readonly','id'=>'subtype']) }}
        {{ Form::bsText('city', isset($property->city)? $property->city : null, ['readonly' => 'readonly']) }}
        {{ Form::bsText('location', isset($property->location)? $property->location->name : null, ['readonly' => 'readonly']) }}
    </div>

    <div class="card-header transition-background text-white">Property Details</div>
    <div class="card-body">
        {{ Form::bsText('property_title', isset($property->title) ? $property->title : null, ['readonly' => 'readonly']) }}

        {{ Form::bsTextArea('description', isset($property->description) ? $property->description : null, ['required' => true,'data-default' => 'Minimum of 50 characters required','minlength' => '50']) }}

        <div class="price-block">
            {{ Form::bsNumber('all_inclusive_price', isset($property->price) ? str_replace(',', '', $property->price) : null, ['required' => true, 'data-default' => 'Price has a minimum value of PKR 1000', 'min' => 0, 'step' => 1000, 'data-help' => 'PKR']) }}
        </div>

        {{ Form::bsNumber('land_area', isset($property->land_area) ? $property->land_area : null, ['required' => true, 'min' => 0, 'step' => 0.01]) }}
        @if(isset($default_area_unit))
            {{ Form::bsSelect2('unit',  ['Square Feet' => 'Square Feet', 'Square Meters' => 'Square Meters', 'Square Yards' => 'Square Yards','Marla' => 'Marla','Kanal'=>'Kanal'],
                isset($default_area_unit->default_area_unit) ? $default_area_unit->default_area_unit : null, ['required' => true, 'placeholder' => 'Select unit']) }}
        @else
            {{ Form::bsSelect2('unit',  ['Square Feet' => 'Square Feet', 'Square Meters' => 'Square Meters', 'Square Yards' => 'Square Yards','Marla' => 'Marla', 'Kanal'=>'Kanal'],
                isset($property->area_unit) ? $property->area_unit : null, ['required' => true, 'placeholder' => 'Select unit']) }}
        @endif

        <div class="selection-hide" style="display: none">
            {{ Form::bsSelect2('bedrooms', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10+'=>'10+'],
                   isset($property->bedrooms) ? strtolower($property->bedrooms) : null, [ 'placeholder' => 'Select Bedrooms']) }}
            {{ Form::bsSelect2('bathrooms', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10+'=>'10+'],
           isset($property->bathrooms) ? strtolower($property->bathrooms) : null, [ 'placeholder' => 'Select Bathrooms']) }}
        </div>
        @if(isset($property->features))
            <div class="form-group  row">
                <label for="features" class="col-sm-4 col-md-2 col-form-label col-form-label-sm">
                    Features
                </label>
                <div class="col-sm-8 col-md-5">
                    <a style="background-color: #007bff; color: white" class="btn-sm" data-toggle="modal" data-target="#featuresModalCenter">Select Features</a>
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
                    <a style="background-color: #007bff; color: white" class="btn-sm" data-toggle="modal" data-target="#featuresModalCenter">Select Features</a>
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
    <div class="card-header transition-background text-white property-media-block" style="display: block">Property Images and Videos</div>
    <div class="card-body property-media-block" style="display: block">
        @if(isset($property) and !$property->images->isEmpty())
            <div class="row border-bottom my-2">
                <div class="col-sm-12 text-bold my-2"><strong>Total Images
                        <span id="edit-count" class="badge badge-primary badge-pill ml-2 f-12" data-count="{{count($property->images)}}"></span>
                        <span id="image-count" class="badge badge-primary badge-pill ml-2 f-12" style="display: none" data-count=0></span>
                    </strong>
                </div>
                <ul id="sortable" class="row m-2">
                    @foreach($property->images as $available_image)
                        <li class="ui-state-default m-2 upload-image-block ui-sortable-handle">
                            <div style="position: relative; width: 100%; height: 50% ;margin:0 auto;">
                                <img src="{{asset('thumbnails/properties/'.explode('.' , $available_image->name)[0].'-450x350.webp')}}"
                                     width="100%" class="img-responsive" alt="image not available" data-num="{{$available_image->order}}" data-value="{{$available_image->name}}"/>
                            </div>
                            <div class="badge badge-primary badge-pill p-2 f-12" style="position: absolute; ; margin-left: 130px;  margin-top: 65px; z-index: 99;">{{$available_image->order}}</div>
                            <a class="btn delete-image-btn" data-toggle-1="tooltip" data-placement="bottom" data-record-id="{{$available_image->id}}"
                               title="delete" style="position: absolute; margin-left: 146px;
                            margin-top: 56px; z-index: 1"> <i class="fad fa-trash fa-1x" style="color: red;font-size: 30px"></i> </a>
                        </li>


                    @endforeach
                </ul>
            </div>
            <div id="edit-count" data-count="{{count($property->images)}}"></div>
            <span id="image-count" class="badge badge-primary badge-pill ml-2 f-12" style="display: none" data-count=0></span>

            <div class="text-center"><span><i class="fa fa-spinner fa-spin" id="show_image_spinner" style="font-size:20px; display:none"></i></span></div>
            <div class="add-images" style="display: none"></div>
        @else
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
        @endif


        {{ Form::bsFile('image[]', null, ['required' => false, 'multiple'=>'multiple', 'data-default' => 'Supported formats: (png, jpg, jpeg), File size: 256 KB']) }}
        {{form::bsHidden('image', old('image'),['id'=>'store-images'])}}
        <div class="mb-2 ">
            <a style="background-color: #007bff; color: white;display: none" id="property-image-btn" class="btn-sm btn image-upload-btn">
                Upload Images</a>
        </div>
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
            {{ Form::bsSelect2('video_host', ['Youtube' => 'Youtube', 'Vimeo' => 'Vimeo', 'Dailymotion' => 'Dailymotion'], null ,['required' => false,'placeholder' => 'Select video host']) }}
            {{ Form::bsText('video_link', null, ['required' => false]) }}
        @endif
    </div>

    @if(!isset($property->agency))
        <div class="card-header transition-background text-white">Property Advertisement Type</div>
        <div class="card-body">
            {{ Form::bsRadio('advertisement', old('advertisement')=='Agency'?'Agency':'Individual', ['list' => ['Individual', 'Agency'],'id'=>'ad_type']) }}
        </div>
        <div id="user-agency-block" style="display: none">
            <div class="card-header transition-background text-white">Agency Details</div>
            <div class="card-body">
                {{ Form::bsSelect2('agency', $agencies, isset($property->agency)? $property->agency->id : null,[ 'data-default' => 'Select agency of the property','id'=>'agency']) }}
                <div class="agency-block" style="display:none"></div>
            </div>
        </div>
        {{--        <div id="agency-user-block">--}}
        {{--            <div class="card-header theme-blue text-white text-capitalize">Contact Details</div>--}}
        {{--            <div class="card-body">--}}
        {{--                <div class="text-center"><span><i class="fa fa-spinner fa-spin contact_person_spinner" style="font-size:20px; display:none"></i></span></div>--}}
        {{--                <div class="agency-user-block" style="display: none">--}}
        {{--                    {{ Form::bsSelect('contact_person', [], ['placeholder' => 'Select contact person','id'=>'contact_person']) }}--}}
        {{--                </div>--}}
        {{--                <div class="text-center"><span><i class="fa fa-spinner fa-spin select_contact_person_spinner" style="font-size:20px; display:none"></i></span></div>--}}

        {{--                <div class="contact-person-block" style="display: block">--}}
        {{--                    {{ Form::bsText('contact_person', isset($property->contact_person) ? $property->contact_person : \Illuminate\Support\Facades\Auth::user()->name, ['required' => true, 'id'=>'contact_person_input']) }}--}}
        {{--                </div>--}}

        {{--                <div class="user-details-block" style="display:block">--}}
        {{--                    @if(isset($property->phone))--}}
        {{--                        {{ Form::bsIntlTel('phone_#', $property->phone, ['id'=>'phone']) }}--}}
        {{--                    @else--}}
        {{--                        {{ Form::bsIntlTel('phone_#', \Illuminate\Support\Facades\Auth::user()->phone, ['id'=>'phone']) }}--}}
        {{--                    @endif--}}

        {{--                    {{Form::hidden('phone_check')}}--}}

        {{--                    {{ Form::bsIntlTel('mobile_#', isset($property->cell) ? $property->cell : \Illuminate\Support\Facades\Auth::user()->cell,  ['required' => true,'id'=>'cell']) }}--}}
        {{--                    {{ Form::bsEmail('contact_email', isset($property->email) ? $property->email : \Illuminate\Support\Facades\Auth::user()->email, ['required' => true]) }}--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div id="agency-user-block">
            <div class="card-header transition-background text-white text-capitalize">Contact Details</div>
            <div class="card-body">
                <div class="text-center"><span><i class="fa fa-spinner fa-spin contact_person_spinner" style="font-size:20px; display:none"></i></span></div>
                <div class="agency-user-block" style="display: none">
                    {{ Form::bsSelect('contact_person', [] ,null, ['placeholder' => 'Select contact person','id'=>'contact_person']) }}
                </div>

                <div class="text-center"><span><i class="fa fa-spinner fa-spin select_contact_person_spinner" style="font-size:20px; display:none"></i></span></div>

                <div class="contact-person-block" style="display: block">
                    {{ Form::bsText('contact_person', isset($property->contact_person) ? $property->contact_person : \Illuminate\Support\Facades\Auth::user()->name, ['required' => true, 'id'=>'contact_person_input']) }}
                </div>

                <div class="user-details-block" style="display:block">
                    @if(isset($property->phone))
                        {{ Form::bsIntlTel('phone_#', $property->phone, ['id'=>'phone','value'=> $property->phone]) }}
                    @else
                        {{ Form::bsIntlTel('phone_#', \Illuminate\Support\Facades\Auth::user()->phone, ['id'=>'phone','value'=> \Illuminate\Support\Facades\Auth::user()->phone]) }}
                    @endif

                    {{Form::hidden('phone_check')}}


                    @if(isset($property->cell))
                        {{ Form::bsIntlTel('mobile_#', $property->cell,  ['required' => true,'id'=>'cell','value'=> $property->cell]) }}
                    @else
                        {{ Form::bsIntlTel('mobile_#', \Illuminate\Support\Facades\Auth::user()->cell,  ['required' => true,'id'=>'cell','value'=> \Illuminate\Support\Facades\Auth::user()->cell]) }}
                    @endif
                    {{ Form::bsEmail('contact_email', isset($property->email) ? $property->email : \Illuminate\Support\Facades\Auth::user()->email, ['required' => true]) }}
                </div>
            </div>
        </div>
    @else
        <div class="card-header transition-background text-white">Property Advertisement Type</div>
        <div class="card-body">
            {{ Form::bsRadio('advertisement','Agency', ['list' => ['Individual', 'Agency'],'id'=>'ad_type']) }}
        </div>
        <div id="user-agency-block" style="display: block">
            <div class="card-header transition-background text-white">Agency Details</div>
            <div class="card-body">
                {{ Form::bsSelect2('agency', $agencies, isset($property->agency)? $property->agency->id : null,[ 'data-default' => 'Select agency of the property','id'=>'agency']) }}

                <div class="agency-block">
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
                </div>
            </div>
        </div>

        <div id="agency-user-block">
            <div class="card-header transition-background text-white text-capitalize">Contact Details</div>
            <div class="card-body">
                <div class="text-center"><span><i class="fa fa-spinner fa-spin contact_person_spinner" style="font-size:20px; display:none"></i></span></div>
                <div class="agency-user-block" style="display: block">
                    <div class="form-group row">
                        <label for="contact_person" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
                            Contact Person
                        </label>
                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                            <select class="custom-select custom-select-sm valid" aria-describedby="contact_person-error" aria-invalid="false"
                                    id="contact_person" name="contact_person" required="required"
                                    style="border: 1px solid rgb(206, 212, 218); border-radius: 0.25rem;">
                                @foreach($users as $key=>$option)
                                    <option {{$option === $property->contact_person? 'selected' : '' }} value={{$key}} data-name={{$option}}>{{$option}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>


                <div class="text-center"><span><i class="fa fa-spinner fa-spin select_contact_person_spinner" style="font-size:20px; display:none"></i></span></div>

                <div class="contact-person-block" style="display: none">
                    {{ Form::bsText('contact_person', isset($property->contact_person) ? $property->contact_person : \Illuminate\Support\Facades\Auth::user()->name, ['required' => true, 'id'=>'contact_person_input']) }}
                </div>

                <div class="user-details-block" style="display:block">
                    @if(isset($property->phone))
                        {{ Form::bsIntlTel('phone_#', $property->phone, ['id'=>'phone','value'=>$property->phone]) }}
                    @else
                        {{ Form::bsIntlTel('phone_#', \Illuminate\Support\Facades\Auth::user()->phone, ['id'=>'phone','value'=>\Illuminate\Support\Facades\Auth::user()->phone]) }}
                    @endif

                    {{Form::hidden('phone_check')}}

                    @if(isset($property->cell))
                        {{ Form::bsIntlTel('mobile_#', $property->cell,  ['required' => true,'id'=>'cell','value'=>$property->cell]) }}
                    @else
                        {{ Form::bsIntlTel('mobile_#', \Illuminate\Support\Facades\Auth::user()->cell,  ['required' => true,'id'=>'cell','value'=> \Illuminate\Support\Facades\Auth::user()->cell]) }}
                    @endif

                    {{ Form::bsEmail('contact_email', isset($property->email) ? $property->email : \Illuminate\Support\Facades\Auth::user()->email, ['required' => true]) }}
                </div>
            </div>
        </div>
    @endif


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
