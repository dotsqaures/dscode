@extends('layouts.admin.login')
@section('title','Login')
@section('content')
   <p class="login-box-msg">Sign in to start your session</p>
    @php
    $cfo = [];
     if(Request::cookie('adminckrem')){
         $cfo = json_decode(Request::cookie('adminckrem'), true);
     }
    @endphp
    <form method="POST" action="{{ route('admin.login') }}">
         @csrf
      <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : (!empty($cfo['email']) ? $cfo['email'] : '') }}" placeholder="{{ __('E-Mail Address') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
      </div>
      <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="form-control" value="{{ old('password') ? old('password') :  (!empty($cfo['password']) ? $cfo['password'] : '') }}" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
      </div>
      <div class="row">
        <div class="col-xs-8">
                <input value="0" type="hidden" name="remember">
          <div class="checkbox icheck">
              <label style="display: none">
              <input class="form-check-input" value="1" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked="checked"' : (!empty($cfo['remember']) ? 'checked="checked"' : '') }} > {{ __('Remember Me') }}
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<div class="social-auth-links text-center">
      <p>- OR -</p>
     <a href="{{ route('admin.password.request') }}">I forgot my password</a>
    </div>
    <!-- /.social-auth-links -->

@stop
