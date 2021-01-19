@extends('layouts.inner_home')
@section('title','Thankyou')
@section('content')


<div class="middle-wrapper">
    <div class="container">
      <div class="thank-you-page">
        <div class="cart-dtl-box shad">
          <img src="{{ asset('img/thanku.png') }}" alt=""/>

          <span>Hi {{ isset($logInedUser) ? $logInedUser->first_name.' '.$logInedUser->last_name : ' ' }},</span>
          <h2>Your order is confirmed and your order ID is <strong>{{ $orderid }}</strong></h2>
          <p>We have sent you an order confirmation email to your supplied email address.</p>
          <a href="{{ url('/myOrder') }}" class="btn-custom">Check status</a>
        </div>
      </div>
    </div>
  </div>




@include('includes.footer')
@endsection




