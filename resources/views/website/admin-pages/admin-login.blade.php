@extends('website.layouts.app')
@section('title')
    <title>Jagha - Buy Sell Rent Homes & Properties In Pakistan by https://www.jagha.com</title>
@endsection

@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
@endsection

<!-- Contact section start -->

@section('content')
    <div class="contact-section">
        <div class="container">
            <div class="login-box" style="max-width: 500px;!important;">
                <div class="align-self-center pad-0">
                    <div class="form-section clearfix">
                        <h3>Login As Admin</h3>

                        <div class="clearfix"></div>
                        @include('website.layouts.flash-message')
                        <form role="form" method="POST" action="{{ route('admin-login') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="control-label">E-Mail Address</label>

                                        <input type="email" class="form-control mb-2" name="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong style="color:red;">{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label class="control-label">Password</label>
                                        <input type="password" class="form-control mb-2" name="password" id="admin-password">
                                        <span toggle="#admin-password" class="fa fa-fw fa-eye  field-icon toggle-password" style="margin-top: -36px;"></span>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong style="color:red;">{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in mr-2"></i>Login
                                    </button>
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
@endsection
