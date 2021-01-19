
@php
    //$homePageSettings = homePageSettings();
@endphp
@extends('layouts.inner_home')
@section('content')
<div class="middle-wrapper ">
  <nav aria-label="breadcrumb" class="breadcrumb-block" >
<div class="container">
  <div class="row">
    <div class="col-12">



            <ol class="breadcrumb">
                    <li style="padding:0 4px 0 0"><a href="{{ URL::to('/') }} "><i class="fa fa-dashboard"></i>Home / </a></li>
                    <li style="padding:0 4px 0 0"><P> {{ ' '.$Product->item_title }}</P></li>
                </ol>




    </div>
  </div>
</div>
</nav>
<div class="container">
<div class="row product-detail-page pad-t40 pad-b40">
    <div class="col-12">
        @include('layouts.admin.flash.alert')
        <h1>Listing <span>Details</span></h1>
    </div>
    <div class="col-md-6 col-12">
        <div class="product-det-slider">
            <div class="thumbnail-slider1">

            <div class="thumb-img-box">

                    <div class="slider">
                            <div id="slider" class="flexslider top-flexslider-slider">
                              <ul class="slides">

                                    @if(!empty($Product->mainphoto))
                                     <li>
<a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->mainphoto)) }}"><img src="{{ asset(Storage::url($Product->mainphoto)) }}" /></a>
                                      </li>
                                      @else
                                      <li>
                                     <img src="{{ asset('img/NoPhone_grande.png') }}"  style="height:442px"/>
                                      </li>

                                      @endif



                                      @if(!empty($Product->backphoto))
                                      <li>
                                    <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->backphoto)) }}"><img src="{{ asset(Storage::url($Product->backphoto)) }}" /></a>

                                       </li>
                                       @endif
                                       
                                       
                                        @if(!empty($Product->leftphoto))
                                      <li>
                                    <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->leftphoto)) }}"><img src="{{ asset(Storage::url($Product->leftphoto)) }}" /></a>

                                       </li>
                                       @endif

                                       @if(!empty($Product->rightphoto))
                                     <li>

                                      <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->rightphoto)) }}"><img src="{{ asset(Storage::url($Product->rightphoto)) }}" /></a>
                                      </li>
                                      @endif


                                      @if(!empty($Product->topphoto))
                                      <li>

                                       <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->topphoto)) }}"><img src="{{ asset(Storage::url($Product->topphoto)) }}" /></a>
                                       </li>
                                       @endif


                                       @if(!empty($Product->bottomphoto))
                                       <li>

                                        <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->bottomphoto)) }}"><img src="{{ asset(Storage::url($Product->bottomphoto)) }}" /></a>
                                        </li>
                                        @endif

                                        @if(!empty($Product->scratchphoto))
                                        <li>

                                         <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->scratchphoto)) }}"><img src="{{ asset(Storage::url($Product->scratchphoto)) }}" /></a>
                                         </li>
                                         @endif


                                         @if(!empty($Product->scratchphoto2))
                                         <li>

                                          <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->scratchphoto2)) }}"><img src="{{ asset(Storage::url($Product->scratchphoto2)) }}" /></a>
                                          </li>
                                          @endif





                              </ul>
                            </div>
                            <div id="carousel" class="flexslider flexslider-thub-box">
                              <ul class="slides">
                                    @if(!empty($Product->mainphoto))
                                    <li>
                                     <img src="{{ asset(Storage::url($Product->mainphoto)) }}" />
                                     </li>
                                     @endif

                                     @if(!empty($Product->backphoto))
                                     <li>
                                      <img src="{{ asset(Storage::url($Product->backphoto)) }}" />
                                      </li>
                                      @endif
                                      
                                       @if(!empty($Product->leftphoto))
                                      <li>
                                    <a class="fancybox" rel="group" href="{{ asset(Storage::url($Product->leftphoto)) }}"><img src="{{ asset(Storage::url($Product->leftphoto)) }}" /></a>

                                       </li>
                                       @endif

                                      @if(!empty($Product->rightphoto))
                                    <li>
                                     <img src="{{ asset(Storage::url($Product->rightphoto)) }}" />
                                     </li>
                                     @endif


                                     @if(!empty($Product->topphoto))
                                     <li>
                                      <img src="{{ asset(Storage::url($Product->topphoto)) }}" />
                                      </li>
                                      @endif


                                      @if(!empty($Product->bottomphoto))
                                      <li>
                                       <img src="{{ asset(Storage::url($Product->bottomphoto)) }}" />
                                       </li>
                                       @endif

                                       @if(!empty($Product->scratchphoto))
                                       <li>
                                        <img src="{{ asset(Storage::url($Product->scratchphoto)) }}" />
                                        </li>
                                        @endif

                                        @if(!empty($Product->scratchphoto2))
                                         <li>
                                          <img src="{{ asset(Storage::url($Product->scratchphoto2)) }}" />
                                          </li>
                                          @endif


                              </ul>
                            </div>
                          </div>
        </div>
        </div>
        </div>
      </div>

    <div class="col-md-6 col-12">
        <div class="product-slide-content">
            <div class="prodcut-title">
                <h2>{{ $Product->item_title }}</h2>

            </div>
            <div class="product-ratting-col"><input id="input-2" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $Product->star_ratting }}" data-size="xs" disabled=""></div>
            <div class="prodcut-brand-outer d-lg-flex justify-content-between align-items-center">
              <div class="product-brand-col"><strong>Brand:</strong> {{ $Product->category->title }} </div>
              <div class="product-brand-col d-flex align-items-center"><strong>Share with:</strong>
                <span class="social-links-col d-flex">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ URL::to('product/'.$Product->product_slug) }}" class="social-button "><img src="{{ asset('img/facebook.png') }}" alt="..."></a>
                  <a href="https://twitter.com/intent/tweet?text=sellbuydevice&amp;url={{ URL::to('product/'.$Product->product_slug) }}" class="social-button "><img src="{{ asset('img/twitter.png') }}" alt="..."></a>
                  <a href="javascript:void(0)" onclick="openEmailPopup()"><img src="{{ asset('img/email.png') }}" alt="..."></a>
                  <a href="javascript:void(0)" title="Copy link" onclick="copyToClipboard('#texttocopy')" alt="Copy link" ><img src="{{ asset('img/copy.png') }}" ></a>

                  <p id="texttocopy" style="display:none;"> {{ URL::to('product/'.$Product->product_slug)  }}</p>

                </span>
              </div>
            </div>
            <div class="product-protection-col d-flex justify-content-between">
                <a href="javascript:void(0)" class="bg-purple"><img src="{{ asset('img/btn-strip.png') }}" alt="..."> Protected</a>

                @if($Product->status == 1)
                <a href="javascript:void(0)" class="bg-green"><img src="{{ asset('img/btn-check.png') }}" alt="..."> Approved</a>
                @endif
                @if($Product->is_feature == 1)
                <a href="javascript:void(0)" class="bg-orange"><img src="{{ asset('img/btn-star.png') }}" alt="..."> Featured</a>
                @else
                <a href="javascript:void(0)"></a>
                @endif

            </div>
            <div class="product-price-col d-block text-center">
                <div class="pro-price">${{ $Product->final_price }}</div>

                @if($Product->is_sold == 1)
                <a href="javascript:void(0)" class="btn btn-black-border disabled">Sold</a>
                @else

                    @if(!empty($logInedUser))

                        @if($logInedUser->id == $Product->user_id)

                        <a href="javascript:void(0)" class="btn btn-black-border disabled">Buy Now</a>

                        @else
                        <a href="javascript:void(0)" class="btn btn-black-border" onclick="DirectCart('{{ $Product->id }}')">Buy Now</a>
                        @endif
                    @else

                    <a href="javascript:void(0)" class="btn btn-black-border" onclick="DirectCart('{{ $Product->id }}')">Buy Now</a>

                    @endif



                @endif

            </div>
            <div class="showaddtoCartmessage"></div>
            <div class="add-cart-btns d-flex justify-content-between">
                @if($Product->is_sold == 1)
                <a href="javascript:void(0)" class="btn blue-btn addcartbtn disabled">Sold</a>
                @else

                    @if(!empty($logInedUser))

                       @if($logInedUser->id == $Product->user_id)

                           <a href="javascript:void(0)" class="btn blue-btn addcartbtn disabled" disabled="disabled">Add to Cart</a>


                       @else

                            @if(isset($hasproduct))
                            @if(in_array($Product->id,$hasproduct))
                            <a href="javascript:void(0)" class="btn bg-green"><img src="{{ asset('img/btn-check.png') }}" alt="..."> Add to Cart</a>

                            @else
                            <a href="javascript:void(0)" class="btn blue-btn addcartbtn" onclick="AddtoCart('{{ $Product->id }}')">Add to Cart</a>
                            <a href="javascript:void(0)" class="btn bg-green afteraddcartbtn" style="display:none"><img src="{{ asset('img/btn-check.png') }}" alt="..."> Add to Cart</a>
                            @endif
                            @endif

                       @endif


                    @else

                       @if(isset($hasproduct))
                        @if(in_array($Product->id,$hasproduct))
                        <a href="javascript:void(0)" class="btn bg-green"><img src="{{ asset('img/btn-check.png') }}" alt="..."> Add to Cart</a>

                        @else
                        <a href="javascript:void(0)" class="btn blue-btn addcartbtn" onclick="AddtoCart('{{ $Product->id }}')">Add to Cart</a>
                        <a href="javascript:void(0)" class="btn bg-green afteraddcartbtn" style="display:none"><img src="{{ asset('img/btn-check.png') }}" alt="..."> Add to Cart</a>
                        @endif
                        @endif


                    @endif


                @endif
                <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimgforaddtocart" style="display:none;">

                @if($Product->is_price_negotiable == 1)
                @if($Product->is_sold == 1)
                <a href="javascript:void(0)" class="btn blue-btn disabled">Make an Offer</a>
                @else
                    
                    @if(!empty($logInedUser))
                        
                        @if($logInedUser->id == $Product->user_id)
                        <a href="javascript:void(0)" class="btn blue-btn disabled">Make an Offer</a>
                        @else
                        <a href="javascript:void(0)" class="btn blue-btn" onclick="MakeofferPopup('{{ $Product->id }}')">Make an Offer</a>
                        @endif
                       
                    @else
                    <a href="{{ asset('/login') }}" class="btn blue-btn">Make an Offer</a>
                    @endif

                @endif
                @endif

            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="send-seller-msg">
            <p>All seller return policies are based on the pre-condition that the device is received as advertised and in
                accordance with Sell Buy Device policies. </p>

                @if(!empty($logInedUser))

                @if($logInedUser->id == $Product->user_id)
                  <a href="{{ asset('/message/'.$Product->id) }}" class="btn blue-btn disabled">SEND MESSAGE TO SELLER</a>
                 @else
                 <a href="{{ asset('/message/'.$Product->id) }}" class="btn blue-btn">SEND MESSAGE TO SELLER</a>
                 @endif
               @else
               <a href="{{ asset('/message/'.$Product->id) }}" class="btn blue-btn">SEND MESSAGE TO SELLER</a>

               @endif
        </div>
    </div>
    <div class="col-12">
        <div class="row product-info">
            <div class="col-12">
                <div class="section-title">
                    <h3>Product Info</h3>
                </div>
            </div>


            <div class="col-lg-2 col-md-4 col-12 ">
                <div class="pro-info-inner d-flex align-items-center">
                    <div class="pro-title">Device:</div>
                    <div class="pro-des">{{ $Product->device_type }}</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-12 ">
                <div class="pro-info-inner d-flex align-items-center">
                    <div class="pro-title">Storage:</div>
                    <div class="pro-des">
                        @if(!empty($Product->storage))
                        @foreach($storages as $val)

                            @if($val['id'] ==  $Product->storage)

                            {{ $val['storage_name'] }}

                            @endif
                           @endforeach
                       @else 
                       {{ 'N/A' }}
                       @endif
                    
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-12 ">
                <div class="pro-info-inner d-flex align-items-center">
                    <div class="pro-title">Colour:</div>
                    <div class="pro-des">
                        @if(!empty($Product->colour))
                        {{ $Product->colour }}
                       @else 
                       {{ 'N/A' }}
                       @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-12 ">
                <div class="pro-info-inner d-flex align-items-center">
                    <div class="pro-title">Carrier:</div>
                    <div class="pro-des"> @foreach($carriers as $val)

                            @if($val['id'] ==  $Product->carrier_id)

                            {{ $val['carrier_name'] }}

                            @endif


                           @endforeach</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-12 ">
                <div class="pro-info-inner d-flex align-items-center margin-bottom0">
                    <div class="pro-title">Price Negotiable:</div>
                    <div class="pro-des">{{ $Product->is_price_negotiable ? __('Yes') : __('No') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="section-title">
            <h3> {{ $Product->product_tag_one.' '.$Product->product_tag_two.' '.$Product->product_tag_three }}</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <p>{{ $Product->item_description }}</p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="section-title">
            <h3>Device satisfies following criteria</h3>
        </div>
        <ul class="device-satisfies">

            @if(isset($Product->broken_device_id))
            @foreach($testyourdevices as $val)

            @if(in_array($val['id'],unserialize($Product->broken_device_id)))

            <li>{{ $val['broken_title'] }} </li>

            @endif

            @endforeach
            @endif

        </ul>
    </div>
</div>
</div>
</div>















      <!-- The Modal -->
      <div class="modal video-popup" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">{{ $Product->item_title }}</h4>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="video-container">
                        {{ Form::open(['url' => 'shareurl']) }}
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Email address</label><br/>
                                  <span style="font-size: 12px;">(You can add multiple email address with comma seperate value)</span>
                                  <input type="text" name="email" class="form-control"   placeholder="Enter Email" required>
                                 <input type="hidden" value="{{ URL::to('product/'.$Product->product_slug) }}" name="producturl" />
                                </div>

                                <div class="form-group">
                                        <label for="exampleInputEmail1">Message</label><br/>

                                        <textarea id="form10" class="md-textarea form-control" rows="3" name="message"></textarea>

                                      </div>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                      <a href="javascript:void(0)" class="btn btn-danger" onclick="CloseEmailPopup()" >Close</a>
                               </form>
                       </div>
            </div>
         </div>
        </div>
      </div>


      <!-- The Make an offer popup Modal -->
      <div class="modal video-popup" id="offerModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Make An Offer</h4>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="showerrormessage" ></div>
                        {{ Form::open(['url' => 'makeoffer','id'=>'offerfrm']) }}
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Your offer($)</label><br/>

                                  <input type="text" name="buyer_offer_price" class="form-control" id='quantity'  onkeyup="CheckNegativeVale()" placeholder="Enter offer price" required>
                                 <input type="hidden" value="{{ $Product->id }}" name="product_id" />
                                 @if(!empty($logInedUser))
                                 <input type="hidden" value="{{ $logInedUser->id }}" name="user_id" />
                                 <input type="hidden" value="{{ $logInedUser->id }}" name="sender_id" />
                                 @endif
                                 <input type="hidden" value="{{ $Product->user_id }}" name="receiver_id" />
                                </div>
  
                                <div class="form-group required">
                                    <label for="messagetextarea11">Message to Seller</label><br/>

                                    <textarea  class="md-textarea form-control" id='messagetextarea' rows="3" maxlength="200" name="message" required></textarea>

                                  </div>


                               <button class="btn btn-primary" title="Submit" type="button" id='submitBtn11'> Submit</button>
                            <a href="javascript:void(0)" class="btn btn-danger closepaymentpopup" onclick="ClosePaymentPopup()" >Close</a>
                               </form>

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




    {{ Html::style('css/flexslider.css') }}

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">

        $(window).on('load', function() {
          $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 153,
            itemMargin: 5,
            asNavFor: '#slider'
          });

          $('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            start: function(slider){
              $('body').removeClass('loading');
            }
          });
        });

 function CheckNegativeVale()
 { 
   var offerval = $('#quantity').val();
   if (offerval === "" || offerval > 0) {
   $('#submitBtn11').prop('disabled', false);
  } else {
    //alert("Enter value should be positive.");
    $("#showerrormessage").html('<p style="color:red">Offer price should be greater than to 0.</p>');
    //$('#submitBtn11').prop('disabled', true);
      setTimeout(function(){
       $("#showerrormessage").html('');
       }, 3000);
  }
 }


   function AddtoCart(id)
   {
      var productid = id;
      $(".showloaderimgforaddtocart").show();

     var alreadycount = $(".product-count").text();


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '{{url('addtocartproduct')}}'+'/'+productid,
        type: 'GET',
        dataType: 'json',
        data: {

            "id": productid // method and token not needed in data
        },
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {

        },

        success: function (json) {


         $(".showloaderimgforaddtocart").hide();
         if(json.status == true)
         {
             if(alreadycount != '')
             {
                var countval = parseInt(alreadycount) + 1;
                $(".product-count").text(countval);

             }else{


                $(".add-cart-beg a").html('<span class="product-count">1</span><i class="fas fa-shopping-cart"></i>');
             }
            $(".addcartbtn").hide();
            $(".afteraddcartbtn").show();
            setTimeout(function(){
                window.location.href = '{{ URL::to('cart/') }}';
             }, 1000);

         }


        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

   }

    function DirectCart(id)
    {
        var productid = id;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url('DirectCartPage')}}'+'/'+productid,
            type: 'GET',
            dataType: 'json',
            data: {

                "id": productid // method and token not needed in data
            },
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {

            },

            success: function (json) {

           if(json.status == true)
             {
              window.location.href = "{{ URL::to('cart/') }}";
             }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }



    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();

      }

    function openEmailPopup()
    {
         $("#myModal").show();
    }

    function CloseEmailPopup()
    {
        $("#myModal").hide();
    }


    function MakeofferPopup()
    {
         $("#offerModal").show();
    }

    function ClosePaymentPopup()
    {
        $("#offerModal").hide();
    }

    $("#submitBtn11").on('click',function(){

             var txt = $('#messagetextarea').val();
             
               var offerval = $('#quantity').val();
                var regex = /^[0-9]+([0-9]{1,2})?$/;
               var SpecailChar = regex.test(offerval);
               
                if (offerval > 0) {
                  if(SpecailChar == false){
                        $("#showerrormessage").html('<p style="color:red">Offer amount should be correct.</p>');
                        //$('#submitBtn11').prop('disabled', true);
                          setTimeout(function(){
                           $("#showerrormessage").html('');
                           }, 3000);
                         return false
                    }else{
                        $('#submitBtn11').prop('disabled', false);
                    }
               } else {
               var len = txt.trim().length;
                 if (len < 1)
                {
                $("#showerrormessage").html('<p style="color:red">Both fields are required.</p>');
                }else{
                    $("#showerrormessage").html('<p style="color:red">Offer price should be greater than to 0.</p>');
                    //$('#submitBtn11').prop('disabled', true);
                      setTimeout(function(){
                       $("#showerrormessage").html('');
                       }, 3000);
                     return false
                 }
               }

               var len = txt.trim().length;

                if (len < 1)
                {
                $("#showerrormessage").html('<p style="color:red">Both fields are required.</p>');
                }else{
                $("#submitBtn11").attr("disabled", true);
                $(".closepaymentpopup").addClass('disabled');
                $("#offerfrm").submit();
                }


    });
    
      $("#quantity").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57)) {
           //display error message
           $("#errmsg").html("Digits Only").show().fadeOut("slow");
                  return false;
       }
       if (e.which == 46) {
         $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
       }
      });

    $(document).ready(function() {
        $(".fancybox").fancybox();
    });



      </script>



    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="{{ asset('js/share.js') }}"></script>






@include('includes.footer')
@endsection









