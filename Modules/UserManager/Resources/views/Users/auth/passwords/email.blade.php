@extends('layouts.inner_home')
@section('title','Forgot Password')
@section('content')

<div class="middle-wrapper linerbg">
        <div class="container">
        <div class="register-page login-page pad-t70 pad-b70">
        <div class="text-center icon"><img src="{{ asset('img/login-icon.png') }}" alt=""></div>
        <div class="heading text-center">
        <h1>Forgot <span>Password</span></h1>
        </div>

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif



        <div class="form-block">
                @include('layouts.admin.flash.alert')
                <form method="POST" action="{{ route('password.email') }}">
                        @csrf



        <div class="search-col {{ $errors->has('email') ? ' has-error' : '' }}">
                <label>Email Address</label>
                {{ Form::text('email', old('email'), ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''),'placeholder' => 'Enter Email Address','autofocus' => true ]) }}

            </div>





        <div class="register-btn mrg-t30">
                <button type="submit" class="btn blue-btn">Submit</button>

        </div>

    </form>

        </div>







        </div>




        </div>

        </div>

        @include('includes.footer')
@endsection


