@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title> Property Management By Property.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <style type="text/css" id="custom-background-css">
        body.custom-background {
            background-color: #eeeeee;
        }
        .card{
            background-color: white;
            margin:5%;
            padding: 5%;
        }
        .heading-support{
            font-weight:500;
            font-size:xx-large;
            color:black;
            text-align:center;

        }
        .mid-heading {
            color:black;
            text-align:center;
            font-stretch: expanded;
            font-size: 18px;

        }
        hr.new2 {
            border-top: 2px dashed #999999;
        }
        hr.new1 {
            border-top: 2px solid #999999;
        }
        .padding-left{
            padding-left:15%;
        }
        .contact-info {
            color:black;
            font-size:15px;

        }
        .color-white{
            color:black;
        }
        .padding-right{
            padding-right: 15%;;
        }
        hr {
            clear:both;
            display:block
        }
        .divider {
            display: inline-block;
            border-bottom: #999999 1px solid;
            width: 100%;
        }
        .container-fluid{
            padding:0% !important;
        }

        .media-hover .fa-2x:hover{
            color: black;
        }
        .div-center{
            display: flex;
            justify-content: center;
        }
        .media-padding{
            padding: 0% !important;
        }
        .fa-2x {
            color: #999;
            font-size: 17px;
        }
       .mt-support{
           margin-top:40px;
       }
    </style>
@endsection

@section('content')
@include('website.includes.dashboard-nav')

    <!-- Submit Property start -->
    <div class="submit-property mt-support">
                            <div class="mt-5">
                                <div class="card">
                                    <div class="row">
                                        <div class = "col-md-12 col-sm-12 mb-5" >
                                            <h2 class="heading-support">SUPPORT CENTER</h2>
                                            <hr class="new2">

                                            <p class="mid-heading">We'd  <i class="fa fa-heart-o color-white"></i>  to help!</p>

                                        </div>
                                    </div>
                                    <form id="contactform" name="sendMessage">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 padding-left mb-3">
                                                <div class="form-group">
                                                    <input class="form-control" id="id" name="id" type="text" placeholder="Your property/Agency ID *" required="required">
                                                    <p class="help-block text-danger" id="idHelp" style="display:none;">Please specify your agency/property ID</p>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="url" name="url" type="url" placeholder="Url">
                                                    <p class="help-block text-danger" id="urlHelp" style="display:none;">Please specify url</p>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="your-email" type="email" name="email" placeholder="Your Email *" required="required">
                                                    <p class="help-block text-danger" id="emailHelp" style="display:none;">Please specify your email</p>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="message" name ="message" placeholder="Your Message *" rows="8" required="required"></textarea>
                                                    <p class="help-block text-danger" id="messageHelp" style="display:none;">Please specify your message</p>
                                                </div>
                                                <div id="message-alert" style="display:none;">
                                                </div>
                                                <div class="form-group text-center">
                                                    <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Send Message</button>
                                                </div>

                                            </div>
                                            <div class="col-md-6  padding-left padding-right">
                                                <p class="contact-info mb-4 pr-15"><i class="fa fa-phone mr-2 color-white"></i>+92 51 4862317</p>
                                                <p class="contact-info mb-4 pr-15"><i class="fa fa-mobile mr-2" style="font-size:24px;"></i>+92 315 5141959</p>
                                                <p class="contact-info mb-4 pr-15"><i class="fa fa-envelope mr-2"></i>info@aboutpakistan.com</p>
                                                <div class="divider"></div>
                                                <div class="div-center color-white mt-2"> Join us on Social </div>
                                                <div class="div-center color-white mt-2">
                                                    <a class="media-hover mr-2" href="https://www.facebook.com/aboutpkofficial"  target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>
                                                    <a class="media-hover mr-2" href="https://twitter.com/aboutpkofficial" target="_blank"><i class="fab fa-twitter fa-2x"></i> </a>
                                                    <a class="media-hover mr-2" href="https://www.linkedin.com/company/aboutpkofficial" target="_blank"><i class="fab fa-linkedin in fa-2x"></i> </a>
                                                    <a class="media-hover mr-2" href="https://www.instagram.com/aboutpakofficial/" target="_blank"><i class="fab fa-instagram fa-2x"></i> </a>
                                                    <a class="media-hover mr-2" href="https://www.youtube.com/channel/UCfarVSSCib1eZ6sjFR3-gnA" target="_blank"><i class="fab fa-youtube fa-2x"></i> </a>
                                                </div>

                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>


    <!-- Footer start -->
    @include('website.includes.footer')
@endsection

@section('script')
<script>
    (function ($) {
        $('#sendMessageButton').on('click',function(e)
        {
            const id = $('#id').val();
            const url = $('#url').val();
            const email = $('#your-email').val();
            const message = $('#message').val();
            if (id.trim === ''|| email.trim() === '' || message.trim() === '') {
                e.preventDefault();
                id.trim() === '' ? $('#idHelp').slideDown() : $('#idHelp').slideUp();
                email.trim() === '' ? $('#emailHelp').slideDown() : $('#emailHelp').slideUp();
                message.trim() === '' ? $('#messageHelp').slideDown() : $('#messageHelp').slideUp();
                return;
            }
            if(IsEmail(email) === false)
            {
                e.preventDefault();
                $('#emailHelp').html('Incorrect email format').slideDown();

            }
            else{
                insertMessage();
            }
        });
        $('#message').on('keyup',function(){
            const message = $('#message').val();
            message.trim() === '' ? $('#messageHelp').slideDown() : $('#messageHelp').slideUp();
        });
        $('#your-email').on('keyup',function(){
            const email = $('#your-email').val();
            email.trim() === '' ? $('#emailHelp').slideDown() : $('#emailHelp').slideUp();
            IsEmail(email);
        });
        $('#id').on('keyup',function(){
            const name = $('#id').val();
            name.trim() === '' ? $('#idHelp').slideDown() : $('#idHelp').slideUp();
        });
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
                return false;
            }else{
                return true;
            }
        }
        function insertMessage()
        {
            let html = '';
            $('#message-alert').html(html).slideDown();
            $('#sendMessageButton').prop('disabled', true);
            $.ajax({
                type: 'post',
                url: 'process/insert/send_message.php',
                data: $('#contactform').serialize(),
                success: function () {
                    $("#contactform").trigger("reset");
                    html= ' <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Your message has been sent. </strong></div>'
                    $('#message-alert').html(html).slideDown();
                },
                error: function (xhr, status, error) {
                    html= ' <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error sending message,try again. </strong></div>'
                    $('#message-alert').html(html).slideDown();
                }, complete: function (url, options) {
                    $('#sendMessageButton').prop('disabled', false);
                }
            });

        }
    })(jQuery);




</script>

@endsection
