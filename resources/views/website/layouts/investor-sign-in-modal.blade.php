<div class="modal fade" id="investorModalCenter" tabindex="-1" role="dialog" aria-labelledby="SignInModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px">
        <div class="modal-content">
            <!-- Close Button -->
            <div class="mr-2 mt-1">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="containers">
                    <div class="row">
                        <div class="col-sm-12 justify-content-center">

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
                                            style="background: linear-gradient(to right, #fcd454, #b79c35); color: #187c3c" id="sign-in-btns"> <!-- id is not actual for now remove s from btn to make actual -->
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
                                    <p class="form-check-label text-transform color-black font-12 color-green">
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
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
        <div class="modal-content">
            <!-- Close Button -->
            <div class="mr-2 mt-1 text-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="containers">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <p class="color-black font-weight-bold" style="font-size: 1.5rem;">Investor Sign Up</p>
                        </div>
                        <div class="col-sm-12">
                            <!-- Sign-Up Form -->
                            <form method="POST" action="{{ route('investor.register') }}" id="investor-signup-form">
                                @csrf
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Full Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="email-signup" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email Address">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="cnic" class="d-block">CNIC Number</label>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <!-- First Part: 5 digits -->
                                        <input type="text" class="form-control text-center" name="cnic_first"
                                               required pattern="\d{5}" placeholder="00000" title="Enter exactly 5 digits"
                                               inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               style="flex: 1;">
                                        <span class="mx-2">-</span>

                                        <!-- Middle Part: 7 digits -->
                                        <input type="text" class="form-control text-center" name="cnic_middle"
                                               required pattern="\d{7}" placeholder="1234567" title="Enter exactly 7 digits"
                                               inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               style="flex: 2;">
                                        <span class="mx-2">-</span>

                                        <!-- Last Part: 1 digit -->
                                        <input type="text" class="form-control text-center" name="cnic_last"
                                               required pattern="\d{1}" placeholder="0" title="Enter exactly 1 digit"
                                               inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               style="flex: 0.5;">
                                    </div>
                                    @error('cnic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city_id" class="d-block">City of Residence</label>
                                    <select class="form-control" name="city_id" id="city_id" required>
                                        @foreach($cities as $index => $city)
                                            <option value="{{ $city->id }}" {{ $index === 0 ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Password Fields -->
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

                                <div class="form-group form-box clearfix">
                                    <input id="password_confirmation" type="password" class="form-control input-text font-size-14"
                                           name="password_confirmation" required placeholder="Confirm Password">
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="margin-top: -27px;"></span>
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-block" style="background: linear-gradient(to right, #fcd454, #b79c35); color: #187c3c;">Sign Up</button>
                                </div>
                            </form>
                            <p class="text-center font-12">
                                Our support team will contact you within one hour, and upon successful processing, you will be able to use the investor portal. <br>
                                If you need further information, call us at: <a href="tel:+92514862317" class="text-success">+92 51 4862 317</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



