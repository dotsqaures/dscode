@extends('layouts.inner_home')
@section('title','My Purchase Order')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My  <span>Purchase Orders</span></h1>
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

    <div class="col-md-8 product-showcase">
            @include('layouts.admin.flash.alert')
    <div class="order-section">

        @if(count($orderData)>0)

        @foreach($orderData as $order)

      <div class="order-block">
        <div class="top-block d-flex align-items-center flex-wrap justify-content-between">
          <div class="top-block-left">
              <span class="text-uppercase">Order Date :</span>{{ date('d/m/Y',strtotime($order->order_date)) }}
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
        <div class="order-details-block d-flex flex-wrap">
          <div class="order-details-left">
            <div class="order-details-inner top">
              <div class="top-block-left">
                 <span class="text-uppercase">Order ID:</span>{{ $order->custom_order_id }}
              </div>
              @php $total = 0; @endphp
              @foreach($order->OrderDetailsData as $value)
              <div class="d-flex flex-wrap price-row">

                @if(!empty($value->product))
                <span>1 x ${{ $value->product->final_price }}</span> <p><a href="{{ url('product/'.$value->product->product_slug )}}">{{ $value->product->item_title }}</a></p>
               @else
                <span></span>
               @endif
               @php $total += $value->product->final_price; @endphp
              </div>
            @endforeach

            </div>
            <div class="d-flex flex-wrap justify-content-between order-details-inner bottom">
              <div class="top-block-left">
                 <span class="text-uppercase">Order total:</span> ${{ $order->total_amount }}
                 @if($total == $order->total_amount)
                 {{ ' ' }}
                 @else
                 {{ '(Offer Price)' }}
                 @endif
                 
                 <br/>
                
                 @if(count($order->OrderReturnData)>0)
                 @foreach($order->OrderReturnData as $val)
                 @if($val->status == 3)
                 <span class="text-uppercase" style="color:red">item returned :</span> ${{ $val->amount }}
                 @endif
                 @endforeach
                 @endif
              </div>
              <div class="tracking-block">
                <span>Tracking Number :</span>
                @if(!empty($order->tracking_number))
                {{ $order->tracking_number }}
              @else
                {{ 'N/A' }}
              @endif
              </div>

            </div>

          </div>
          <div class="order-details-right">
             <div class="order-details-inner">
              <div class="deliver-text">Deliver To</div>
              <p>{{ $Address['shiping_name'].' '.$Address['shiping_last_name'].' '.$Address['shiping_Unit_number'].' '.$Address['shiping_Street_number'].' '.$Address['shipping_address_one'].' '.$Address['shipping_address_two'].' '.$Address['shipping_suburb'].' '.$Address['shipping_state'].' '.$Address['shipping_postcode'] }} </p> <p style="padding:0px;"> {{ $Address['shipping_mobileno']  }} </p>
              <div class="orderupdate">
              <a class="view-detail" href="{{ url('/orderDetail/'.$order->id) }}">View Details</a>

              @if($order->status == 3)
               @php
               $currentdate = date('Y-m-d H:i:s');
               $orderStatusDate = date('Y-m-d',strtotime($order->order_status_date));
               $newDate = date("Y-m-d",strtotime($orderStatusDate."+7 day"));
               @endphp
               @if($order->status == 3 && $currentdate < $newDate)
               @if(count($order->OrderReturnData)>0)
                        @foreach($order->OrderReturnData as $val)
                        @if($val->status == 2)
                        <a class="view-detail paymentrequest btn blue-btn disabled" href="javascript:void(0)" >Request cancelled</a>
                        @elseif($val->status == 1)
                        <a class="view-detail paymentrequest btn blue-btn disabled" href="javascript:void(0)" >Request Accepted</a>
                        @elseif($val->status == 3)
                        <a class="view-detail paymentrequest btn blue-btn disabled" href="javascript:void(0)" >Request Closed</a>
                        @else
                        <a class="view-detail paymentrequest" href="javascript:void(0)" onclick="returnOrderStatus({{ $order->id }})">Return Order</a>
                        @endif
                        @endforeach

              @else
               <a class="view-detail paymentrequest" href="javascript:void(0)" onclick="returnOrderStatus({{ $order->id }})">Return Order</a>
               @endif

              @endif
              @endif
              </div>

             </div>
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
</div>


<!-- The Modal -->
<div class="modal video-popup return-order-popup" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Return Order</h4>

      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <div class="video-container return-container" >



          </div>
      </div>



    </div>
  </div>
</div>


@include('includes.footer')
@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>

   function returnOrderStatus(id)
    {
        var orderid = id;
         $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url: '{{url('returnorder')}}',
              type: 'GET',
              dataType: 'HTML',
              data:{"id": orderid},

              beforeSend: function (xhr) {

              },
             success: function (json) {

                $("#myModal").show();
               $('body').addClass('bg-blurs');
               $(".video-container").html(json);


            },
            error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
   });

    }

    function CloseEmailPopup()
    {
        $("#myModal").hide();
    }

    $(function() {
        /*($('.trackingnumber').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });*/
    });


</script>
