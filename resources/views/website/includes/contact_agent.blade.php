<div class="sidebar widget mb-2">
    <h3 class="sidebar-title">Contact Seller</h3>
    <div class="s-border"></div>
    <div class="m-border"></div>
    <div class="Subscribe-box" aria-label="Agency contact form">
        {{ Form::open(['route'=>['contact'],'method' => 'post','role' => 'form', 'id'=> 'email-contact-form', 'role' => 'form']) }}
        <div><label class="mt-2">Name<span style="color:red">*</span></label></div>
        {{ Form::text('name', \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->name:null, array_merge(['required'=>'true','class' => 'form-control form-control-sm user-name' , 'aria-describedby' => 'name' . '-error', 'aria-invalid' => 'false', 'placeholder'=>'Name'])) }}
        <div><label class="mt-2">Email<span style="color:red">*</span></label></div>
        {{ Form::email('email', \Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->email:null, array_merge(['required'=>'true','class' => 'form-control form-control-sm user-email', 'aria-describedby' => 'email' . '-error', 'aria-invalid' => 'false', 'placeholder'=> "name@domain.com"])) }}
        <div><label class="mt-2">Phone (03001234567)<span style="color:red">*</span></label></div>
        {{ Form::tel('phone', null, array_merge(['required'=>'true','class' => 'form-control form-control-sm', 'aria-describedby' => 'phone' . '-error', 'aria-invalid' => 'false','placeholder'=>"03001234567"])) }}
        <div><label class="mt-2">Message<span style="color:red">*</span></label></div>
        <div class="editable form-control form-control-sm valid editable-div" contenteditable="true">
            I would like to gather information about your property <a href="{{$property->property_detail_path()}}" style="text-decoration:underline; color:blue">{{$property->title}} </a> being
            displayed at <a href="https://www.aboutpakistan.com" style="text-decoration:underline; color:blue">https://www.aboutpakistan.com </a> <br><br> Please contact me at your earliest by phone
            or by email.
        </div>
        {!! Form::hidden('message', null, array_merge(['class' => 'form-control form-control-sm' , 'aria-describedby' => 'message' . '-error', 'aria-invalid' => 'false', 'rows' => 3, 'cols' => 10, 'style' => 'resize:none'])) !!}
        <div class="mt-2">
            {{ Form::bsRadio('i am','Buyer', [ 'list' => ['Buyer', 'Agent']]) }}
        </div>
        @if(!empty($agency))
            {{ Form::hidden('agency',$agency->id)}}
        @else
            {{ Form::hidden('property',$property->id)}}
        @endif
        <div class="text-center">
            @if($property->email == null)
                <button class="btn btn-block mt-2 btn-email disabled" data-toggle="tooltip" data-placement="top" data-html="true" title ="<div>Currently not available</div>" >Email</button>
            @else
                {{ Form::submit('Email', ['class' => 'btn search-submit-btn btn-block btn-email','id'=>'send-mail']) }}
            @endif
        </div>
        {{ Form::close() }}
        <button class="btn btn-block mt-2 btn-call" data-toggle="modal" data-target="#CallModel">Call</button>
    </div>
</div>

<!--model-->
<div class="modal fade" id="CallModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
        <div class="modal-content">
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
                        <div class="mb-2"><a href="{{$property->property_detail_path()}}" class="font-weight-bold title-font"
                                             title="{{$property->sub_type}} for {{$property->purpose}}">{{ $property->title }}</a></div>

                        <div class="mb-2 font-weight-bold"> {{ $property->agency !== null ? $property->agency->title: '' }} </div>
                        <div class="mb-2">Please use property reference</div>
                        <div class="mb-2" style="font-weight: bold"> {{ $property->reference }} </div>
                        <div class="mb-2">While calling please mention <a class="hover-color link-font" href="https://www.aboutpakistan.com/">https://www.aboutpakistan.com</a></div>

                    </div>

                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td class="w-30">Mobile</td>
                            <td class="w-70 font-weight-bold">{{ $property->cell !== null ? $property->cell: '-'}}</td>
                        </tr>
                        <tr>
                            <td>Phone No</td>
                            @if($property->phone !== null)
                                <td class="font-weight-bold">{{$property->phone}}</td>
                            @elseif($property->agency_cell !== null)
                                <td class="font-weight-bold">{{$property->agency_cell}}</td>
                            @else
                                <td class="font-weight-bold">-</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Agent</td>
                            <td class="font-weight-bold">{{ $property->contact_person != ''? $property->contact_person:$property->agent}}</td>
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
            <div class="modal-body">
                <div class="container">
                    <div class="text-center">
                        <i class="fas fa-check-circle fa-3x" style="color: #28a745"></i>
                        <div class="m-3" style="font-size: 14px">Message sent successfully</div>
                        <div class="mb-2 line-height">Add <span class="theme-dark-blue">info@aboutpakistan.com </span> to your white list to get email from us.</div>
                        <button class="btn btn-email" data-dismiss="modal">Dismiss</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
