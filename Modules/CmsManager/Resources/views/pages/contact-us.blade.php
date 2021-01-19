@extends('layouts.inner_home')
@section('title','Contact-us')
@section('content')


<div class="middle-wrapper contact-page">
        <div class="container">
        <div class=" pad-t40 pad-b40">
        <div class="heading">
        <h1> Contact <span> Us</span></h1>
        </div>

        <div class="row ">

              <div class="col-md-8 contact-col">
                <div class="contact-form">
                        @include('layouts.admin.flash.alert')

                 <div class="sub-title">Have an enquiry?</div>
                 <p>Alternatively, fill out this form and we‘ll get back to you. We‘ll try to reply to your enquiry within 1 business day.</p>


                 {{ Form::open(['enctype' => 'multipart/form-data','method' => 'post','id'=>'submitquery','class'=>'formee','url' => route('submit.enquiry')]) }}

                  <div class="row">

                    <div class="col-sm-6">
                      <div class="form-group search-col required {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="title">Name</label>
                      {{ Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Enter your name']) }}
                      
                      </div>
                    </div>


                    <div class="col-sm-6">
                            <div class="form-group search-col {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">Email Address</label>
                                {{ Form::email('email', old('email'), ['class' => 'form-control','placeholder' => 'Email Address']) }}
                                
                            </div>
                        </div>





                            <div class="col-sm-6">
                            <div class="form-group search-col {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label>Mobile PHONE NUMBER</label>
                                    <div class="phone-no-outer">
                                        <span class="phone-no">+61</span>
                                        {{ Form::text('phone', old('phone'), ['class' => 'form-control jbsekerregis'.($errors->has('mobileno') ? ' is-invalid' : ''),'placeholder' => '(4XX XXX XXX)','autofocus' => true]) }}

                                    </div>
                                   
                                </div>
                            </div>



                            <div class="col-sm-6">
                                    <div class="form-group search-col required {{ $errors->has('subject') ? 'has-error' : '' }}">
                                      <label for="title">Subject</label>
                                    {{ Form::text('subject', old('subject'), ['class' => 'form-control','placeholder' => 'Enter Subject']) }}
                                    
                                    </div>
                            </div>



                            <div class="col-sm-12">
                                    <div class="form-group search-col required {{ $errors->has('message') ? 'has-error' : '' }}">
                                      <label for="title">Message</label>
                                    {{ Form::textarea('message', old('message'), ['class' => 'form-control','placeholder' => 'Enter Message']) }}
                                   
                                    </div>
                            </div>






                  </div>



                  <div class="d-flex justify-content-center">

                      <button type="submit" class="btn blue-btn mrg-r20">Submit</button>
                  </div>
                  {{ Form::close() }}





                </div>














              </div>

              <div class="col-md-4 contact-col ">

              <div class="contact-form">

             <div class="sub-title">Contact Information</div>

            <div class="office-address">


       <div class="address-part">
             <p>
           {{ config('get.ADDRESS') }}
           {{ config('get.ADMIN_EMAIL') }} <br/>
           {{ config('get.TELEPHONE') }}
        </p>
             </div>


             </div>

    </div>


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
