@extends('layouts.auth')
@section('title','Login')
@section('content')
@php
    $cfo = [];
     if(Request::cookie('authremem')){
         $cfo = json_decode(Request::cookie('authremem'), true);
     }
    @endphp
<div class="left-panel ">
        <div class="heading text-center text-uppercase">
          <h1>Sign In</h1>
        </div>
        @include('layouts.admin.flash.alert')
        <div class="scrollbox">
          <div class="form-part " >
            <div class="login-box pad1">
                    <form method="POST" action="{{ route('login') }}">
                            @csrf
                <div class="form-group position-relative{{ $errors->has('email') ? ' has-error' : '' }}"> <i class="iconimg"><img src="images/icon1.png" alt=""></i>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : (!empty($cfo['email']) ? $cfo['email'] : '') }}" placeholder="{{ __('Login ID') }}">
                  @if ($errors->has('email'))
                  <span class="help-block" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
                </div>
                <div class="form-group position-relative{{ $errors->has('password') ? ' has-error' : '' }}"> <i class="iconimg"><img src="images/icon2.png" alt=""></i>
                    <input id="password" type="password" class="form-control" value="{{ old('password') ? old('password') :  (!empty($cfo['password']) ? $cfo['password'] : '') }}" name="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group position-relative">
                  <div class="check-custom pad-t25">
                        <input class="form-check-input" value="1" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked="checked"' : (!empty($cfo['remember']) ? 'checked="checked"' : '') }} >
                    <label for="remember">{{ __('Remember my login details') }}</label>
                  </div>
                </div>
                <div class="form-group btn-top ">
                  <div class="login-btn  ">
                    <button type="submit" class="btn btn-black hvr-shutter-out-horizontal">LOGIN NOW</button>
                  </div>
                  <div class="newuser "> New user? <br>
                    Register <a href="{{ route('register') }}">here</a> </div>
                  </div>
                </form>
              </div>
              <div class="clearfix"></div>
              <div class="forgot-login-detail ">
                <div class="pad1">Forgot password? Click
                        @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}">
                            {{ __('Here?') }}
                        </a>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection
