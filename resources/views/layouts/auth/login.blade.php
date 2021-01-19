@extends('frontend.layouts.home')

@section('content')
<div class="inner-banner full-wdth">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <h1>Login</h1>
        </div>
    </div>
</div>
<nav class="breadcrumb-div" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">login</li>
        </ol>
    </div>
</nav>

<div class="account-section ">
    <div class="container">
        <div class="account-box login-page ">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show active" id="buyer" role="tabpanel" aria-labelledby="buyer-tab">
                    <div class="form-box text-center">
                        <div class="login-title d-flex  flex-column align-items-center"><i class="fas fa-user"></i><h2>User Login</h2></div>
                        <h3 class="middle-heading02">Login to access your account</h3>
                        {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'form-horizontal', 'id' => 'user-login']) }}
                            <div class="row">
                            <div class="col-md-12"> 
                                @include('includes.partials.messages')
                            </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left inp-user">
                                        <label class='required'>Email</label>
                                        <input name='email' class="form-control" type="text" placeholder="Enter email address">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left inp-password ">
                                        <label class='required'>Password</label>
                                        <input name='password' class="form-control" type="password" placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="col-md-12 pt-4">
                                    <div class="buttons d-flex justify-content-between align-items-center">
                                        <button class="btn btn-custom btn-black btn-md">Login</button>
                                        {{ link_to_route('frontend.auth.password.reset', trans('Forgot Password?'), [], ['class' => 'forgot-link']) }}
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="tab-pane" id="supplier" role="tabpanel" aria-labelledby="supplier-tab">
                    <div class="form-box">
                        <h3 class="middle-heading">Supplier Detail Goes Here</h3>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Organisation name</label>
                                        <input class="form-control" type="text" placeholder="Organisation name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact name</label>
                                        <input class="form-control" type="text" placeholder="Enter name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input class="form-control" type="text" placeholder="Enter your address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telephone number</label>
                                        <input class="form-control" type="text" placeholder="Enter phone number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Re-enter password</label>
                                        <input class="form-control" type="password" placeholder="Re-enter password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address1</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address2</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Postcode</label>
                                        <input class="form-control" type="text" placeholder="Enter Postcode">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text" placeholder="Your city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control">
                                            <option>Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="buttons d-flex justify-content-end">
                                        <button class="btn btn-custom btn-black btn-md">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
@include('frontend.includes.footer')
@endsection
