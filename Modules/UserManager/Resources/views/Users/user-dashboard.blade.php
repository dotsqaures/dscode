@extends('layouts.inner_home')
@section('title','User Dashboard')
@section('content')

@php
$login = Auth::user();




@endphp


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>Dashboard <span></span></h1>
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

    <div class="col-md-8">
            <div class="row">

                <div class="col-md-4">
                    <a href="{{ url('/profile')}}" class="dash-hmt-block">
                        <i class="hmt-icon"><img class="svg-img" src="{{ asset('img/user1.svg') }}" alt="" width='60' height='60'/></i>
                        <p>My Profile</p>
                    </a>
                    </div>

                  <div class="col-md-4">
                    <a href="{{ url('/change-password')}}" class="dash-hmt-block">
                        <i class="hmt-icon"><img src="{{ asset('img/lock-11.svg') }}" alt="" width='60' height='60'/></i>
                        <p>Change Password</p>
                    </a>
                    </div>

              <div class="col-md-4">
                <a href="{{ url('/myOrder')}}" class="dash-hmt-block">
                  <span class="num-top">{{ count($PurchaseOrder)}}</span>
                  <i class="hmt-icon"><img src="{{ asset('img/purchase1.svg') }}" alt="" width='60' height='60'/></i>
                  <p>My Purchases</p>
                </a>
              </div>

<!--              <div class="col-md-4">
                    <a href="{{ url('/mySellingOrder')}}" class="dash-hmt-block">
                      <span class="num-top">{{ count($SellOrder) }}</span>
                      <i class="hmt-icon"><img src="{{ asset('img/dashboard-icon4.png') }}" alt=""/></i>
                      <p>Total Selling Orders</p>
                    </a>
                  </div>-->

                  <div class="col-md-4">
                        <a href="{{ url('/dashboard')}}" class="dash-hmt-block">
                          <span class="num-top">{{ count($TotalAddedProduct)}}</span>
                          <i class="hmt-icon"><img src="{{ asset('img/list-11.svg') }}" alt="" width='60' height='60'/></i>
                          <p>My Listings</p>
                        </a>
                      </div>

              <div class="col-md-4">
                <a href="{{ url('/myInterest')}}" class="dash-hmt-block">
                  <span class="num-top">{{ count($Mywatchlist) }}</span>
                  <i class="hmt-icon"><img src="{{ asset('img/view-dashbaord.svg') }}" alt="" width='60' height='60'/></i>
                  <p>Watch List</p>
                </a>
              </div>

              @php
              if(count($receivedpayment)>0){
              $total_selling = '0'; $admin_total='0'; @endphp
              @foreach($receivedpayment as $order)

                    @if(isset($order->orderDetailsData[0]->product))

                    @foreach($order->orderDetailsData as $prod)
                    @php

                    $total_selling += $prod->Product->final_price;
                    $admin_total += $prod->Product->admin_charge;
                    @endphp

                    @endforeach
                    @endif
             @endforeach
            
             @php } @endphp
            <?php
            
            if(count($receivedpayment)>0){
            
            $getChargeAmount = $total_selling - $admin_total;

            $stripeCommission = round($getChargeAmount * 2.9 / 100);
            
            $totalRevenue = $getChargeAmount - $stripeCommission;
                                        
             
            }else{
                $totalRevenue = 0;
            }
              ?>


                  <div class="col-md-4">
                    <a href="{{ url('/my-revenue')}}" class="dash-hmt-block">
                      <span class="num-top">{{ $totalRevenue }}<small>$</small></span>
                      <i class="hmt-icon"><img src="{{ asset('img/revenue-11.svg') }}" alt="" width='60' height='60'/ ></i>
                      <p>Total Revenue</p>
                    </a>
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


