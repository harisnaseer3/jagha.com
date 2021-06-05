<div>
    <div class="my-4">
        <div class="card my-4">
            <div class="card-header theme-blue text-white">
                <div class="font-14 font-weight-bold text-white">User Details</div>
            </div>
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-sm-4">
                        <strong> User ID :</strong> {{!empty($user)  ? $user['id']:''}}
                    </div>
                    <div class="col-sm-4">
                        <strong> User Email :</strong> {{!empty($user) ? $user['email']:''}}
                    </div>

                    <div class="col-sm-4">
                        <strong> User Name :</strong> {{!empty($user) ? $user['name']: ''}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="my-4">
        <div class="card my-4">
            <div class="card-header theme-blue text-white">
                <div class="font-14 font-weight-bold text-white">Assign Packages</div>
            </div>
            <div class="card-body">

                {{ Form::open(['route'=>['admin.package.complementary.store'],'method' => 'post', 'id'=> 'com-package-form']) }}

                {{ Form::hidden('user_id', isset($user) ? $user['id']:null) }}
                @if(isset($agencies) && count($agencies) > 0 )
                    {{ Form::bsRadio('package_for', 'Properties', ['required' => true, 'list' => ['Properties','Agency'],'display' => 'block','class'=>'mt-3']) }}
                    @error('package_for') <span class="error help-block text-red">{{ $message }}</span> @enderror
                    <div class="form-group row" id="agency_block">
                        <label for="name" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
                            Agency <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                            <select class="custom-select custom-select-agency select2bs4 select2-hidden-accessible agency-select2"
                                    style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                    name="agency" id="agency">
                                <option selected disabled>Select Agency</option>
                                @foreach($agencies as $index=> $agency)
                                    <option value={{$agency}} {{ (old('agency') == $agency) ? ' selected' : '' }}>
                                        {{$agency}}-{{$index}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif


                @if(isset($types))
                    <div class="form-group row">
                        <label for="package" class="col-sm-4 col-md-3 col-lg-2 col-xl-2 col-form-label col-form-label-sm">
                            Package
                            <span class="text-danger">*</span>
                        </label>

                        <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                            <select class="custom-select custom-select-agency select2bs4 select2-hidden-accessible"
                                    style="width: 100%;border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false"
                                    name="package" id="package">

                                <option selected disabled value="-1">Select package</option>
                                @foreach($types as $type)
                                    <option value= {{$type}} {{ (old('package') == $type) ? ' selected' : '' }} >{{$type}}</option>
                                @endforeach
{{--                                <option value='Gold' {{ (old('package') == 'Gold') ? ' selected' : '' }} >Gold</option>--}}
                            </select>
                        </div>
                        <div
                            class="offset-xs-4 col-xs-8 offset-sm-4 col-sm-8 offset-md-0 col-md-4 col-lg-4 col-xl-5 text-muted data-default-line-height my-sm-auto">
                            Select a Package
                        </div>
                    </div>
                @endif


                {{ Form::bsNumber('property_count', isset($package->property_count)?$package->property_count:0, ['required' => true, 'data-default' => 'Enter the number of Properties for selected package', 'min' => 1, 'step' => 1]) }}
                {{ Form::bsNumber('duration', 1, ['required' => true, 'data-default' => 'Enter Package Duration in Months', 'min' => 1, 'step' => 1]) }}


                {{ Form::bsRadio('is_complementary','Yes', ['list' => ['Yes','No'],'display' => 'block','class'=>'mt-3','required'=>true]) }}
                {{ Form::bsNumber('amount', 0, ['required' => true, 'disabled'=>true,'data-default' => 'Package Amount in Rs.']) }}
                {{ Form::hidden('unit_amount',null) }}
                <div class="form-group row">
                    <label for="status" class="col-sm-4 col-md-3 col-lg-2  col-xl-2 col-form-label col-form-label-sm">
                        Status
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5">
                        <select class="custom-select custom-select-agency select2bs4 select2-hidden-accessible"
                                style="width: 100%;border:0" tabindex="-1"
                                aria-hidden="true" aria-describedby="status-error" aria-invalid="false" required="" id="status" name="status"
                                data-select2-id="status">
                            <option value="" disabled>Select Status</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="expired">Expired</option>
                            <option value="rejected">Rejected</option>
                            <option value="deleted">Deleted</option>
                        </select>
                    </div>
                </div>

                {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md search-submit-btn']) }}
                {{ Form::close() }}

            </div>


        </div>
    </div>
</div>
