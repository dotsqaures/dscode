@extends('layouts.inner_home')
@section('title','Register')
@section('content')

<div class="middle-wrapper linerbg">
    <div class="container">
        <div class="register-page pad-t70 pad-b70">
            <div class="text-center icon"><img src="{{ asset('img/register-icon.png') }}" alt=""></div>
            <div class="heading text-center">
                <h1>User <span>Registration</span></h1>
            </div>


            <div class="form-block">

                <form method="POST" action="{{ route('register') }}">
                    @csrf




                    <input type="hidden" value="1" name="role_id" />
                    <div class="search-col {{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label>First Name</label>
                        {{ Form::text('first_name', old('first_name'), ['class' => 'form-control'.($errors->has('first_name') ? ' is-invalid' : ''),'placeholder' => 'First Name','autofocus' => true]) }}
                        @if($errors->has('first_name'))
                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>

                    <div class="search-col {{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label>Last Name</label>
                        {{ Form::text('last_name', old('last_name'), ['class' => 'form-control'.($errors->has('last_name') ? ' is-invalid' : ''),'placeholder' => 'Last Name','autofocus' => true]) }}
                        @if($errors->has('last_name'))
                        <span class="help-block">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>



                    <div class="search-col {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Email Address</label>
                        {{ Form::text('email', old('email'), ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''),'placeholder' => 'Enter Email Address','autofocus' => true]) }}
                        @if($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="search-col {{ $errors->has('mobileno') ? ' has-error' : '' }}">
                        <label>Mobile PHONE NUMBER</label>
                        <div class="phone-no-outer">
                            <span class="phone-no">+61</span>
                            {{ Form::text('mobileno', old('mobileno'), ['class' => 'form-control jbsekerregis'.($errors->has('mobileno') ? ' is-invalid' : ''),'placeholder' => '(4XX XXX XXX)','autofocus' => true]) }}

                        </div>
                        @if($errors->has('mobileno'))

                        <span class="help-block">{{ $errors->first('mobileno') }}</span>
                        @endif
                    </div>

                    <div class="search-col {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>PASSWORD</label>
                        {{ Form::password('password', array('placeholder'=>'Enter Password','class' => 'form-control')) }}

                        <span class="help-block">{{ $errors->first('password') }}</span>

                    </div>

                    <div class="search-col {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label>CONFIRM PASSWORD</label>
                        {{ Form::password('password_confirmation',array('placeholder'=>'Enter Password Again','class' => 'form-control')) }}

                        @if($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between  align-items-center form-bottm">
                        <div class="register-btn">
                            <button type="submit" class="btn blue-btn">REGISTER NOW</button>
                            <!--<a href="javascript:void(0)" class="btn blue-btn">Register Now</a>-->

                        </div>

                </form>

                <div class="already-registered">Already Registered? Login <a href="{{ asset('/login')}}">Here</a></div>


            </div>


        </div>



    </div>


</div>

</div>

@include('includes.footer')
@endsection
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
{{ Html::script('js/jquery.mask.js') }}

<script>
$(document).ready(function ($) {

$(".jbsekerregis").mask("400 000 000");
});
</script>
