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
                      <span class="text-uppercase">ORDER ID :</span>{{ $order->custom_order_id }}
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
                                            <div class="deliver-text">Deliver to</div>
                                            @php $Address =   \App\Helpers\BasicHelpers::GetUserDelievryAddress($order->user_id); @endphp

                                            <p>{{ $Address->shiping_name.' '.$Address->shiping_last_name.' '.$Address->shiping_Unit_number.' '.$Address->shiping_Street_number.' '.$Address->shipping_address_one.' '.$Address->shipping_address_two.' '.$Address->shipping_suburb.' '.$Address->shipping_state.' '.$Address->shipping_postcode }} </p> <p style="padding:0px;"> {{ $Address->shipping_mobileno  }} </p>


                                           </div>
                                </div>
                                <div class="col-md-6">

                                        <div class="order-details-inner delivered-address-detail">
                                                <div class="deliver-text">Billing to</div>
                                                <p>{{ $Address->billing_name.' '.$Address->billing_last_name.' '.$Address->billing_Unit_number.' '.$Address->billing_Street_number.' '.$Address->billing_address_one.' '.$Address->billing_address_two.' '.$Address->billing_suburb.' '.$Address->billing_state.' '.$Address->billing_postcode }} </p> <p style="padding:0px;"> {{ $Address->billing_mobileno  }} </p>


                                               </div>
                                    </div>


                    </div>
                <div>
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






@include('includes.footer')
@endsection






