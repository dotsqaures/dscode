<?php
error_reporting(E_ALL);
$meta = ''; //is set for meta data
$meta_type = "checkout"; //is set for meta data
include "include/header.php";

if (isset($_SESSION['CustomerId'])) {
	$customer = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM customer WHERE Cust_Unique_Code='" . $_SESSION['CustomerId'] . "'"));
} else {
	$customer = '';
}

// setupe of stripe payment

require_once 'stripe/lib/Stripe.php';

// $stripe['secret_key'];
Stripe::setApiKey($stripe['secret_key']);
Stripe::setApiKey($stripe['publishable_key']);

?>

<?php

$checkout = 1;

?>
<script>
    function validation(){}
</script>
<style type="text/css">

.menu .custom-search,.menu .box-my-cart,.navbar,footer,.copyright{
    display: none;
}
.remove_cart{
  display:none;
}

.hide{
	display:none;
}
.stripe-button-el{
	display: none !important;
}

.order-summary{
	    position: absolute;
    top: -10px;
    text-align: center;
    margin: auto;
    left: 34%;
    background: white;
    font-size: 18px !important;
    color: #898989;
    text-transform: uppercase;
}


/* radio box */
.mcheck {
	position: relative;
  display: block;
  margin-bottom: 1em;
}
.mcheck input[type="radio"] {
	display: none;
}
.mcheck input[type="radio"] + label {
	float: left;
	border-width: 1px;
	height: 1em;
	width: 1em;
	margin-right: 0.5em;
	position: relative;
	cursor: pointer;
}
.mcheck input[type="radio"]:checked + label:after {
	position: absolute;
	text-align: center;
	top: -3px;
	bottom:0 ;
	left: 0;
	right: 0;
}

.mcheck.iconBox input[type="radio"]:checked + label:after {
	top: .2em;
	bottom: .2em;
	left: .2em;
	right: .2em;
	content: "";
}

/* check box */
.mcheck.iconCheck input[type="radio"]:checked + label:after {
	content: url('images/true.png') ;

}

.mcheck input[type="radio"] + label {
	border-style: solid;
	border-color: #DDD;

	color: #060;
}
.mcheck.iconBox input[type="radio"] + label:after {
 	background-color: #F0F;


  text-shadow: none;
}

/* check box */
.mcheck {
	position: relative;
  display: block;
  margin-bottom: 1em;
}
.mcheck input[type="checkbox"] {
	display: none;
}
.mcheck input[type="checkbox"] + label {
	float: left;
	border-width: 1px;
	height: 1em;
	width: 1em;
	margin-right: 0.5em;
	position: relative;
	cursor: pointer;
	border:1px solid  #DDD;
}
.mcheck input[type="checkbox"]:checked + label:after {
	position: absolute;
	text-align: center;
	top: -3px;
	bottom:0 ;
	left: 0;
	right: 0;
}

.mcheck.iconBox input[type="checkbox"]:checked + label:after {
	top: .2em;
	bottom: .2em;
	left: .2em;
	right: .2em;
	content: "";
}

/* check box */
.mcheck.iconCheck input[type="checkbox"]:checked + label:after {
	content: url('images/true.png') ;

}

.mcheck input[type="radio"] + label {
	border-style: solid;
	border-color: #DDD;

	color: #060;
}
.mcheck.iconBox input[type="checkbox"] + label:after {
 	background-color: #F0F;


  text-shadow: none;
}

/* extra css */
.left-space{
	margin-left: 20px;
}

.bank-card {
    background-color: #f4f4f4;
    padding: 25px;

    width: 96%;
    margin-bottom: 10px;
    padding-left: 0px;
    margin-left: 20px;
    margin-bottom: 44px;
    padding-bottom: 57px;


}
.bank-card-group{
	margin-top: 10px;

}

.bank-card-group li a {
    display: inline-block;
    width: 39px;
    height: 25px;
    text-indent: -9999px;
    overflow: hidden;
    background: url(images/bank-card-group.png) left top no-repeat;
    opacity: .2;
    filter: alpha(opacity=20);

}

.bank-card-group li.fore2 a {
    background-position: -45px 0;

}

.bank-card-group li.fore1 a {
    background-position: 0 0;
}

.bank-card-group li.fore3 a {
    background-position: -91px 0;
}

.bank-card-group li.fore4 a {
    background-position: -136px 0;
}



/* css for new box */
.mb5 {
    margin-bottom: 5px!important;
}

.mt0 {
    margin-top: 0!important;
}

.ls-1 {
    letter-spacing: 1px;
}
.fs-10 {
    font-size: 10px!important;
}

.list-inline {
    padding-left: 0;
    list-style: none;
}

.need-assistance2 .list-inline li, .need-assistance3 .list-inline li {
    padding-left: 0;
    padding-right: 28px;
}



.icons-live-chat, .icons-tel, .icons-email-us {
    width: 22px;
    height: 16px;
}

.ico-l, .space-l {
    margin-right: 5px;
}

[class^="icons-"], [class*=" icons-"] {
    background-image: url(images/all_icon.png);
    background-position: 0 0;
    background-repeat: no-repeat;
    display: inline-block;
    line-height: 16px;
}

.icons-live-chat {
    background-position: 0 -24px;

}

#mobile_tel,#email_us{
	 position: relative;

}

.icons-tel {
    background-position: -35px -24px;

}

.icons-email-us {
    background-position: -63px -24px;


}

.text-dark {
    color: #000;
}

.list-inline li i{
	margin-bottom: -5px;
}

/* for the order summary */


.order-summary2{
	text-transform: uppercase;
}

.order-summary2 hr{
	    border-top: 1px solid #d7d7d7;
}

.order-summary2 .img-responsive{
	    margin:auto;
}

.order-summary2 h3,h5{
  font-size: 12px !important;
  margin:0;
  padding: 0;
  line-height: 18px!important;

}

.order-summary2 p{
  font-size: 11px !important;
  margin:0;
  padding: 0;
  line-height: 18px !important;

}

  .order-summary2 .item {
    padding: 25px 15px;
  }

  .order-summary-below{
     padding: 15px
  }

.order-summary-below p{
  font-size: 12px !important;
  margin:0;
  padding: 0;
  line-height: 22px !important;

}

.fs-16 {
    font-size: 14px!important;
}

.icons-double-right-arrow {
    width: 15px;
    height: 14px;
    background-position: -114px -120px;
        margin-top: 3px;
}

.icons-double-left-arrow {
    width: 15px;
    height: 14px;
    background-position: -114px -120px;
    transform: rotate(180deg);
        margin-top: 3px;
}



.btn-purpal{
	padding: 9px 28px !important;
}

.btn-purpal:hover{
   background: rgb(218,182,218);
   color:white !important;
   border: 2px solid  rgb(218,182,218) !important;

}

/* shipping step */
.shipping-step-wrap {
    overflow: hidden;
    padding-right: 12px;
   margin-bottom: 30px;
}
.shipping-step {
    height: 28px;
    line-height: 28px;
    background-position: 0 0;
    background-repeat: repeat-x;
    padding: 0;
    margin: 0;
    font-family: "Brandon Grotesque Medium";
    text-transform: uppercase;
    font-size: 11px;
    border-left: 1px solid #eee;
}
.shipping-step, .shipping-step .node:before, .shipping-step .node:after, .shipping-step .node:before, .shipping-step .node.ready:before, .shipping-step .node.over:before, .shipping-step .node.over {
    background-image: url(images/all_icon.png);
}

.shipping-step .fore1 {
    width: 38%;
    padding-left: 30px !important;
    z-index: 3;
}

.shipping-step .node {
    float: left;
    height: 28px;
    line-height: 28px;
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
    padding-left: 43px;
    font-family:century_gothic;
}

.shipping-step .node.ready:before {
    background-position: -19px -30px;
}

.shipping-step, .shipping-step .node:before, .shipping-step .node:after, .shipping-step .node:before, .shipping-step .node.ready:before, .shipping-step .node.over:before, .shipping-step .node.over {
    background-image: url(images/shipping-step-cache3.png);
}

.shipping-step .node:before {
    content: '';
    display: inline-block;
    width: 17px;
    height: 17px;
    background-position: -37px -30px;
    left: 18px;
    top: 6px;
    position: absolute;
}

.shipping-step .fore1:before {
    left: 5px;
}

.shipping-step .node:after {
    background-position: right -80px;
    position: absolute;
    display: block;
    content: '';
    width: 13px;
    height: 28px;
    right: -13px;
    top: 0;
}

.shipping-step .fore2 {
    width: 27%;
    z-index: 2;
}

.shipping-step .fore3 {
    width: 35%;
    z-index: 1;
}

.shipping-step .node.over {
    color: white;
    background-position: left -110px;
    background-repeat: repeat-x;
}

.shipping-step .node.over:before {
    background-position: -1px -30px;
}

.shipping-step .node.over:after {
    background-position: right -49px;
    z-index: 1;
}
.contact-us > ul > li{
    padding-right: 15px !important;
}

@media(min-width:992px) {
   .hidden-xs-opp{
   	 display: none;
   }
}

@media(max-width:992px) {
   .hidden-xs-my{
   	 display: none;
   }
   .bank-card{
     width:95%;
   }
}
@media (max-width:991px){
    .navbar-toggle{
        display:none !important;
    }
}
@media (max-width: 767px){
	form .mb-xs-15 {
      margin-bottom: 21px;
 }
 .shipping-step .fore2 {
    width: 30%;
 }
 .shipping-step .fore3 {
    width: 28%;
 }
 .shipping-step .fore1 {
    width: 42%;
 }
 .shipping-step-wrap {
    margin-bottom: 30px;
    margin-top: -28px;
 }
 form h2{
 	text-align: center;
 }
 .new-box{
 	margin-left: 0px !important;
 	border-top: 1px solid #eee;
    padding-top: 36px;
 }

 .need-assistance2{
   margin-top: 6px !important;
 }
 .credit-box-2{
	margin-top: 69px !important;
 }

 .credit-box-3{
	margin-top: 161px;
 }

 form .form-control{
 	    height: 45px;

 }
}

.credit-box-2{
	margin-top: 95px;
}

.credit-box-3{
	margin-top: 161px;
}
.btn-checkout:hover{
    border: none !important;
}
.error{
    color:#f90000;
}
</style>



<div class="container">
    <div class="securecheckout">
      <p>
          <i class="fa fa-lock"></i>
          Secure Checkout
      </p>
  </div>
	<div class="row">
	<div class="col-md-12">
		<!-- <h1>MY ACCOUNT</h1> -->
		<br /><br />
	</div>


			<div class="col-md-6" style="font-family: Calibri;">

			<?php

$paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; //Test or Live PayPal API URL
$paypal_id = $rowh['Paypal_Id']; //Business Email
$rand_no = rand(1111111111, 9999999999);

if (isset($_POST['guest_pass'])) {
	extract($_POST);
	$cust_u_id = date('ymdhis') . rand();
	$insert = query("INSERT into customer SET
                                'Cust_Unique_Code'='" . $cust_u_id . "',
                                'Cust_Fname'='" . $fname . "',
                                'Cust_LName'='" . $lname . "',
                                'Cust_Email'='" . $email . "',
                                'Cust_Password'='" . $guest_pass . "',
                                'Cust_Address'='" . $address . "',
                                'Cust_City'='" . $city . "',
                                'Cust_Country'='" . $country . "',
                                'Cust_State'='" . $state . "',
                                'Cust_ZipCode'='" . $postcode . "',
                                'Cust_Phone'='" . $mobile . "',
                                'Cust_Date'='" . date('Y-m-d H-i-s') . "',
                                'Cust_Status'='Active'");
}

if (isset($_POST['checkout'])) {
	//extract($_POST);

	if ($cemail == $email) {
		echo '';
	}
}

?>



				<form class="form-horizontal validate-form" method="POST" action="stripe_success.php" id="payment" onsubmit ="return stripe_near()">

					<!-- ======================================= Paypal Code =================================== -->

			          <!-- Identify your business so that you can collect the payments. -->
			        <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">

			        <!-- Specify a Buy Now button. -->
			        <input type="hidden" name="cmd" value="_cart">
			        <input type="hidden" name="upload" value="1">
			        
			        <!-- Specify details about the item that buyers will purchase. -->
			        <?php
/*$j = 0;
for ($i = 0; $i <= max(array_keys($product_id)); $i++) {

	if (isset($temp_array[$i])) {
		$j++;
		?>

							<input type="hidden" name="item_name_<?php echo $j; ?>" value="<?php echo $product_title[$i]; ?>">
						    <input type="hidden" name="amount_<?php echo $j; ?>" value="<?php echo $product_price[$i]; ?>">

							<?php

	}
}*/
?>
    <input type="hidden" name="item_name_1" value="<?php echo implode(', ',$product_title); ?>">
    <input type="hidden" name="amount_1" value="<?php if ($_SESSION['total1']) {echo $_SESSION['total1'];} else {echo $_SESSION['total'];}?>">





			        <input type="hidden" name="currency_code" value="USD">
			        <input type='hidden' name='no_shipping' value='1'>



			        <!-- Specify URLs -->
			        <input type='hidden' name='cancel_return' value='<?php echo websiteurl; ?>cancel.php'>
			        <input type='hidden' name='return' value='<?php echo websiteurl; ?>success.php'>

			        <input type='hidden' name='rm' value='2'>
			        <!-- ======================================= Paypal Code =================================== -->

		          <fieldset>
		            <div id="legend">
		              <!-- <legend style="font-weight: bold;"><h1>SECURE CHECKOUT</h1></legend> -->
		            </div>


		        <!--- start of main form section -->
		        <div class="shipping-step-wrap hidden-xs-opp">
			         <ul class="shipping-step">
			           <li class="node fore1 ready ">Shipping + Billing</li>
			           <li class="node fore2">Payment</li>
			           <li class="node fore3">Review Order</li>
			         </ul>
			    </div>
		     	<div id='main_form'>

                    <h2>SHIPPING ADDRESS</h2><br/>

                    <div class="row">
                       <div class="col-sm-6 mb-xs-15">
                          <div class="control-group">
				               <!--<label class="control-label" for="fname">FIRST NAME &nbsp;<a data-toggle="tooltip" title="Enter Your First Name Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				               <div class="controls">
				                <input type="text" id="fname" name="fname" style="border-radius: 0px;" value="<?php if (isset($_POST['fname'])) {echo $_POST['fname'];}?>" placeholder="FIRST NAME" class="form-control " required="true">
				               </div>
				           </div>
                       </div>

                       <div class="col-sm-6 ">
                           <div class="control-group">
				              <!--<label class="control-label" for="lname">LAST NAME &nbsp;<a data-toggle="tooltip" title="Enter Your Last Name Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="lname" name="lname" style="border-radius: 0px;" value="<?php if (isset($_POST['lname'])) {echo $_POST['lname'];}?>" placeholder="LAST NAME" class="form-control " required="true">
				              </div>
				           </div>
                       </div>

                    </div>

                    <br/>

		            <div class="control-group">
		              <!--<label class="control-label" for="address">ADDRESS LINE &nbsp;<a data-toggle="tooltip" title="Enter Your Address Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
		              <div class="controls">
		                <input type="text" id="address" name="address" style="border-radius: 0px;" placeholder="ADDRESS LINE 1" class="form-control " required="true">
		              </div>
		            </div>

		            <br/>

		            <div class="control-group">
		              <!--<label class="control-label" for="address2">ADDRESS LINE 2 &nbsp;<a data-toggle="tooltip" title="Enter Your Address Line 2 Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
		              <div class="controls">
		                <input type="text" id="address2" name="address2" style="border-radius: 0px;" placeholder="ADDRESS LINE 2" class="form-control">
		              </div>
		            </div>

                    <br/>

		            <div class="row">

                       <div class="col-sm-6 mb-xs-15">

				            <div class="control-group">
				              <!--<label class="control-label" for="city">CITY &nbsp;<a data-toggle="tooltip" title="Enter Your City Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>-->
				              <div class="controls">
				                <input type="text" id="city" name="city" style="border-radius: 0px;" value="<?php if (isset($_POST['city'])) {echo $_POST['city'];}?>" placeholder="CITY" class="form-control " required="true">
				              </div>
				            </div>

                       </div>

                       <div class="col-sm-6">
                           <div class="control-group">
				              <!--<label class="control-label" for="state">STATE &nbsp;<a data-toggle="tooltip" title="Select Your State Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="state" name="state" style="border-radius: 0px;" value="<?php if (isset($_POST['state'])) {echo $_POST['state'];}?>" placeholder="STATE" class="form-control " required="true">
				              </div>
				           </div>
                       </div>

                    </div>

                    <br/>

                    <div class="row">

                       <div class="col-sm-6 mb-xs-15">
                            <div class="control-group">
				              <!-- <label class="control-label" for="country">COUNTRY &nbsp;<a data-toggle="tooltip" title="Select Your Country Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="country" name="country" style="border-radius: 0px;" value="<?php if (isset($_POST['country'])) {echo $_POST['country'];}?>" placeholder="COUNTRY" class="form-control " required="true">
				              </div>
				            </div>
                       </div>

                       <div class="col-sm-6 ">

			            <div class="control-group">
			              <!--<label class="control-label" for="postcode">POSTCODE &nbsp;<a data-toggle="tooltip" title="Enter Your Postcode Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
			              <div class="controls">
			                <input type="text" id="postcode" name="postcode" style="border-radius: 0px;" value="<?php if (isset($_POST['postcode'])) {echo $_POST['postcode'];}?>" placeholder="POST CODE" class="form-control " required="true">
			              </div>
			            </div>

                       </div>


                    </div>

                    <br/>

		            <div class="row">

		            	<div class="col-sm-6 mb-xs-15">

				            <div class="control-group">
				              <!--<label class="control-label" for="email">EMAIL &nbsp;<a data-toggle="tooltip" title="Enter Your Email Address Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <?php if (empty($customer)) {?>
				                <input type="email" id="email" name="email" style="border-radius: 0px;" value="<?php if (isset($_POST['email'])) {echo $_POST['email'];}?>" placeholder="EMAIL" class="form-control " required="true">
				                <?php } else {?>
				                <input type="email" id="email" name="email" style="border-radius: 0px;" value="<?php echo $customer['Cust_Email']; ?>" placeholder="EMAIL" class="form-control" required="true" readonly>
				                <?php }?>
				              </div>
				            </div>

		            	</div>

		            	<div class="col-sm-6">

		            	   <div class="control-group">
				              <!--<label class="control-label" for="Mobile">MOBILE &nbsp;<a data-toggle="tooltip" title="Enter Your Mobile Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="mobile" name="mobile" style="border-radius: 0px;" value="<?php if (isset($_POST['mobile'])) {echo $_POST['mobile'];}?>" placeholder="MOBILE" class="form-control " required="true">
				              </div>
				           </div>

		            	</div>

		            </div>








		            <br/><h2>BILLING ADDRESS</h2><br/>




                        <span class="mcheck iconCheck">

		                  <input type="checkbox" checked="checked" value="1" class="checkboxdata" id="same_address" name="same_address" placeholder="" style="margin-top:3px"  >
						  <label for="same_address"></label>
						    Same as shipping address
					   </span>






		            <div id="billing_section" style="display:none">

		            	<br/>

		              <div class="row">

		              	 <div class="col-sm-6 mb-xs-15">

		              	   <div class="control-group">
			              <!--<label class="control-label" for="fname">FIRST NAME &nbsp;<a data-toggle="tooltip" title="Enter Your First Name Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
			              <div class="controls"> -->
			                <input type="text" id="fname_s" name="fname_s" style="border-radius: 0px;" value="<?php if (isset($_POST['fname'])) {echo $_POST['fname'];}?>" placeholder="FIRST NAME" class="form-control " >
			              </div>


		              	 </div>

		              	 <div class="col-sm-6 ">


				            <div class="control-group">
				              <!--<label class="control-label" for="lname">LAST NAME &nbsp;<a data-toggle="tooltip" title="Enter Your Last Name Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="lname_s" name="lname_s" style="border-radius: 0px;" value="<?php if (isset($_POST['lname'])) {echo $_POST['lname'];}?>" placeholder="LAST NAME" class="form-control " >
				              </div>
				            </div>

		              	 </div>

		              </div>

		             <br/>

		            <div class="control-group">
		              <!--<label class="control-label" for="address">ADDRESS LINE &nbsp;<a data-toggle="tooltip" title="Enter Your Address Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
		              <div class="controls">
		                <input type="text" id="address_s" name="address_s" style="border-radius: 0px;" placeholder="ADDRESS LINE 1" class="form-control " >
		              </div>
		            </div>

		            <br/>

		            <div class="control-group">
		              <!--<label class="control-label" for="address2">ADDRESS LINE 2 &nbsp;<a data-toggle="tooltip" title="Enter Your Address Line 2 Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>-->
		              <div class="controls">
		                <input type="text" id="address2_s" name="address2_s" style="border-radius: 0px;" placeholder="ADDRESS LINE 2" class="form-control " >
		              </div>
		            </div>

                     <br/>
		            <div class="row">

		              	 <div class="col-sm-6 mb-xs-15">

				            <div class="control-group">
				              <!--<label class="control-label" for="city">CITY &nbsp;<a data-toggle="tooltip" title="Enter Your City Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="city_s" name="city_s" style="border-radius: 0px;" value="<?php if (isset($_POST['city'])) {echo $_POST['city'];}?>" placeholder="CITY" class="form-control " >
				              </div>
				            </div>

		              	 </div>

		              	 <div class="col-sm-6">


				            <div class="control-group">
				              <!--<label class="control-label" for="state">STATE &nbsp;<a data-toggle="tooltip" title="Select Your State Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="state_s" name="state_s" style="border-radius: 0px;" value="<?php if (isset($_POST['state'])) {echo $_POST['state'];}?>" placeholder="STATE" class="form-control ">
				              </div>
				            </div>


		              	 </div>

		            </div>

                    <br/>

		            <div class="row">

		              	 <div class="col-sm-6 mb-xs-15">

		              	     <div class="control-group">
				              <!--<label class="control-label" for="country">COUNTRY &nbsp;<a data-toggle="tooltip" title="Select Your Country Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="country_s" name="country_s" style="border-radius: 0px;" value="<?php if (isset($_POST['country'])) {echo $_POST['country'];}?>" placeholder="COUNTRY" class="form-control ">
				              </div>
				            </div>

		              	 </div>

		              	 <div class="col-sm-6">

				            <div class="control-group">
				              <!--<label class="control-label" for="postcode">POSTCODE &nbsp;<a data-toggle="tooltip" title="Enter Your Postcode Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="text" id="postcode_s" name="postcode_s" style="border-radius: 0px;" value="<?php if (isset($_POST['postcode'])) {echo $_POST['postcode'];}?>" placeholder="POST CODE" class="form-control " >
				              </div>
				            </div>

		              	 </div>

		            </div>

                    <br/>

		            <!--<div class="row">

		              	 <div class="col-sm-6 mb-xs-15">

				            <div class="control-group">
				              
				              <div class="controls">

				                <input type="email" id="email" name="email_s" style="border-radius: 0px;" value="<?php if (isset($_POST['email'])) {echo $_POST['email'];}?>" placeholder="EMAIL" class="form-control " >
				              </div>
				            </div>

		              	 </div>

		              	 <div class="col-sm-6">

		              	   <div class="control-group">
				              
				              <div class="controls">
				                <input type="text" id="mobile_s" name="mobile_s" style="border-radius: 0px;" value="<?php if (isset($_POST['mobile'])) {echo $_POST['mobile'];}?>" placeholder="MOBILE" class="form-control " >
				              </div>
				           </div>

		              	 </div>

		            </div>-->


		           </div>


		           <!-- complete credit field --><br/>
				<?php
if (!isset($_SESSION['CustomerId'])) {
	?>
				<h2>SAVE YOUR ACCOUNT <small style="color:inherit;">(Optional)</small></h2><br/>

				  	 <div id="pass_error" style="color:red;"></div>

                     <div class="row">

                       <div class="col-sm-6 mb-xs-15">

                            <div class="control-group">

				              <!--<label class="control-label" for="password">Password &nbsp;<a data-toggle="tooltip" title="Enter Your Favourite Password Here."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
				              <div class="controls">
				                <input type="password" onblur="validation()" id="guest_pass" name="guest_pass" style="border-radius: 0px;" value="<?php if (isset($_POST['guest_pass'])) {echo $_POST['guest_pass'];}?>" placeholder="PASSWORD" class="form-control " >
				              </div>
				            </div>

                       </div>

                       <div class="col-sm-6">

                         <div class="control-group">

			              <!--<label class="control-label" for="cpassword">Confirm Password &nbsp;<a data-toggle="tooltip" title="Enter Same Password Again."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label> -->
			              <div class="controls">
			                <input type="password" onblur="validation()" id="cguest_pass" name="cguest_pass" style="border-radius: 0px;" value="<?php if (isset($_POST['cguest_pass'])) {echo $_POST['cguest_pass'];}?>" placeholder="CONFIRM PASSWORD" class="form-control " >
			              </div>
			            </div>

                       </div>

                     </div>




		            <?php }?>






		         <br /> <br />
		          <div class="control-group">
		              <!-- Button -->

		              <div class="controls">

		              </div>
		            </div>

                </div>

		            <!--- end of main form section -->

		            <!-- start credit fields -->
		            <div style="display:none" id="payment-form" >
		            <h2>CHOOSE YOUR PAYMENT</h2>

		            <div id="info_save_msg" class="alert alert-success">Your information have been successfully saved.</div>

		             <div class="control-group">

						<div class="payment-errors" style="color:red;margin-top:5px" ></div>
				     </div>



					    <span class="mcheck iconCheck">
						  <input type="radio" checked="checked" name="paypal_type" id="test-2" onclick="check_paypal_type()" value="pro" />
						  <label for="test-2"></label>




						<h4 style="margin-bottom: 0px">PAY ONLINE WITH A CREDIT CARD</h4>
						<p class="left-space">Use your Visa, MasterCard, American Express, or Discover.</p>
					   </span>

					<div id="credit-section"  class="bank-card">

						<div class="control-group left-space">
						  <label class="control-label col-sm-4" for="card_number" style="text-align:left;">
						  CREDIT CARD NUMBER
						  <!--<a data-toggle="tooltip" title="Enter Your Card Number"><i class="fa fa-question-circle" aria-hidden="true"></i></a>-->
						  </label>
						  <div class="col-sm-8">
					       <input type="text" size="20" id="number" data-stripe="number" name="card_numbers" class="form-control " onblur="error()" style="border-radius: 0px">
					       <ul class="bank-card-group list-inline">
				               <li class="fore1"><a href="javascript:void(0);" id="american_express">American Express</a></li>
				               <li class="fore2"><a href="javascript:void(0);" id="mastercard">MasterCard</a></li>
				               <li class="fore3"><a href="javascript:void(0);" id="visa">visa</a></li>
				               <li class="fore4"><a href="javascript:void(0);" id="discover">Discover</a></li>
				            </ul>
					 	  </div>


						</div>

						<div class="control-group left-space credit-box-2">
							<label class="control-label col-sm-4 col-xs-12" style="text-align: left">
							  Expiration
							 <!-- <a data-toggle="tooltip" title="Enter Card Expiration Month and Year"><i class="fa fa-question-circle" aria-hidden="true"></i></a> -->
							</label>



							<div class="col-xs-6 col-sm-3" >

								 <select class="form-control"  id="exp_month" data-stripe="exp_month" onblur="error()" style="border-radius: 0px">
								   <?php
for ($i = 1; $i < 13; $i++) {
	?>
								         <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								       <?php

}
?>
								 </select>

								 </select>
							</div>

							<div class="col-xs-6 col-sm-5" >

								<select id="exp_year" data-stripe="exp_year" class="form-control " onblur="error()" style="border-radius: 0px">
									<?php
									    $startYear = date('Y');
									    $endYear = date('Y',strtotime('+10 year'));
for ($i = $startYear; $i < $endYear; $i++) {
	?>
								         <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								       <?php

}
?>
								</select>
							</div>

						</div>



						<div class="control-group left-space credit-box-3">
							<label class="col-sm-4">
							  <span>CVC</span>
							  <!--<a data-toggle="tooltip" title="Enter Card CVC"><i class="fa fa-question-circle" aria-hidden="true"></i></a>-->
							</label>
							<div class="col-sm-3">
						      <input type="text" size="4" id="cvc" data-stripe="cvc" class="form-control " onblur="error()" style="border-radius: 0px">
							</div>


						</div>
                       </div>


                        <span class="mcheck iconCheck" >
						  <input type="radio" name="paypal_type" id="test-1" onclick="check_paypal_type()" value="paypal" />
						  <label for="test-1"></label>


						<h4 style="margin-bottom: 0px">PAY WITH PAYPAL</h4>
                         <p class="left-space">Check out with your PayPal account.</p>
                        </span>

						<br/><br/>
		                <div class="control-group left-space row">

                        <div class="col-xs-6" style="padding-left: 0;padding-right: 30px;">
		                  <a onclick="back_main_form()" style="border:2px solid #cc99cc;letter-spacing: 1px;text-transform:uppercase;width:100%;text-align:right;float: left;cursor: pointer;"  class="btn-purpal" >Back
		                    <i class="icons-double-left-arrow pull-left"></i>
		                  </a>
                        </div>

                        <div class="col-xs-6" >
						  <button style="border:2px solid #cc99cc;letter-spacing: 1px;text-transform:uppercase;width:100%;text-align:left" type="submit" class="btn-purpal" value="Submit Payment">CONTINUE <i class="icons-double-right-arrow pull-right"></i></button>
						</div>

						</div>
					</div>



		            <div class="control-group row">
		              <!-- Button -->

		              <div class="controls col-xs-12 col-sm-6">
		                <button id="paypal_submit_btn"  style="border:2px solid #cc99cc;letter-spacing: 1px;text-transform:uppercase;width:100%;text-align:left" type="submit" class="btn-purpal" name="checkout"> CONTINUE &nbsp;&nbsp;<i class="icons-double-right-arrow pull-right"></i></button>

		              </div>
		            </div>
		          </fieldset>
		        </form>


			</div>


			<div class="col-md-5" style="padding-left:20px;font-family:Calibri;">

		            <div class="shipping-step-wrap hidden-xs-my">
			         <ul class="shipping-step">
			           <li class="node fore1 ready ">Shipping + Billing</li>
			           <li class="node fore2">Payment</li>
			           <li class="node fore3">Review Order</li>
			         </ul>
			        </div>


		            <div class="col-md-12 order-summary2 hidden-xs-my" style="border: 1px solid #d7d7d7;padding:0px;margin-bottom: 30px;font-family:century_gothic;">

		                <h5 class="order-summary">order Summary</h5>
		            	<?php include "cart_block-checkout.php";?>


		            </div>


		            <!-- NEW BOX -->
                    <div class="new-box" style="margin-top: 20px;margin-left: 25px;">
			           <p align="center">
				          <span class="glyphicon glyphicon-lock mr5 text-dark"></span> <span class="text-dark">Secure Checkout</span
				       </p>
					   <div class="fs-12 brandon-medium need-assistance2" align="center">
					    <h4 class="h6 text-dark ls-1 mt0 mb5" align="left">NEED ASSISTANCE?</h4>
					     <div class="contact-us">
                            <ul>
                                <li><a href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comments"></i>Live Chat</a></li>
                                <li><a href="mailto:support@brilacci.com" target="_blank"><i class="fa fa-envelope"></i>support@brilacci.com</a></li>
                                <li><a href="tel:4243941252"><i class="fa fa-phone"></i>(424) 394-1252</a></li>
                            </ul>
                        </div>
					   </div>
					</div>
				<!-- END OF NEW BOX -->
			</div>
	</div>
</div>
<br /><br /><br /><br />
<div class="clearfix"></div>
<!-- Trigger the modal with a button -->

<?php include "include/footer.php";?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script>

function error(){

	 $('#payment-errors1').hide();
}


function check_paypal_type(){

	var test = $('input[name=paypal_type]:checked', '#payment').val();
    if(test=="paypal"){

        //$('#payment-form').hide();
        $('#credit-section').hide();
        //$('#paypal_submit_btn').show();
        $('#payment').attr('onsubmit', 'return payment()');
        $('#payment').attr('action', '<?php echo $paypal_url; ?>');
        $('#payment-form input').removeAttr('required');
        $('#payment-form input').removeAttr('required');
        $('#payment-form input').removeAttr('required');
        $('#payment-form input').removeAttr('required');

    }
    if(test=="pro"){

       $('#credit-section').show();
       //$('#payment-form').show();
       //$('#paypal_submit_btn').hide();
       $('#payment').attr('onsubmit', 'return stripe()');
       $('#payment').attr('action', 'stripe_success.php');
       $('#payment-form input').prop('required',true);
       $('#payment-form input').prop('required',true);
       $('#payment-form input').prop('required',true);
      $('#payment-form input').prop('required',true);

    }
}



$('.checkboxdata').click(function(){

		  var a = $('.checkboxdata:checked').val();

		  if(typeof a == "undefined") {
		  	$("#billing_section").show();
		     $("#billing_section input").prop('required',true);
		     $("#billing_section input[name='address2_s']").removeAttr('required');
		  }
		  else{
		  	 $("#billing_section").hide();
             $("#billing_section input").removeAttr('required');
		  }
	});
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
	</script>
	    <script type="text/javascript">
		var form = document.getElementById('formID1'); // form has to have ID: <form id="formID">
		form.noValidate = false;
		form.addEventListener('submit', function(event) { // listen for form submitting
		        if (!event.target.checkValidity()) {
		            event.preventDefault(); // dismiss the default functionality
		            alert('Please, fill the form'); // error message
		        }
		    }, false);
    </script>
    <script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
	</script>
	    <script type="text/javascript">
		var form = document.getElementById('formID'); // form has to have ID: <form id="formID">
		form.noValidate = false;
		form.addEventListener('submit', function(event) { // listen for form submitting
		        if (!event.target.checkValidity()) {
		            event.preventDefault(); // dismiss the default functionality
		            alert('Please, fill the form'); // error message
		        }
		    }, false);



  function back_main_form(){

      //remive pink high light from shiping step
      $('.ready').removeClass('over');
      $('#main_form').show();
      $('#payment-form').hide();
      $('#paypal_submit_btn').show(); //work for stripe submit dont be confuse
      $('#payment').attr('onsubmit', 'return stripe_near()');

    /*  $('#payment').attr('action', 'stripe_success.php'); */
       $('#payment-form input').removeAttr('required');
        $('#payment-form input').removeAttr('required');
        $('#payment-form input').removeAttr('required');
        $('#payment-form input').removeAttr('required');
  }

   function stripe_near(){
   	   //hear we check if the save account section validation

   	  // var fname = $('#fname').val();
		// var lname = $('#lname').val();
		var gpass = $('#guest_pass').val();
		var cgpass = $('#cguest_pass').val();
		//alert(gpass);
		    if(gpass!='' || cgpass!=''){
		    	if(gpass != cgpass)
				{
					$('#pass_error').html('Password And Confirm Password Must Be Same !');

					return false;
				}
				else
				{
                    $('#pass_error').html('');
		            //alert('else');
					//now check the email exist or not
					 $.ajax({
				          type:'POST',
				          url:'ajax/email_exist.php',
				          data:$('#payment').serialize(),
				          async: false,
				          success:function(src){
				           //alert(src);
				            if(src=='1'){
		                      $('#pass_error').html('Email already exist.');

		                      flag=0;
		                       return false;
				            }
				            else{
				               $('#pass_error').html('');
				               flag=1;
                                 return false;
				            }
				          }
				     });

					if(flag==0){

						//alert('no');
						return false;
					}
					else
					{
						$('#payment-form').show();
				        $('#paypal_submit_btn').hide();
				        test = $('input[name=paypal_type]:checked').val();

				         if(test=='pro'){

				           $('#payment').attr('onsubmit', 'return stripe()');
				           $('#payment-form input').prop('required',true);
				           $('#payment-form input').prop('required',true);
				           $('#payment-form input').prop('required',true);
				           $('#payment-form input').prop('required',true);
				         }else{
		                   $('#payment').attr('onsubmit', 'return payment()');
				         }

				        $('#main_form').hide();

                        //show credit form
                      //  alert('show');

				    	 $.ajax({
				          type:'POST',
				          url:'ajax/payment.php',
				          data:$('#payment').serialize(),
				          success:function(src){

				         console.log(src);

				          }
				        });

                        return false;
					}

				}//else part


		    }else{

		    	$('#payment-form').show();
		        $('#paypal_submit_btn').hide();

		         var test = $('input[name=paypal_type]:checked').val();

		         if(test=='pro'){

		           $('#payment').attr('onsubmit', 'return stripe()');
		           $('#payment-form input').prop('required',true);
		           $('#payment-form input').prop('required',true);
		           $('#payment-form input').prop('required',true);
		           $('#payment-form input').prop('required',true);
		         }
		         else{
                   $('#payment').attr('onsubmit', 'return payment()');
		         }



		        $('#main_form').hide();
		         //light the shipping step one
		         $(".ready").addClass("over");

		    	$('#pass_error').html('');

		    	//alert('show');


		    	 $.ajax({
		          type:'POST',
		          url:'ajax/payment.php',
		          data:$('#payment').serialize(),
		          success:function(src){

		       //   alert(src);

		          }
		        });

		    	return false;
		    	//show credit card form
		    }





		 return false;

   }



   function payment(){

   	  //hear we check if the save account section validation

   	  // var fname = $('#fname').val();
		// var lname = $('#lname').val();
		var gpass = $('#guest_pass').val();
		var cgpass = $('#cguest_pass').val();
		//alert(gpass);
		    if(gpass!='' || cgpass!=''){
		    	if(gpass != cgpass){
					$('#pass_error').html('Password And Confirm Password Must Be Same !');

					return false;
				}
				else
				{
                    $('#pass_error').html('');
		            //alert('else');
					//now check the email exist or not
					 $.ajax({
				          type:'POST',
				          url:'ajax/email_exist.php',
				          data:$('#payment').serialize(),
				          async: false,
				          success:function(src){

				           //alert(src);

				            if(src=='1'){
		                      $('#pass_error').html('Email already exist.');

		                      flag=0;

				            }
				            else{
				               $('#pass_error').html('');
				               flag=1; }

				          }
				     });

					if(flag==0){
						return false;
					}
					else
					{
						return true;
					}

				}//else part


		    }else{
		    	 $('#pass_error').html('');
		    }
		       $.ajax({
		          type:'POST',
		          url:'ajax/payment.php',
		          data:$('#payment').serialize(),
		          success:function(src){
		          //alert(src);
		          }
		        });
   }
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript">
      Stripe.setPublishableKey('<?php echo $stripe['publishable_key']; ?>');
    </script>
	<script type="text/javascript">

 function stripe(){


       $('#info_save_msg').hide();

	     $('.payment-errors').html('Loading...');
		var $form = $('#payment');


		// Disable the submit button to prevent repeated clicks:
		$form.find('.submit').prop('disabled', true);

		// Request a token from Stripe:
		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from being submitted:
		return false;
	}

	function stripeResponseHandler(status, response) {
	// Grab the form:
	var $form = $('#payment');

	if (response.error) { // Problem!

		// Show the errors on the form:
		$form.find('.payment-errors').html('<div class="alert alert-danger" id="payment-errors1">'+response.error.message+'</div>');
		$form.find('.submit').prop('disabled', false); // Re-enable submission

		} else { // Token was created!

		//  $.ajax({
		// 	type:'POST',
		// 	url:'ajax/payment.php',
		// 	data:$('#payment').serialize(),
		// 	success:function(src){
		// }
		// });

		// Get the token ID:
		var token = response.id;

		// Insert the token ID into the form so it gets submitted to the server:
		$form.append($('<input type="hidden" name="stripeToken">').val(token));

		// Submit the form:
		$form.get(0).submit();
		}
	}
	</script>



