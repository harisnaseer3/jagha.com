<div class="sidebar widget mb-2">
    <h3 class="sidebar-title">Contact Agent</h3>
    <div class="s-border"></div>
    <div class="m-border"></div>
    <div class="Subscribe-box" aria-label="Agency contact form">
        {{ Form::open(['route'=>['contact'],'method' => 'post','role' => 'form', 'id'=> 'email-contact-form', 'role' => 'form']) }}
        <div><label class="mt-2">Name<span style="color:red">*</span></label></div>
        {{ Form::text('name', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm' , 'aria-describedby' => 'name' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"Name"])) }}
        <div><label class="mt-2">Email<span style="color:red">*</span></label></div>
        {{ Form::email('email', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'email' . '-error', 'aria-invalid' => 'false', 'placeholder'=>"name@domain.com"])) }}
        <div><label class="mt-2">Phone<span style="color:red">*</span></label></div>
        {{ Form::tel('phone', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'phone' . '-error', 'aria-invalid' => 'false','placeholder'=>"+92-300-1234567"])) }}
        <div><label class="mt-2">Meassage<span style="color:red">*</span></label></div>
        {!! Form::textarea('message',
        'I would like to inquire about your property ['.$property->reference.']. Please contact me at your earliest convenience.', array_merge(['class' => 'form-control form-control-sm' , 'aria-describedby' => 'message' . '-error', 'aria-invalid' => 'false', 'rows' => 3, 'cols' => 10, 'style' => 'resize:none'])) !!}
        <div class="mt-2">
            {{ Form::bsRadio('i am','Buyer', ['required' => true, 'list' => ['Buyer', 'Agent', 'Other']]) }}
        </div>
        @if(!empty($agency))
            {{ Form::hidden('agent',$agency->id)}}
        @else
            {{ Form::hidden('property',$property->id)}}
        @endif
        <div class="text-center">
            {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block btn-success','id'=>'send-mail']) }}
        </div>
        {{ Form::close() }}
        <button class="btn btn-block btn-outline-success mt-2" data-toggle="modal" data-target="#CallModel">Call</button>
    </div>
</div>

<!--model-->
<div class="modal fade" id="CallModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
        <div class="modal-content" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">
            <!--Header-->
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Contact Us</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">
                <div class="container" style="font-size: 12px; color: #555">
                    <div class="text-center">
                        <div> {{ $property->agency !== null ? $property->agency: '' }} </div>
                        <div>Please use property reference</div>
                        <div style="font-weight: bold"> {{ $property->reference }} </div>
                        <div>while calling us</div>
                    </div>

                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td class="w-30">Mobile</td>
                            <td class="w-70 font-weight-bold">{{ $property->phone !== null ? $property->cell: '-'}}</td>
                        </tr>
                        <tr>
                            <td>Phone No</td>
                            <td class="font-weight-bold">{{$property->phone !== null ?$property->phone :''}}</td>
                        </tr>
                        <tr>
                            <td>Agent</td>
                            <td class="font-weight-bold">{{ ucwords($property->contact_person) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EmailConfirmModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
        <div class="modal-content">
            <!--Body-->
            <div class="modal-body" style="border-bottom: #28a745 5px solid; border-top: #28a745 5px solid; border-radius: 5px">
                <div class="container">
                    <div class="text-center">
                        <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>
                        <div class="m-3" style="font-size: 14px">Message sent successfully</div>
                        <div class="mb-2">Add email@aboutpakistan.com to your white list to get email from us.</div>
                        <button class="btn btn-success" data-dismiss="modal">Dismiss</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
