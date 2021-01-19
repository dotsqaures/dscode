@extends('layouts.inner_home')
@section('title','Checkout')
@section('content')





<div class="middle-wrapper">
    <div class="container">
      <div class="cart-page-block">
         <h2>CHECKOUT</h2>
         <div class="returnmessage"></div>

         <form  method="POST" id="checkout-payment" name='checkoutfrm'>
                <span class="payment-errors"></span>
         <div class="row">





           <div class="col-md-8">


                @if(count($userAddress)>0)
                <div class="cart-dtl-box adsrt-bmt shad">


                        <h3>Send <strong>To</strong></h3>

                        <div class="showerrormessage"></div>
                        <div class="row">

                          @foreach($userAddress as $address)
                          <div class="col-md-6 send-outer">
                             <div class="send-block">
                              <span class="ad-tmt">{{ $address->shiping_name.' '.$address->shiping_last_name }}</span>
                              <label>

                                <input type="radio" name="addressid" class="child-checkbox addresscheckbox" value="{{ $address->id }}" {{ ($address->status == '2') ? 'checked' : '' }}>

                                <span></span>
                                {{ $address->shipping_address_one.' '.$address->shipping_address_two }}<br/>
                                {{ $address->shipping_suburb.' '.$address->shipping_postcode }}<br/>
                                {{ $address->shipping_mobileno }}
                            <p class="p-0 text-right">
                                <a href="javascript:void(0)" onclick='EditAddress("{{ $address->id }}")' class="editaddress">Edit</a>
                            </p>
                            </label>
                              </div>
                          </div>
                           @endforeach



                        </div>
                        <a href="javascript:void(0)" class="btn-custom pbt-typ showaddressdiv">Add new Address</a>


                      </div>
<style>
    .shipping-first-div{display:none;}
</style>
                      @endif


           <div class="shipping-first-div">
             <div class="cart-dtl-box shad">
               <h3>Shipping <strong>Address</strong></h3>
               <div class="row">
                 <div class="col-md-6">
                 	<div class="form-group">
                    <input name="shiping_name" type="text" class="form-control" placeholder="First Name">
                    </div>
                 </div>
                 <div class="col-md-6">
                 	<div class="form-group">
                <input name="shiping_last_name"  type="text" class="form-control" placeholder="Last Name"></div>
                 </div>
                 <div class="col-md-3">
                    <div class="form-group">
                            <input name="shiping_Unit_number" type="text" class="form-control" placeholder="Unit No.">
                    </div>
                 </div>
                 <div class="col-md-3">
                    <div class="form-group">
                            <input name="shiping_Street_number" type="text" class="form-control" placeholder="Street No.">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <input name="shipping_address_one" type="text" class="form-control shippingAddress1" placeholder="Street Name">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <input name="shipping_address_two" type="text" class="form-control shippingAddress2" placeholder="Street Name2 (Optional)">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <input name="shipping_suburb" type="text" class="form-control" placeholder="Suburb">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <select class="form-control" name="shipping_state" id="selectstate">
                        <option value="">State/Region/Province</option>
                        <option value="NSW">New South Wales</option>
                        <option value="QLD">Queensland</option>
                        <option value="SA">South Australia</option>
                        <option value="TAS">Tasmania</option>
                        <option value="VIC">Victoria</option>
                        <option value="WA">Western Australia</option>
                        <option value="ANT">Australian Capital Territory</option>
                        <option value="NT">Nothern Territory</option>

                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <input name="shipping_postcode" type="number" class="form-control" placeholder="Postcode">
                    </div>
                </div>


                <div class="col-md-6">
                        <div class="form-group">

                                <div class="phone-no-outer">
                                 <span class="phone-no">+61</span>

                                 <input name="shipping_mobileno" type="text" class="form-control shippingMobile" placeholder="Mobile Number">

                            </div>
                        </div>
                </div>


               </div>
             </div>
             <div class="cart-dtl-box shad">
               <h3>Billing <strong>Address</strong></h3>
               <span class="check-typ-dp"><input type="checkbox" name="sameaddress" onclick="set_checked()" />Billing address is the same as the shipping address.</span>
               <div class="row">

                 <div class="col-md-6">
                 	<div class="form-group">
                 <input name="billing_name" type="text" class="form-control" placeholder="First Name"></div>
                 </div>

                 <div class="col-md-6">
                        <div class="form-group">
                   <input name="billing_last_name"  type="text" class="form-control" placeholder="Last Name"></div>
                    </div>


                    <div class="col-md-3">
                    <div class="form-group">
                            <input name="billing_Unit_number" type="text" class="form-control" placeholder="Unit No.">
                    </div>
                  </div>
                      <div class="col-md-3">
                       <div class="form-group">
                      <input name="billing_Street_number" type="text" class="form-control" placeholder="Street No.">
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <input name="billing_address_one" type="text" class="form-control billingAddress1" placeholder="Street Name">
                        </div>
                    </div>


                <div class="col-md-12">
                        <div class="form-group">
                        <input name="billing_address_two" type="text" class="form-control billingAddress2" placeholder="Street Name2 (Optional)">
                        </div>
                    </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <input name="billing_suburb" type="text" class="form-control" placeholder="Suburb">
                            </div>
                        </div>


                        <div class="col-md-4 showselectval">
                                <div class="form-group">
                                <select class="form-control" name="billing_state" id="selectbillingstate">
                                    <option value="">State/Region/Province</option>
                                    <option value="NSW">New South Wales</option>
                                    <option value="QLD">Queensland</option>
                                    <option value="SA">South Australia</option>
                                    <option value="TAS">Tasmania</option>
                                    <option value="VIC">Victoria</option>
                                    <option value="WA">Western Australia</option>
                                    <option value="ANT">Australian Capital Territory</option>
                                    <option value="NT">Nothern Territory</option>

                                </select>
                                </div>
                            </div>

                            <div class="col-md-4 hideselectval" style="display:none;">
                                <div class="form-group">
                                <select class="form-control" name="billing_state" id="selectbillingstate1">
                                    <option value="">State/Region/Province</option>
                                    <option value="NSW">New South Wales</option>
                                    <option value="QLD">Queensland</option>
                                    <option value="SA">South Australia</option>
                                    <option value="TAS">Tasmania</option>
                                    <option value="VIC">Victoria</option>
                                    <option value="WA">Western Australia</option>
                                    <option value="ANT">Australian Capital Territory</option>
                                    <option value="NT">Nothern Territory</option>

                                </select>
                                </div>
                            </div>



                         <div class="col-md-4">
                                <div class="form-group">
                                <input name="billing_postcode" type="number" class="form-control" placeholder="Postcode">
                                </div>
                            </div>


                            <div class="col-md-6">
                                    <div class="form-group">

                                            <div class="phone-no-outer">
                                             <span class="phone-no">+61</span>
                                             <input name="billing_mobileno" type="text" class="form-control billingMobile" placeholder="Mobile Number">
                                            </div>
                                    </div>
                            </div>




     <input name="status" type="hidden" class="form-control" placeholder="Name" value="2">
               </div>
             </div>
            </div>


             <div class="cart-dtl-box shad">
               <h3>Enter <strong>Card Details</strong></h3>
               <div class="row">
                 <div class="col-md-4">
                     <div class="form-group"><label>Card Number</label>

            <input type="text" class="form-control number-icon cardnumbervalidate" placeholder="XXXX XXXX XXXX XXXX"   data-stripe="number" name="card_number" >
         </div>
                 </div>
                 <div class="col-md-8">
                    <div class="row">
                      <div class="col-md-4"><label>Expiration Month </label>


                <select class="form-control date-icon" data-stripe="exp_month" name="exp_Month">
                        <option value="">Month</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>

                          </select>
                      </div>
                      <div class="col-md-4"><label>Expiration Year</label>

                          <select class="form-control" data-stripe="exp_year" name="exp_year">
                                        <option value="">Year</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>

                                          </select>

             </div>
                      <div class="col-md-4"><label>CVV</label>

                <input type="text" class="form-control card-icon" maxlength="3" minlength="3"  name="cvc" required>
            </div>
                    </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-md-4">
             <div class="cart-dtl-box shad confirm-pay">
               <h3>Cart <strong>Details</strong></h3>
               <ul class="total-block">
                 <li><p>Total Quantity</p> <strong>{{ count($productData) }}</strong></li>
                 @php $total = 0; @endphp
                 @foreach($productData as $product)
                   @php $total += $product->final_price; @endphp
                  @endforeach
                 <li><strong>Total Payable</strong> <strong class="tit-bx">${{ $total }}</strong></li>
               </ul>
               <input type="hidden" name="amount" value="{{ $total }}" class="amount">
               <input type="hidden" name="offer" value="0" class="offerpruchase">
               <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg" style="display:none;">
               <input class="btn-custom" type="submit" value="Confirm and pay" style="width:100%" id="btnSubmit">
             </div>
             <div class="cart-dtl-box shad safe-block text-center">
               <img src="{{ asset('img/safe.png') }}" alt="">
               <p>Safe and Secure Payments. Easy returns. 100% Authentic products.</p>
             </div>
             <div class="cart-dtl-box shad stripe-block pay-card-box d-flex flex-wrap justify-content-center">
               <img src="{{ asset('img/stripe.png') }}" alt="">
               <img src="{{ asset('img/cards.jpg') }}" alt="">
             </div>
           </div>


         </div>

         <input type="hidden" name="user_id" value="{{ $logInedUser->id }}" />

        </form>
      </div>
    </div>
  </div>



<div class="modal carddetail" id="myModal" role="dialog">
        <div class="modal-dialog checkout-address">

          <!-- Modal content-->
          <div class="modal-content">
                <a href="javascript:void(0)" class="close" onclick='PaymentClose()'>&times;</a>
            <div class="modal-header">
              <div class="w-100  modal-header-inner">

               <p class="text-center">Edit Address</p>

               <div class="d-flex justify-content-between">
               </div>
             </div>
          </div>

            <div class="modal-body">


           </div>
         </div>

        </div>
      </div>







@include('includes.footer')
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

{{ Html::script('js/jquery.mask.js') }}


<script>




    function set_checked()
    {
        if($("input[name=sameaddress]").is(":checked") == true) {

            $(".hideselectval").hide();
            $(".showselectval").show();
           var shippingName =      $('input[name="shiping_name"]').val();
           var shippingLastName =  $('input[name="shiping_last_name"]').val();
           var shippingMobileno =  $('input[name="shipping_mobileno"]').val();
           var shippingAddress1 =  $('.shippingAddress1').val();
           var shippingAddress2 =  $('.shippingAddress2').val();
           var shippingSuburb =    $('input[name="shipping_suburb"]').val();
           var shippingUnitNUmber =    $('input[name="shiping_Unit_number"]').val();
           var shippingStreetNumber =    $('input[name="shiping_Street_number"]').val();
           var shippingState =    $("#selectstate option:selected").val();

           var shippingPostcode =  $('input[name="shipping_postcode"]').val();

           $('input[name="billing_name"]').val(shippingName);
           $('input[name="billing_last_name"]').val(shippingLastName);
           $('input[name="billing_mobileno"]').val(shippingMobileno);
           $('.billingAddress1').val(shippingAddress1);
           $('.billingAddress2').val(shippingAddress2);
           $('input[name="billing_suburb"]').val(shippingSuburb);
           $('input[name="billing_Unit_number"]').val(shippingUnitNUmber);
           $('input[name="billing_Street_number"]').val(shippingStreetNumber);
           $("#selectbillingstate option[value="+shippingState+"]").attr('selected', 'selected');
           $('input[name="billing_postcode"]').val(shippingPostcode);

          }else{


            $('input[name="billing_name"]').val('');
            $('input[name="billing_last_name"]').val('');
            $('input[name="billing_mobileno"]').val('');
            $('.billingAddress1').val('');
            $('.billingAddress2').val('');
            $('input[name="billing_suburb"]').val('');
            $('input[name="billing_postcode"]').val('');
            $('input[name="billing_Unit_number"]').val('');
            $('input[name="billing_Street_number"]').val('');

            $(".showselectval").hide();
            $(".hideselectval").show();


          }
    }

        $(document).ready(function($){


        $(checkoutfrm).validate({


        rules: {
            shiping_name : { required: true},
            shiping_last_name : { required: true},
            shipping_suburb : {required: true },
            shiping_Unit_number : {required: true },
            shiping_Street_number:{required:true},
            shipping_state : {required:true},
            shipping_postcode : {required: true,minlength:1,maxlength:6 },
            shipping_address_one :{required: true},
            shipping_mobileno : {required: true},

            billing_name : { required: true},
            billing_last_name : { required: true},
            billing_suburb : {required: true },
            billing_Unit_number : {required: true },
            billing_Street_number:{required:true},
            billing_state : {required:true},
            billing_postcode : {required: true,minlength:1,maxlength:6 },
            billing_address_one :{required: true},
            billing_mobileno : {required: true},

            card_number: {required: true,minlength:1,maxlength:19 },

            exp_Month : {required:true},
            exp_year : {required:true},
            addressid:{ required:true }



          },
          messages :{
              "shiping_name" : { required : 'This field is required.'},
              "shiping_last_name" : { required : 'This field is required.'},

              "shiping_Unit_number" : { required : 'This field is required.'},
              "shiping_Street_number" : { required : 'This field is required.'},
              "shipping_state" : { required : 'This field is required.'},

              "shipping_suburb" : { required : 'This field is required.'},
              "shipping_postcode" : { required : 'This field is required.'},
              "shipping_address_one" : { required : 'This field is required.'},

              "billing_mobileno" : { required : 'This field is required.'},
              "shipping_mobileno" : { required : 'This field is required.'},

              "billing_name" : { required : 'This field is required.'},
              "billing_suburb" : { required : 'This field is required.'},
              "billing_postcode" : { required : 'This field is required.'},
              "billing_address_one" : { required : 'This field is required.'},

              "billing_last_name" : { required : 'This field is required.'},

              "billing_Unit_number" : { required : 'This field is required.'},
              "billing_Street_number" : { required : 'This field is required.'},
              "billing_state" : { required : 'This field is required.'},

              "card_number" : { required : 'This field is required.'},

              "exp_Month" : { required : 'This field is required.'},
              "exp_year" : { required : 'This field is required.'},
              "addressid": { required : "You must select an account type" }



         },




          submitHandler: function(checkoutfrm) {
             postContent('test');
          },
         invalidHandler: function(checkoutfrm, validator) {

         },

   });
    });


      function postContent(postData) {

        $('#btnSubmit').attr("disabled", true);
        $(".showerrormessage").show();
        $(".showerrormessage").html("");
        Stripe.setPublishableKey('pk_test_DyDzPUC1TIhq4Xp2gpZSP7Ct');


	  var $form = $('#checkout-payment');
	  //$form.submit(function(event) {
		// Disable the submit button to prevent repeated clicks:
		//$form.find('.submit').prop('disabled', true);

		// Request a token from Stripe:
		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from being submitted:
		//return false;



	function stripeResponseHandler(status, response) {
	  // Grab the form:
	  var $form = $('#checkout-payment');

	  if (response.error) { // Problem!

        //alert(response.error.message);
		// Show the errors on the form:
        $form.find('.payment-errors').text(response.error.message);
        $("#btnSubmit").attr("disabled", false);
        setTimeout(function(){ $form.find('.payment-errors').text(''); }, 5000);
		//$form.find('.submit').prop('disabled', false); // Re-enable submission

	  } else { // Token was created!
          var token = response.id;

		// Insert the token ID into the form so it gets submitted to the server:
		$form.append($('<input type="hidden" name="stripeToken">').val(token));

		// Submit the form:
        /*$form.get(0).submit();*/



        var n = $(".shipping-first-div").css('display');
       if(n == 'none'){

        if ($('input:radio[name=addressid]:checked').length > 0) {

        }else{

            $(".showerrormessage").show();
            $(".showerrormessage").html("");
            $('#btnSubmit').attr("disabled", false);
           $(".showerrormessage").html("<p style='color:red'>Please select address</p>");
           setTimeout(function(){ $(".showerrormessage").hide() }, 5000);
           return false
        }
      }

           $(".showloaderimg").show();


        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url: '{{url('saveorder')}}',
              type: 'POST',
              dataType: 'JSON',
              data:$("#checkout-payment").serialize(),

              beforeSend: function (xhr) {

              },
             success: function (json) {
                 if(json.status == true){
                 var redirtecturl = '{{ URL::to('thankyou/') }}';

                $(".showloaderimg").hide();
                $('body').removeClass('bg-blurs');
                //$(".returnmessage").html(json.message)
                setTimeout(function(){
                    window.location.href = redirtecturl+'/'+json.orderid;
                 }, 1000);
                }else{
                    $(".returnmessage").html(json.message)
                    setTimeout(function(){
                        window.location.href = '{{ URL::to('cart/') }}';
                     }, 1000);
                }

            },
                error: function (xhr, ajaxOptions, thrownError) {
                    var obj = $.parseJSON(xhr.responseText);
                    $(".showloaderimg").hide();
                    $(".returnmessage").html('<p style="color:red">Amount must not be more than $999,999.99</p>');



            }
    });

	  }
	};

     }

 $(document).ready(function($){



    $(".shippingMobile").mask("400 000 000");
    $(".billingMobile").mask("400 000 000");
    $(".shipping_mobileno1").mask("400 000 000");
    $(".cardnumbervalidate").mask("9999 9999 9999 9999");

   $(".showaddressdiv").on('click',function(){

    $(".shipping-first-div").toggle();

      $('input:radio[name=addressid]:checked').removeAttr('checked');

   })



   $("input[name$='addressid']").click(function() {
    $(".shipping-first-div").hide();
  });

$('input[name="shiping_name"]').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});

$('input[name="shiping_last_name"]').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});



$('input[name="shipping_suburb"]').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});

$('input[name="billing_name"]').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});



$('input[name="billing_last_name"]').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});

$('input[name="billing_suburb"]').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});



$(function() {
    $('input[name="card_number"]').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});



$(function() {
    $('input[name="shiping_Unit_number"]').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});

$(function() {
    $('input[name="shiping_Street_number"]').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});







$(function() {
    $('input[name="billing_Unit_number"]').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});

$(function() {
    $('input[name="billing_Street_number"]').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});


$(function() {
    $('input[name="billing_postcode"]').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});



    });


    function EditAddress(id)
    {

        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url: '{{url('editaddress')}}',
              type: 'GET',
              dataType: 'HTML',
              data:{"id": id},

              beforeSend: function (xhr) {

              },
             success: function (json) {

               $(".carddetail").show();
               $('body').addClass('bg-blurs');
               $(".modal-body").html(json);

               $('input[name="shiping_name"]').keydown(function (e) {
                if (e.shiftKey || e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });

            $('input[name="shiping_last_name"]').keydown(function (e) {
                if (e.shiftKey || e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });
            $('input[name="shipping_suburb"]').keydown(function (e) {
                if (e.shiftKey || e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });

            $('input[name="billing_name"]').keydown(function (e) {
                if (e.shiftKey || e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });

            $('input[name="billing_last_name"]').keydown(function (e) {
                if (e.shiftKey || e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });

            $('input[name="billing_suburb"]').keydown(function (e) {
                if (e.shiftKey || e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });




    $(function() {
        $('input[name="shiping_Unit_number"]').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });

    $(function() {
        $('input[name="shiping_Street_number"]').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });


    $(function() {
        $('input[name="shipping_postcode"]').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });


    $(function() {
        $('input[name="billing_Unit_number"]').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });

    $(function() {
        $('input[name="billing_Street_number"]').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });


    $(function() {
        $('input[name="billing_postcode"]').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });



           $(addressfrm).validate({


                rules: {
                    shiping_name : { required: true},
                    shiping_last_name : { required: true},
                    shipping_suburb : {required: true },
                    shiping_Unit_number : {required: true },
                    shiping_Street_number:{required:true},
                    shipping_state : {required:true},
                    shipping_postcode : {required: true,minlength:1,maxlength:6 },
                    shipping_address_one :{required: true},
                    shipping_mobileno : {required: true},

                    billing_name : { required: true},
                    billing_last_name : { required: true},
                    billing_suburb : {required: true },
                    billing_Unit_number : {required: true },
                    billing_Street_number:{required:true},
                    billing_state : {required:true},
                    billing_postcode : {required: true,minlength:1,maxlength:6 },
                    billing_address_one :{required: true},
                    billing_mobileno : {required: true},


                    addressid:{ required:true }



                  },
                  messages :{
                      "shiping_name" : { required : 'This field is required.'},
                      "shiping_last_name" : { required : 'This field is required.'},

                      "shiping_Unit_number" : { required : 'This field is required.'},
                      "shiping_Street_number" : { required : 'This field is required.'},
                      "shipping_state" : { required : 'This field is required.'},

                      "shipping_suburb" : { required : 'This field is required.'},
                      "shipping_postcode" : { required : 'This field is required.'},
                      "shipping_address_one" : { required : 'This field is required.'},

                      "billing_mobileno" : { required : 'This field is required.'},
                      "shipping_mobileno" : { required : 'This field is required.'},

                      "billing_name" : { required : 'This field is required.'},
                      "billing_suburb" : { required : 'This field is required.'},
                      "billing_postcode" : { required : 'This field is required.'},
                      "billing_address_one" : { required : 'This field is required.'},

                      "billing_last_name" : { required : 'This field is required.'},

                      "billing_Unit_number" : { required : 'This field is required.'},
                      "billing_Street_number" : { required : 'This field is required.'},
                      "billing_state" : { required : 'This field is required.'},

                      "addressid": { required : "You must select an account type" }



                 },




                  submitHandler: function(addressfrm) {
                    postaddress('test');
                  },
                 invalidHandler: function(addressfrm, validator) {

                 },

           });


            },
                error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });

    }


    function postaddress(postData) {
   $(".showloaderimg").show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: '{{url('saveaddress')}}',
            type: 'POST',
            dataType: 'JSON',
            data:$("#addressfrm").serialize(),

            beforeSend: function (xhr) {

            },
           success: function (json) {
            $(".showloaderimg").hide();
               if(json.status == true){

              $('body').removeClass('bg-blurs');
              $(".returnmessagenew").html(json.message)
              setTimeout(function(){
                location.reload();
               }, 1000);
              }

          },
              error: function (xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
  });

    }





      function PaymentClose(){

          $(".carddetail").hide();
          $('body').removeClass('bg-blurs');
      };


      function set_checked_edit()
    {
        if($("input[name=sameaddress]").is(":checked") == true) {

            $(".hideselectval").hide();
            $(".showselectval").show();
           var shippingName =      $('.shiping_name').val();
           var shippingLastName =  $('.shiping_last_name').val();
           var shippingMobileno =  $('.shipping_mobileno1').val();
           var shippingAddress1 =  $('.shippingAddress3').val();
           var shippingAddress2 =  $('.shippingAddress4').val();
           var shippingSuburb =    $('.shipping_suburb').val();
           var shippingUnitNUmber =    $('.shiping_Unit_number').val();
           var shippingStreetNumber =    $('.shiping_Street_number').val();
           var shippingState =    $("#selectstateedit option:selected").val();

           var shippingPostcode =  $('.shipping_postcode').val();

           $('input[name="billing_name"]').val(shippingName);
           $('input[name="billing_last_name"]').val(shippingLastName);
           $('input[name="billing_mobileno"]').val(shippingMobileno);
           $('.billingAddress1').val(shippingAddress1);
           $('.billingAddress2').val(shippingAddress2);
           $('input[name="billing_suburb"]').val(shippingSuburb);
           $('input[name="billing_Unit_number"]').val(shippingUnitNUmber);
           $('input[name="billing_Street_number"]').val(shippingStreetNumber);
           $("#selectbillingstateedit option[value="+shippingState+"]").attr('selected', 'selected');
           $('input[name="billing_postcode"]').val(shippingPostcode);

          }else{


            $('input[name="billing_name"]').val('');
            $('input[name="billing_last_name"]').val('');
            $('input[name="billing_mobileno"]').val('');
            $('.billingAddress1').val('');
            $('.billingAddress2').val('');
            $('input[name="billing_suburb"]').val('');
            $('input[name="billing_postcode"]').val('');
            $('input[name="billing_Unit_number"]').val('');
            $('input[name="billing_Street_number"]').val('');

            $(".showselectval").hide();
            $(".hideselectval").show();


          }
    }
    </script>


