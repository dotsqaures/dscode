@extends('layouts.inner_home')
@section('title','Order Detail')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>Order  <span>Details</span></h1>

    </div>
    <a class="btn blue-btn back-btn-ht" href="{{ url()->previous() }} ">Back</a>
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

    <div class="col-md-8 product-showcase">
        @if(count($orderData)>0)
        @foreach($orderData as $order)
            <div class="order-section">
              <div class="order-block">
                <div class="top-block d-flex align-items-center flex-wrap justify-content-between">
                <div class="top-block-left">
                      <span class="text-uppercase">ORDER ID:</span>{{ $order->custom_order_id }}
                  </div>
                  <div class="top-block-right">
                      <span class="text-uppercase">Tracking Number :</span>
                      @if(!empty($order->tracking_number))
                      {{ $order->tracking_number }}
                    @else
                      {{ 'N/A' }}
                    @endif
                  </div>
                   <div class="top-block-right">
                     <span class="text-uppercase">status :</span> <span class="bg-pink">
                            @if($order->status == 1)
                            {{ 'Pending' }}
                           @elseif($order->status == 2)
                            {{ 'Shipped' }}
                           @elseif($order->status == 3)
                           {{ 'Delivered' }}
                          @endif
                     </span>
                   </div>
                </div>
                <div class="top-block d-flex align-items-center flex-wrap justify-content-between">
                  <div class="top-block-left">
                      <span class="text-uppercase">Order Date :</span>{{ date('d/m/Y',strtotime($order->order_date)) }}
                  </div>
                  <div class="top-block-right">
                      <span class="text-uppercase">Grand Total :</span>${{ $order->total_amount }}<br/>
                      @if(count($order->OrderReturnData)>0)
                    @foreach($order->OrderReturnData as $val)
                    @if($val->status == 3)
                    <span class="text-uppercase" style="color:red">item returned :</span> ${{ $val->amount }}
                    @endif
                    @endforeach
                    @endif
                  </div>
                </div>

                <div class="ord-detail-block">
                        @foreach($order->OrderDetailsData as $value)

                  <div class="one-ord-block d-flex align-items-center">
                    <div class="ord-img">
                            @if(!empty($value->product->mainphoto))
                        <img src="{{ asset(Storage::url($value->product->mainphoto)) }}" alt=""/>
                          @else
                          <img src="{{ asset('img/NoPhone_grande.png') }}" />
                          @endif
                    </div>
                    <div class="ord-sumry">
                      <h3><a href="{{ url('product/'.$value->product->product_slug )}}">{{ $value->product->item_title }}</a></h3>
                      <div class="top-block-right">
                          @php
                           if(!empty($value->product->imei_code))
                            {
                               $code = $value->product->imei_code;
                            }else{
                                $code = $value->product->serial_number;
                            }
                            @endphp
                        <span class="text-uppercase">Product Id :</span>{{ $code }}
                        @if(count($order->OrderReturnData)>0)
                        @foreach($order->OrderReturnData as $val)

                        @if($val->status == 3)
                        @if(in_array($value->id,unserialize($val->orderdetail_id)))
                        <span class="text-uppercase" style="color:red">(item returned)</span>
                        @endif
                        @endif
                        @endforeach
                        @endif
                  	  </div>
                    </div>
                  </div>
                  @endforeach

                </div>


             <div class="delivered-address">
                 <div class="container">
                    <div class="row">
                            <div class="col-md-6">

                                    <div class="order-details-inner delivered-address-detail">
                                            <div class="deliver-text">Deliver To</div>
                                            @php $Address =   \App\Helpers\BasicHelpers::GetUserDelievryAddress($order->user_id); @endphp

                                            <p>{{ $Address->shiping_name.' '.$Address->shiping_last_name.' '.$Address->shiping_Unit_number.' '.$Address->shiping_Street_number.' '.$Address->shipping_address_one.' '.$Address->shipping_address_two.' '.$Address->shipping_suburb.' '.$Address->shipping_state.' '.$Address->shipping_postcode }} </p> <p style="padding:0px;"> {{ $Address->shipping_mobileno  }} </p>


                                           </div>
                                </div>
                                <div class="col-md-6">

                                        <div class="order-details-inner delivered-address-detail">
                                                <div class="deliver-text">Billing To</div>
                                                <p>{{ $Address->billing_name.' '.$Address->billing_last_name.' '.$Address->billing_Unit_number.' '.$Address->billing_Street_number.' '.$Address->billing_address_one.' '.$Address->billing_address_two.' '.$Address->billing_suburb.' '.$Address->billing_state.' '.$Address->billing_postcode }} </p> <p style="padding:0px;"> {{ $Address->billing_mobileno  }} </p>


                                               </div>
                                    </div>


                    </div>
                <div>
             </div>
              
             @if($order->status == 3)        
             @if(empty($order->rat) && $order->user_id == $logInedUser->id)

               <a class="btn blue-btn back-btn-ht" href="javascript:void(0)" onclick="openrattingfrm('{{ $order->id }}')">Rate & Review</a>

             @endif
             @endif



             @if(!empty($order->rat) && $order->user_id != $logInedUser->id)

      <h3>Customer Rating and Review</h3>

      <div class="rat-sec">
        <label>Rating</label>
        <div class="rating-str">

            <input id="rat" name="ratss" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $order->rat }}" data-size="xs" required>

        </div>
      </div>
      <div class="text-art">
        <label>Description</label>
        @foreach($order->rattingdata as $val)
        <textarea class="form-control" >{{ $val->review }}</textarea>
        @endforeach
      </div>


      @endif
                     
                     
                     

              </div>
            </div>
        </div>

        @endforeach
        @else

        <div class="order-block">
                <div class="top-block d-flex align-items-center flex-wrap justify-content-between">
                  <div class="top-block-left">
                      <span class="text-uppercase">No order(s) found.</span>
                  </div>

                </div>
            </div>
            @endif

           </div>


    </div>
 </div>
 </div>
</div>
</div>
</div>


<!-- The Modal -->
<div class="modal video-popup order-update-popup" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Rate and Review</h4>

      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <div class="video-container" style="padding-bottom: 10%">
                  {{ Form::open(['url' => 'ratting','method'=>'post']) }}
                          <div class="form-group tracknotexits">
                            <label for="exampleInputEmail1">Rating</label><br/>


                            <input id="rat" name="rat" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="" data-size="xs" required>


                          </div>

                          <div class="form-group">
                     <label for="exampleInputEmail1">Review</label><br/>
                     <textarea  class="md-textarea form-control" id='messagetextarea' rows="3" maxlength="200" name="review" required></textarea>

                        </div>

                          <input type="hidden" name="order_id" value="" class="orderid"/>

                         <button type="submit" class="btn btn-primary">Submit</button>
                         <a href="javascript:void(0)" class="btn btn-danger" onclick="CloseEmailPopup()" >Close</a>


                        </form>


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

@include('includes.footer')
@endsection



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>

   function openrattingfrm(id)
    {
         $("#myModal").show();
         $(".orderid").val(id);

    }

    function CloseEmailPopup()
    {
        $("#myModal").hide();
    }




</script>





