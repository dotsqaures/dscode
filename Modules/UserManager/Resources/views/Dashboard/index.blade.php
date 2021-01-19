@extends('layouts.inner_home')
@section('title','Product')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My <span>Listings</span></h1>
    </div>
    @include('layouts.admin.flash.alert')

    <div class="d-flex justify-content-end">
            {{ $Product->links() }}
    </div>

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

        @if(count($Product)>0)
        @foreach($Product as $product)

              <div class="col-lg-4 col-sm-6 listing-product-col">
                <div class="listing-box">
                    @if($product->is_feature == 1)
                  <span class="featured-icon-block">Featured</span>
                    @endif
                        <div class="listing-phone-box">

                                <?php
                                if(!empty($product->mainphoto)){ ?>


                               <a href="javascript:void(0)"><img src="{{ asset(Storage::url($product->mainphoto)) }}" alt=""></a>

                               <?php } else{ ?>
                                 <a href="javascript:void(0)"><img src="{{ asset('img/NoPhone_grande.png') }}" alt=""></a>

                              <?php } ?>

                            </div>
                  <div class="view-detail-btn"><a href="{{ url('product/'.$product->product_slug)}}" class="blue-btn btn">VIEW DETAILS</a></div>
                 <div class="product-details text-center">
                  <div class="product-message">
                      @php
                      $messageCount = \App\Helpers\BasicHelpers::CountUnreadMessage($product->id,$logInedUser->id) ;
                      @endphp
                  <a href="{{ url('mymessage/'.$product->id)}}"><i><img src="{{ asset('img/message_icon.png')}}" alt=""></i>
                  Messages <span class="unread-message">

                        @php
                        if($messageCount > 0)

                        echo  '('.$messageCount.')';

                        @endphp

                    </span></a>

                  </div>
                    <div class="star-rating ">
                            <input id="input-2" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $product->star_ratting }}" data-size="xs" disabled="">
                    </div>
                    <h2>{{ substr($product->item_title, 0, 45) . '...' }}</h2>
                    <p>{{ substr($product->item_description, 0, 30) . '...' }}</p>
                    <div class="product-price">
                        <span>$</span> @if(!empty($product->final_price)) 
                        {{ $product->final_price }}
                        @else 
                        {{ '0' }}
                        @endif
                    </div>
                  </div>
                <div class="product-btn-block productfeature">
                <div class="product-group-btn">
                    @if($product->status == 0)
                    <a href="{{ url('/editProduct/'.$product->id)}}" title="Edit Product"><span class="glyphicon glyphicon-pencil"></span></a>
                    @else 
                    <a href="javascript:voidd(0)" title="Not editable since approved by admin" class="disabled"><span class="glyphicon glyphicon-saved"></span></a>
                    @endif
                </div>
                <div class="product-group-btn"><a onClick="javascript: return confirm('Are you sure you want to delete this listing?')" href="{{ url('/deleteproduct/'.$product->id)}}" title="Delete Product"><i class="fa fa-trash" aria-hidden="true"></i></a></div>

                @if($product->is_feature == 1)

                <div class="product-group-btn"><a href="javascript:void(0)" title="Featured"><i class="fa fa-check" aria-hidden="true"></i> </a></div>
                @else
                    @if($product->is_sold == 1)
                    <div class="product-group-btn"><a href="javascript:void(0)"   title="Sold Out"><i class="fa fa-shopping-cart" aria-hidden="true"></i> </a></div>
                    @else
                    <div class="product-group-btn"><a href="javascript:void(0)" onclick='PaymentPopup("{{ $product->id }}")'  title="Make it Feature"><i class="fa fa-cog" aria-hidden="true"></i> </a></div>
                    @endif

                @endif


            </div>

              </div>
              </div>


              @endforeach

              @else
              <div class="col-lg-12 col-sm-12 listing-product-col" style="border:1px solid;">

             <p style="text-align:center;padding:15px 0 15px 0">No Listings found. Please add your first listing.</p>
                    </div>
              @endif




            </div>

            <div class="d-flex justify-content-end">
                    {{ $Product->links() }}
            </div>



    </div>


    </div>
    </div>

    </div>




    </div>

    </div>

    {{ Html::style('css/star.css') }}

    {{ Html::script('js/star-rating.js') }}
    {{ Html::style('css/star-boot.css') }}


{{ Html::script('js/star-rating-min.js') }}




<style>



          .rating-container .clear-rating{display:none !important}
          .rating-container .caption{display:none !important}
          .rating-xs { font-size: 1.0em !important;}
          .rating-container .filled-stars {
              position: absolute;
              left: 0;
              top: 0;
              margin: auto;
              color: #ffb400 !important;
              white-space: nowrap;
              overflow: hidden;
              -webkit-text-stroke: 1px #ffb400 !important;
            text-shadow: none !important;
          }

  </style>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>

       /* $("input[name='role_id']").change(function(){
        var roleid = $(this).val();
         $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
          url: '{{url('addrole')}}'+'/'+roleid,
            type: 'GET',
            dataType: 'JSON',
            data: {

                "role_id": roleid // method and token not needed in data
            },
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {

            },
           success: function (json) {
          if (json.status === true) {
          if(roleid == 1){
          window.location.reload();
           }else{
        window.location.href = '{{url('profile')}}';
         }
 } else {
 }
},
   error: function (xhr, ajaxOptions, thrownError) {
 alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
 }
  });
 });*/


function PaymentPopup(id){
  $(".productid").val(id);

  $(".carddetail").show();
  $('body').addClass('bg-blurs');
}

function PaymentClose(){

    $(".carddetail").hide();
    $('body').removeClass('bg-blurs');
}

</script>

<div class="modal carddetail" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-header-inner">
              <a href="javascript:void(0)" class="close" onclick='PaymentClose()'>&times;</a>

               <p>A featured listing will appear on the of all generic listings and will be displayed on the homepage to attract more potential buyers.</p>
               <div class="d-flex justify-content-between">
              <h5>Featured Listing Fees :- ${{ config('get.feature-price') }}</h5>
              <h5>Duration :- {{ config('get.expire-feature-listing') }}</h5>
               </div>
             </div>
          </div>
            <div class="returnmessage"></div>
            <div class="modal-body">
                    <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg" style="display:none;">
                    <form  method="POST" id="payment-form">
                            <span class="payment-errors"></span>

                            <div class="from-group search-col mb-3">
                              <label>Card Number</label>
                              <input type="text" class="form-control cardnumbervalidate"  data-stripe="number" placeholder='XXXX XXXX XXXX XXXX' name="card_number" onKeyPress="if(this.value.length==19) return false;" required>

                            </div>
                           <div class="row">
                             <div class="col-sm-8">
                               <div class="from-group search-col mb-3 expiration-col">
                              <label>Expiration (MM/YY)</label>
                                <div class="d-flex">
                                  <select class="form-control" data-stripe="exp_month" name="exp_Month" required>
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
                               <span> /</span>

                              <select class="form-control" data-stripe="exp_year" name="exp_year" required>
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
                            </div>
                             </div>
                             <div class="col-sm-4">
                               <div class="from-group search-col mb-3">
                              <label>CVV</label>
                               <input type="text" class="form-control" size="4" data-stripe="cvc" name="cvc" required>
                              </div>

                             </div>
                           </div>

                          <div class="d-flex justify-content-between  flex-wrap">
                            <div class="botton-block">
                            <input type="hidden" name="product_id" value="" class="productid">
                            <input type="submit" class="btn blue-btn" id="btnSubmit" value="Pay">
                             </div>
                             <div class="d-flex justify-content-center justify-content-md-end card-images">
                              <img src="img/master-card.png">
                              <img src="img/visa-card.png">
                              <img src="img/maesto-card.png">
                             </div>

                            </div>


                          </form>
                         </div>
                         <div class="modal-footer feature-popup-footer">
                                <div class="modal-footer-inner">
                                    <p><span class="font-weight-bold">Please note:</span> Featured listing fee are non-refundable regardless if your device sells or not.</p>
                               </div>
                           </div>
                </div>

        </div>
      </div>

@include('includes.footer')
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
{{ Html::script('js/jquery.mask.js') }}
<!-- TO DO : Place below JS code in js file and include that JS file -->
<script type="text/javascript">

    $(".cardnumbervalidate").mask("9999 9999 9999 9999");

	Stripe.setPublishableKey('pk_live_8AqLz7O5fJjKVrU9z5Ua1f2P00Ad2GEMgQ');

	$(function() {
        $('#btnSubmit').attr("disabled", false);
	  var $form = $('#payment-form');
	  $form.submit(function(event) {

        $("#btnSubmit").attr("disabled", true);
		// Disable the submit button to prevent repeated clicks:
		$form.find('.submit').prop('disabled', true);

		// Request a token from Stripe:
		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from being submitted:
		return false;
	  });
	});

	function stripeResponseHandler(status, response) {
	  // Grab the form:
	  var $form = $('#payment-form');

	  if (response.error) { // Problem!

		$('#btnSubmit').attr("disabled", false);
		$form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission
        return false;

	  } else { // Token was created!
          var token = response.id;

		// Insert the token ID into the form so it gets submitted to the server:
		$form.append($('<input type="hidden" name="stripeToken">').val(token));

		// Submit the form:
        /*$form.get(0).submit();*/

           $(".showloaderimg").show();
            var card_number  =  $('input[name=card_number]').val();
            var exp_month  = $('input[name=exp_month]').val();
            var exp_year =  $('input[name=exp_year]').val();
            var cvc =  $('input[name=cvc]').val();
            var productid =  $('input[name=product_id]').val();
            var amount =  '{{ config('get.feature-price') }}';





        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url: '{{url('featurepayment')}}',
              type: 'POST',
              dataType: 'JSON',
          data:{"card_number": card_number, "exp_month":exp_month,"exp_year":exp_year,"cvc":cvc,"productid":productid,"token":token,'amount':amount
            },

              beforeSend: function (xhr) {

              },
             success: function (json) {
                $(".showloaderimg").hide();
                $('body').removeClass('bg-blurs');
                $(".returnmessage").html(json.message)
                setTimeout(function(){ location.reload(); }, 2000);
            },
                error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });

	  }
	};
</script>





