@extends('layouts.inner_home')
@section('title','Login')
@section('content')
<style>
    
</style>
<div class="middle-wrapper linerbg">
        <div class="container">
        <div class="register-page login-page pad-t70 pad-b70">
        <div class="text-center icon"><img src="{{ asset('img/login-icon.png') }}" alt=""></div>
        <div class="heading text-center">
        <h1>User <span>Login</span></h1>
        </div>


        <div class="form-block">


            <!-- Nav tabs -->
                <!-- Nav tabs links -->
                  <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#email">By Email</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#mobile">By Mobile Phone Number</a>
                    </li>
                  </ul>
                  <!-- Nav tabs -->
                <!-- Tab panes -->
                  <div class="tab-content">
                    <div id="email" class="tab-pane active">
                      
                       @include('layouts.admin.flash.alert')
                <form method="POST" action="{{ route('login') }}">
                        @csrf



        <div class="search-col {{ $errors->has('email') ? ' has-error' : '' }}">
                <label>Email Address</label>
                {{ Form::text('email', old('email'), ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''),'placeholder' => 'Enter Email Address','autofocus' => true]) }}
				
            </div>


            <div class="search-col {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>PASSWORD</label>
                    {{ Form::password('password', array('placeholder'=>'Enter Password','class' => 'form-control')) }}
					
                </div>



                <div class="d-flex justify-content-between  align-items-center form-bottm mb-1">

                            <div class="chk rememberme">
                                <input value="0" type="hidden" name="remember">
                                <input class="form-check-input" value="2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked="checked"' : '' }}>

                                <label class="form-check-label" for="remember" style="display:none">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>



        <div class="already-registered text-right">Forgot Password? Click <a href="{{ route('password.request') }}">Here</a></div>




        </div>
        <div class="already-registered text-right d-block w-100">Don't Have An Account? Register  <a href="{{ route('register') }}">Here</a></div>

        <div class="register-btn d-block mrg-t30">
                <button type="submit" class="btn blue-btn">Login NOW</button>

        </div>

    </form>
                    </div>
                    <div id="mobile" class="tab-pane fade">
                      @include('layouts.admin.flash.alert') 
                <form method="POST" action="{{ route('loginwithotp') }}">
                        @csrf



        <div class="search-col {{ $errors->has('mobileno') ? ' has-error' : '' }}">
                <label>Enter Mobile Phone Number</label>
                <div class="phone-no-outer">
                <span class="phone-no">+ 61</span>
                {{ Form::text('mobileno', old('mobileno'), ['class' => 'form-control jbsekerregis'.($errors->has('mobileno') ? ' is-invalid' : ''),'placeholder' => '4XX XXX XXX','autofocus' => true,"required"=>true]) }}
	      
            </div>
            </div>

                <div class="d-flex justify-content-end  align-items-center form-bottm mb-1">
                 <div class="already-registered text-right">Forgot Password? Click <a href="{{ route('password.request') }}">Here</a></div>
              </div>
        <div class="already-registered text-right d-block w-100">Don't Have An Account? Register  <a href="{{ route('register') }}">Here</a></div>

        <div class="register-btn d-block mrg-t30">
                <button type="submit" class="btn blue-btn">Send code</button>

        </div>

    </form>
                    </div>
                  </div>
                 <!-- Nav tabs -->
            <ul class="d-flex justify-content-center flex-wrap align-items-center social-links">
                <span class="opt-text">or</span>
                <li><a class="bg-blue" href="{{ url('auth/facebook') }}"><i class="fab fa-facebook-f"></i> Login with Facebook </a></li>
                <li><a class="bg-red" href="{{ url('auth/google') }}"><i class="fab fa-google-plus-g"></i>Sign in with Google+</a></li>
            </ul>


        </div>







        </div>




        </div>

        </div>

        @include('includes.footer')
@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        {{ Html::script('js/jquery.mask.js') }}

        <script>
                $(document).ready(function($){

                $(".jbsekerregis").mask("400 000 000");
                });
        </script>
