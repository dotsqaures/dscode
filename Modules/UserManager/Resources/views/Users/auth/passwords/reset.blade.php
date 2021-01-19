@extends('layouts.inner_home')
@section('title','Reset Password')
@section('content')


<div class="middle-wrapper linerbg">
        <div class="container">
        <div class="register-page login-page pad-t70 pad-b70">
        <div class="text-center icon"><img src="{{ asset('img/login-icon.png') }}" alt=""></div>
        <div class="heading text-center">
        <h1>Reset <span>Password</span></h1>
        </div>

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


        <div class="form-block">

                @include('layouts.admin.flash.alert')
                <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">


                        <div class="form-group hide position-relative{{ $errors->has('email') ? ' has-error' : '' }}" style="display:none;">
                                <i class="iconimg"><img alt="" src="{{ asset('images/icon4.png') }}"></i>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Email Id" name="email" value="{{ base64_decode($email) ?? old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$">

                              </div>

                            <div class="search-col {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>NEW PASSWORD</label>
                                    {{ Form::password('password', array('placeholder'=>'Enter Password','class' => 'form-control')) }}

                                </div>



                                <div class="search-col {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <label>CONFIRM PASSWORD</label>
                                        {{ Form::password('password_confirmation',array('placeholder'=>'Enter Confirm Password','class' => 'form-control')) }}


                                    </div>




        <div class="register-btn mrg-t30">
                <button type="submit" class="btn blue-btn">Reset Password</button>

        </div>

    </form>

        </div>







        </div>




        </div>

        </div>

        @include('includes.footer')
@endsection


