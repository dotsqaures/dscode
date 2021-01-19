@extends('layouts.inner_home')
@section('title','Update Account')
@section('content')



<div class="middle-wrapper ">
    <div class="container">
        <div class=" pad-t40 pad-b40">
            <div class="d-flex align-items-center justify-content-between title-heading">
                <div class="heading">
                    <h1>Add  Paypal<span> Email</span></h1>
                </div>
                @include('layouts.admin.flash.alert')


            </div>


            <div class="product-lists mrg-t20">
                <div class="row">

                    <div class="col-sm-12">
                        <a class="product-search dekstop-tab-hide" href="javascript:void(0)" onClick="expandfullscreenmenu('open')">
                            <i class="fas fa-bars"></i>Menus </a>
                    </div>

                    <div class="col-md-4 product-category-col ">
                        <input type="checkbox" id="togglebox" class="togglebox dekstop-tab-hide" />
                        <nav id="expand-fullpagemenu">

                            <label for="togglebox" id="closex" class="toggleclose dekstop-tab-hide">Close</label>

                            <div class="product-category-box shad my-product-col">

                                @include('layouts.sidebar')

                            </div>

                        </nav>

                    </div>

                    <div class="col-md-8 product-showcase grid-view-product my-product-lists ">

                        <div class="row">


                            <div class="middle-wrapper">
                                <div class="container">
                                    <div class="thank-you-page accountupdate">
                                        <div class="cart-dtl-box shad">


                                            <span>Dear {{ $logInedUser->first_name }},</span>
                                            <h2>Your Paypal email required !!</h2>
                                            <p>Before add a new listing, kindly add your payment details to receive funds into your bank account.</p>

                                            <!--
                                                                                        <a href="{{ url('/add-payment-detail')}}" class="btn-custom">add payment details</a>-->
                                        </div>
                                    </div>
                                    <div class="add-product-page shad add-spacing">
                                        {{ Form::open(['url' => 'addPaypalDetails','id'=>'paypalDetails','name'=>'frm']) }}

                                        <div class="row">
                                            <div class="col-sm-12 mb-md-4 inner-main-title">
                                                Add Paypal Email
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="search-col">
                                                    <label>Paypal Email</label>
                                                    <input type="text" name="paypal_email" class="form-control" value="" placeholder="Enter Paypal Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center  align-items-center form-bottm">
                                            <div class="register-btn">
                                                <img src="http://localhost:8000/img/ajax-loader.gif " alt="" class="frmsubmitloader" style="display:none;">
                                                <input class="submit btn blue-btn" type="submit" value="Next">

                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
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

<script>
                            $(document).ready(function () {

                                $('#paypalDetails').validate({

                                    rules: {
                                         paypal_email: {
                                            required: true,
                                            email: true
                                          }
                                        
                                    },
                                    messages: {
                                        "paypal_email": {required: 'Please enter paypal email.'},

                                    },
                                    submitHandler: function (form) {

                                        $(".frmsubmitloader").show();
                                      
                                            postContent('test');
                                     
                                    },
                                    invalidHandler: function (frm, validator) {

                                        $(".paypalDetails").hide();
                                    },
                                });
                            });
                            function postContent(postData) {


                                $(form).submit();
                                $(".frmsubmitloader").hide();
                                return true;
                            }
</script>
