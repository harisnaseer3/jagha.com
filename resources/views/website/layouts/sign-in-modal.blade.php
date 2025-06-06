<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="SigninModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px">
        <div class="modal-content">
            <div class="mr-2 mt-1">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="containers">
                    <div class="row">
                        <div class="col-sm-12 justify-content-center">
                            <a href="{{url('/redirect')}}" class="btn btn-block btn-outline sign-in sign-card color-black" style="text-align: left;">
                                <img class="mr-4" src="{{asset('img\facebook-icon.png')}}" alt="facebook-icon" aria-label="facebook-login">Login with Facebook</a>

                            <a href="{{url('google/redirect')}}" class="btn btn-block btn-outline sign-in sign-card color-black" style="text-align: left;">
                                <img class="mr-4" src="{{asset('img\google-icon.png')}}" alt="google-icon" aria-label="google-login">Login with Google</a>
                            <p class="text-center">OR</p>

                            <form method="POST" action="{{ route('login') }}" id="sign-in-card">
                                @csrf
                                <div class="form-group form-box">
                                    <input id="email" type="email" class="form-control input-text font-size-14 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                           autocomplete="email" placeholder="Email Address" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f; margin-top: 0.25rem">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group form-box clearfix">
                                    <input id="password" type="password" class="form-control input-text font-size-14 @error('password') is-invalid @enderror" name="password" required
                                           autocomplete="current-password"
                                           placeholder="Password">
                                    <span toggle="#password" class="fa fa-fw fa-eye  field-icon toggle-password" style="margin-top: -27px;"></span>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-red">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="help-block text-red mt-1" role="alert"><small class="error-tag text-red text-bold font-12"></small></div>

                                </div>
                                <div class="form-group clearfix mb-0">
                                    <button type="submit" class="btn btn-block sign-in login-btn color-black sign-card" id="sign-in-btn">
                                        {{ __('Login') }}
                                    </button>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input mt-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label text-transform color-black font-12 mt-2" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link color-black font-12" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <a href="{{route('register')}}" class="btn btn-block sign-in login-btn color-black sign-card">Register to Become a Member</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
