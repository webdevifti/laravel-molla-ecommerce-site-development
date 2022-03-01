@extends('master')
@section('page_title','Login Registration')
@section('MainContent')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17">
            <div class="container">
                <div class="form-box">
                    @if(session()->has('customer_registered_fail'))
                     <h5 style="text-align: center;color:red">{{ session()->get('customer_registered_fail') }}</h5>
                    @endif
                    @if(session()->has('fail'))
                    <h5 style="text-align: center;color:red">{{ session()->get('fail') }}</h5>
                   @endif
                  
                 
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="register-tab-2" data-toggle="tab" href="#register-2" role="tab" aria-controls="register-2" aria-selected="true">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                                <form action="{{ route('customer.login') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="singin-email-2">Username or email address *</label>
                                        <input type="text" class="form-control" id="singin-email-2" name="singinemail" required value="{{ @old('singinemail') }}">
                                        @error('singinemail')
                                        <p style="color: red">{{ $message }}</p>
                                       @enderror
                                       @if(session()->has('login_email_error'))
                                       <p style="color:red">{{ session()->get('login_email_error') }}</p>
                                      @endif
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="singin-password-2">Password *</label>
                                        <input type="password" class="form-control" id="singin-password-2" name="singinpassword" required>
                                        @error('singinpassword')
                                        <p style="color: red">{{ $message }}</p>
                                       @enderror
                                       @if(session()->has('password_error'))
                                       <p style="color:red">{{ session()->get('password_error') }}</p>
                                      @endif
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="signin-remember-2">
                                            <label class="custom-control-label" for="signin-remember-2">Remember Me</label>
                                        </div><!-- End .custom-checkbox -->

                                        <a href="#" class="forgot-link">Forgot Your Password?</a>
                                    </div><!-- End .form-footer -->
                                </form>
                                <div class="form-choice">
                                    <p class="text-center">or sign in with</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login btn-g">
                                                <i class="icon-google"></i>
                                                Login With Google
                                            </a>
                                        </div><!-- End .col-6 -->
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login btn-f">
                                                <i class="icon-facebook-f"></i>
                                                Login With Facebook
                                            </a>
                                        </div><!-- End .col-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .form-choice -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                                <form action="{{ route('customer.registration') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cutomer_username2">Your Username *</label>
                                        <input type="text" class="form-control" id="cutomer_username2" name="customer_username" required value="{{ @old('customer_username') }}">
                                        @error('customer_username')
                                         <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div><!-- End .form-group -->
                                    <div class="form-group">
                                        <label for="register-email-2">Your email address *</label>
                                        <input type="email" class="form-control" id="register-email-2" name="customer_email" required value="{{ @old('customer_email') }}" >
                                        @error('customer_email')
                                        <p style="color: red">{{ $message }}</p>
                                       @enderror
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-password-2">Password *</label>
                                        <input type="password" class="form-control" id="register-password-2" name="password" required>
                                        @error('password')
                                        <p style="color: red">{{ $message }}</p>
                                       @enderror
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>SIGN UP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                            <label class="custom-control-label" for="register-policy-2">I agree to the <a href="#">privacy policy</a> *</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-footer -->
                                </form>
                                <div class="form-choice">
                                    <p class="text-center">or sign in with</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login btn-g">
                                                <i class="icon-google"></i>
                                                Login With Google
                                            </a>
                                        </div><!-- End .col-6 -->
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-login  btn-f">
                                                <i class="icon-facebook-f"></i>
                                                Login With Facebook
                                            </a>
                                        </div><!-- End .col-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .form-choice -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .container -->
        </div><!-- End .login-page section-bg -->
    </main><!-- End .main -->
@endsection
     