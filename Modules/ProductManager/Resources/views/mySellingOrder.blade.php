@extends('layouts.inner_home')
@section('title','My Selling Order')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My  <span>Selling Orders</span></h1>
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

    <div class="col-md-8 product-showcase">
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
                   @else($order->status == 3)
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

            @if(!empty($order->tracking_number))
                 @php $tacking = $order->tracking_number;  @endphp
                @else
                @php $tacking = '123'; @endphp
                @endif

          </div>
          <div class="order-details-right">
             <div class="order-details-inner">
              <div class="deliver-text">Deliver To</div>
              @php $Address =   \App\Helpers\BasicHelpers::GetUserDelievryAddress($order->user_id); @endphp

              <p>{{ $Address->shiping_name.' '.$Address->shiping_last_name.' '.$Address->shiping_Unit_number.' '.$Address->shiping_Street_number.' '.$Address->shipping_address_one.' '.$Address->shipping_address_two.' '.$Address->shipping_suburb.' '.$Address->shipping_state.' '.$Address->shipping_postcode }} </p> <p style="padding:0px;"> {{ $Address->shipping_mobileno  }} </p>
             <div class="orderupdate">
              <a class="view-detail" href="{{ url('/SellerOrderDetail/'.$order->id) }}">View Details</a>
              @if($order->status == 3)
              <a class="view-detail btn blue-btn disabled" href="javascript:void(0)" >Order Delivered</a>
              @else
              <a class="view-detail" href="javascript:void(0)" onclick="updateOrderStatus('{{ $order->id }}', '{{ $tacking }}')">Order Update</a>
              @endif
             </dvi>

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
                  <span class="text-uppercase">No order(s) found</span>
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
<div class="modal video-popup order-update-popup" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Order Status</h4>

      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <div class="video-container" style="padding-bottom: 10%">
                  {{ Form::open(['url' => 'updateorderstatus','method'=>'post']) }}
                          <div class="form-group tracknotexits">
                            <label for="exampleInputEmail1">Tracking Number</label><br/>

                            <input type="text" name="trackingnumber" class="form-control trackingnumber"   placeholder="Enter tracking number" maxlength="20" required>



                          </div>

                          <div class="form-group trackexits" style="display:none;">
                                <label for="exampleInputEmail1">Tracking Number</label><br/>
                     <input type="text" name="trackingnumber" class="form-control trackingnumberexits"   placeholder="Enter tracking number" disabled='disabled' readonly>

                              </div>

                          <input type="hidden" name="order_id" value="" class="orderid"/>

                            <div class="form-group">
                                <label class="control-label" for="company">Order Status</label>
                                <div class="">
                                  <select id="status" class="form-control" name="status">
                                    <option value="1">Pending</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Delivered</option>
                                  </select>
                                </div>
                              </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="javascript:void(0)" class="btn btn-danger" onclick="CloseEmailPopup()" >Close</a>


                        </form>


          </div>
      </div>



    </div>
  </div>
</div>




@include('includes.footer')
@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>

   function updateOrderStatus(id,trackingnumber)
    {
         $("#myModal").show();
         $(".orderid").val(id);
         var tacknumber =  trackingnumber;

         if(tacknumber == '123')
         {
           $(".tracknotexits").show();
           $(".trackexits").hide();
         }else{
            $(".trackexits").show();
            $(".tracknotexits").hide();
            $(".trackingnumber").prop('disabled', true);
            $('.trackingnumberexits').removeAttr("disabled");
            $(".trackingnumberexits").val(tacknumber);
         }
    }

    function CloseEmailPopup()
    {
        $("#myModal").hide();
    }

    $(function() {
        $('.trackingnumber').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });


</script>


