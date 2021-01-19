@extends('frontend.layouts.home')

@section('content')
<div class="inner-banner full-wdth">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <h1>Reset Password</h1>
        </div>
    </div>
</div>
<nav class="breadcrumb-div" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
        </ol>
    </div>
</nav>

<div class="account-section ">
    <div class="container">
        <div class="account-box login-page ">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show active" id="buyer" role="tabpanel" aria-labelledby="buyer-tab">
                    <div class="form-box text-center">
                        <div class="login-title d-flex  flex-column align-items-center"><i class="fas fa-user"></i><h2>Reset Password</h2></div>
                        {{ Form::open(['route' => 'frontend.auth.password.reset', 'class' => 'form-horizontal', 'id' => 'user-set-password']) }}
                            <div class="row">
                            <div class="col-md-12"> 
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @include('includes.partials.messages')
                            </div>
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="col-md-12">
                                    <div class="form-group text-left inp-user">
                                        <label>Email</label>
                                        {{ Form::text('email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email'), 'required' => 'required','readonly']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left inp-user">
                                        <label class='required'>Password</label>
                                        {{ Form::input('password', 'password', null, ['class' => 'form-control', 'id' => 'password' ,'placeholder' => trans('validation.attributes.frontend.register-user.password'), 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left inp-user">
                                        <label class='required'>Confirm Password</label>
                                        {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'id' => 'password_confirmation','placeholder' => trans('Confirm Password'), 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-12 pt-4">
                                    <div class="buttons d-flex justify-content-between align-items-center">
                                        <button type='submit' class="btn btn-custom btn-black btn-md">Reset Password</button>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="home-sec4 text-center">
  <div class="container">
    <h2>Download the App!</h2>
    <ul class="d-flex align-items-center justify-content-center">
      <li><a href=""><i class="fab fa-android"></i> Android App</a></li>
      <li><a href=""><i class="fab fa-apple"></i> iOS App</a></li>
    </ul>
  </div>
</div>

@endsection
