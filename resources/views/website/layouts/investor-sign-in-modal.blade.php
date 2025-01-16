<div class="modal fade" id="investorModalCenter" tabindex="-1" role="dialog" aria-labelledby="SigninModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px">
        <div class="modal-content">
            <!-- Close Button -->
            <div class="mr-2 mt-1">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 justify-content-center">
                            <!-- Form -->
                            <form method="POST" action="{{ route('investor-login') }}" id="investor-login-form">
                                @csrf
                                <!-- Heading -->
                                <div class="form-group form-box">
                                    <p class="color-black text-center font-weight-bold" style="font-size: 1.5rem;">Investor Login</p>
                                    <!-- Email Input -->
                                    <input id="email" type="email"
                                           class="form-control input-text font-size-14"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           placeholder="Email Address" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f; margin-top: 0.25rem">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Password Input -->
                                <div class="form-group form-box clearfix">
                                    <input id="password" type="password"
                                           class="form-control input-text font-size-14 @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password"
                                           placeholder="Password">
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="margin-top: -27px;"></span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-red">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Submit Button -->
                                <div class="form-group clearfix mb-0">
                                    <button type="submit"
                                            class="menu btn btn-block sign-in sign-card color-green"
                                            style="background-color: goldenrod; color: #187c3c" id="sign-in-btn">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <!-- Remember Me & Forgot Password -->
                                <div class="form-group row mt-3">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input mt-2" type="checkbox"
                                                   name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
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
                                <!-- Sign Up & Learn More -->
                                <div>
                                    <p class="form-check-label text-transform color-black font-12 mt-2 color-green">
                                        Don’t have investor username password?
                                        <a href="#" style="color: #187c3c" data-toggle="modal" data-target="#investorSignUpModal" data-dismiss="modal">Sign Up</a>
                                    </p>
                                </div>
                                <div>
                                    <p class="form-check-label text-transform color-black font-12 mt-2">
                                        What is an investor and how to become an investor?
                                        <a href="#" style="color: #187c3c;">Learn More</a>
                                    </p>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sign-Up Modal -->
<div class="modal fade" id="investorSignUpModal" tabindex="-1" role="dialog" aria-labelledby="InvestorSignUpModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px">
        <div class="modal-content">
            <!-- Close Button -->
            <div class="mr-2 mt-1">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 justify-content-center">
                            <!-- Sign-Up Form -->
                            <form method="POST" action="{{ route('register') }}" id="investor-signup-form">
                                @csrf
                                <div class="form-group form-box">
                                    <p class="color-black text-center font-weight-bold" style="font-size: 1.5rem;">Investor Sign Up</p>
                                    <input id="name" type="text"
                                           class="form-control input-text font-size-14"
                                           name="name" value="{{ old('name') }}" required autocomplete="name"
                                           placeholder="Full Name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f; margin-top: 0.25rem">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group form-box">
                                    <input id="email-signup" type="email"
                                           class="form-control input-text font-size-14"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           placeholder="Email Address" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: #e3342f; margin-top: 0.25rem">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group form-box clearfix">
                                    <input id="password-signup" type="password"
                                           class="form-control input-text font-size-14"
                                           name="password" required autocomplete="new-password"
                                           placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-red">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group clearfix mb-0">
                                    <button type="submit"
                                            class="menu btn btn-block sign-in sign-card color-green"
                                            style="background-color: goldenrod; color: #187c3c">
                                        {{ __('Sign Up') }}
                                    </button>
                                </div>
                            </form>
                            <!-- End Sign-Up Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


