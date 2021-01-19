@extends('frontend.layouts.home')

@section('content')
<div class="inner-banner full-wdth">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <h1>Create Account</h1>
        </div>
    </div>
</div>
<nav class="breadcrumb-div" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Account</li>
        </ol>
    </div>
</nav>

<div class="account-section">
    <div class="container">
        <div class="account-box pt-5 pb-5 mb-4">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link user-type d-flex align-items-center justify-content-center active" id="buyer-tab" data-toggle="pill" role="tab" href='javascript:void(0)' aria-controls="buyer" aria-selected="true">I am a buyer looking for a service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link user-type d-flex align-items-center justify-content-center" id="supplier-tab" data-toggle="pill" role="tab" href='javascript:void(0)' aria-controls="supplier" aria-selected="false">I am a supplier offering a service</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show active" id="buyer" role="tabpanel" aria-labelledby="buyer-tab">
                    <div class="form-box">
                        <h3 class="middle-heading">Buyer Details Goes Here</h3>
                        {{ Form::open(['route' => 'frontend.auth.register', 'class' => 'form-horizontal', 'id' => 'user-registration']) }}
                            <div class="row">
                                <div class="col-md-12"> 
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @include('includes.partials.messages')
                                </div>
                                <input hidden value='Buyer' class='usertype' name='user_type'/>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required' id='label-id-for-user'>Organisation Name</label>
                                        {{ Form::input('organisation_name', 'organisation_name', null, ['id' => 'placeholder-id-for-user','class' => 'form-control', 'placeholder' => trans('Organisation name')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Contact name</label>
                                        {{ Form::input('contact_name', 'contact_name', null, ['class' => 'form-control', 'placeholder' => trans('Contact Name')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Email address</label>
                                        {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('Email Address')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Telephone number</label>
                                        {{ Form::input('telephone_number', 'telephone_number', null, ['class' => 'form-control', 'placeholder' => trans('Enter Telephone number')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Password</label>
                                        {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('Password'), 'id' => 'password']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Re-enter password</label>
                                        {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('Password'), 'id' => 'Re-enter password']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>{{trans('validation.attributes.backend.access.users.address_1')}}</label>
                                        {{ Form::input('address_1', 'address_1', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.address_1')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{trans('validation.attributes.backend.access.users.address_2')}}</label>
                                        {{ Form::input('address_2', 'address_2', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.address_2')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Postcode</label>
                                        {{ Form::input('postcode', 'postcode', null, ['class' => 'form-control', 'placeholder' => trans('Enter Postcode')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>City</label>
                                        {{ Form::input('city', 'city', null, ['class' => 'form-control', 'placeholder' => trans('Enter city')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class='required'>Country</label>
                                        {!! Form::select('country', $countries, null, ["class" => "form-control", "placeholder" => 'Select Country']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="g-recaptcha" data-sitekey="6LeW350UAAAAAGY_i402iix7DrO8kM-AdkQybCgc" data-callback="recaptchaCallback"></div>
                                <input type="hidden" class="hiddenRecaptcha required" value='' name='hiddenRecaptcha' id="hiddenRecaptcha">
                                </div>
                                <div class="col-md-12">
                                    <div class="buttons d-flex justify-content-end">
                                        <button type='submit' id='register-btn-submit' class="btn btn-custom btn-black btn-md">Register</button>
                                    </div>
                                </div>
                            </div>
                        {{Form::close()}}
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
<script>
function recaptchaCallback() {
    $('#hiddenRecaptcha').valid();
    $('#hiddenRecaptcha').val('1');
};
</script>
{!! Captcha::script() !!}
@push('custom-scripts')
<script>
    $(document).ready(function() {
        $('.usertype').val('Buyer');
        $('.user-type').on('click', function(){
            var id = $(this).attr('id');
            if(id == 'buyer-tab') {
                $('.middle-heading').html('Buyer Details Goes Here');
                $('.usertype').val('Buyer');
                $('#label-id-for-user').html('Organisation Name');
                $('#placeholder-id-for-user').attr('placeholder','Organisation Name');
                $('#placeholder-id-for-user-error').remove();
                $('input[name="organisation_name"]').rules('add', {
                    required: true,minlength: 5,maxlength : 100,
                    messages: {
                        required: 'Please enter organisation name.',
                        minlength : 'Organisation name must be at least be 5 charcters long.',
                        maxlength : 'Organisation name should not be more than 100 charcters long.'
                    }
                });
            }else{
                $('.middle-heading').html('Supplier Details Goes Here');
                $('.usertype').val('Supplier');
                $('#label-id-for-user').html('Academic Institution');
                $('#placeholder-id-for-user').attr('placeholder','Academic Institution');
                $('#placeholder-id-for-user-error').remove();
                $('input[name="organisation_name"]').rules('remove');
                $('input[name="organisation_name"]').rules('add', {
                    required: true,minlength: 5,maxlength : 100,
                    messages: {
                        required: 'Please enter academic institution.',
                        minlength : 'Academic institution must be at least be 5 charcters long.',
                        maxlength : 'Academic institution should not be more than 100 charcters long.'
                    }
                });
            }
        });

        
    });
</script>
@endpush