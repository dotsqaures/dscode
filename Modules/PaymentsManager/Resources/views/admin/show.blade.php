@extends('layouts.admin.master')
@section('title','Order Detail')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Order Details
        <small>Here you can view order details</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.Orders.index'],['label' => 'View Order Detail']]]) }}
</section>

<section class="content" data-table="emailHooks">
        @foreach($orderData as $order)
    <div class="box">
        <div class="box-header"><h3 class="box-title">ORDER ID : {{ $order->custom_order_id }}</h3>
            {{-- <a href="{{route('admin.pages.index')}}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a> --}}
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                    <tr>
                            <th scope="row">{{ __('Transaction Id') }}</th>
                            <td>{{ $order->transcation_id }}</td>
                        </tr>

                <tr>
                    <th scope="row">{{ __('Tracking Number') }}</th>
                    <td> @if(!empty($order->tracking_number))
                            {{ $order->tracking_number }}
                          @else
                            {{ 'NA' }}
                          @endif</td>
                </tr>


                <tr>
                    <th scope="row">{{ __('Order Date') }}</th>
                    <td>{{ date('d/m/Y',strtotime($order->order_date)) }}</td>
                </tr>

                <tr>
                    <th scope="row">{{ __('Grand Total') }}</th>
                    <td>${{ $order->total_amount  }}</td>
                </tr>


                <tr>
                    <th scope="row">{{ __('Status') }}</th>
                    <td> @if($order->status == 1)
                            {{ 'Pending' }}
                           @elseif($order->status == 2)
                            {{ 'Shipped' }}
                           @elseif($order->status == 3)
                           {{ 'Delivered' }}
                          @endif
                        </td>
                </tr>
            </table>

    <div>
     <h4>Customer Info</h4>

     @php
     $Address = \App\Helpers\BasicHelpers::GetUserDelievryAddress($order->user_id);
     $userdata = \App\Helpers\BasicHelpers::UserInfo($order->user_id);
     @endphp
     <table class="table table-hover table-striped">
                 <tr>
                    <th scope="row">{{ __('Name') }}</th>
                    <td>{{ $userdata->first_name }}</td>
                </tr>

                    <tr>
                    <th scope="row">{{ __('Email') }}</th>
                    <td>{{ $userdata->email }}</td>
                    </tr>

                    <tr>
                    <th scope="row">{{ __('Mobile No') }}</th>
                    <td>{{ $userdata->mobileno }}</td>
                    </tr>

                    <tr>
                    <th scope="row">{{ __('Delivery Address') }}</th>
                    <td>{{ $Address->shiping_name.' '.$Address->shiping_last_name.' '.$Address->shiping_Unit_number.' '.$Address->shiping_Street_number.' '.$Address->shipping_address_one.' '.$Address->shipping_address_two.' '.$Address->shipping_suburb.' '.$Address->shipping_state.' '.$Address->shipping_postcode }}</td>
                    </tr>

                    <tr>
                            <th scope="row">{{ __('Billing Address') }}</th>
                            <td>{{ $Address->billing_name.' '.$Address->billing_last_name.' '.$Address->billing_Unit_number.' '.$Address->billing_Street_number.' '.$Address->billing_address_one.' '.$Address->billing_address_two.' '.$Address->billing_suburb.' '.$Address->billing_state.' '.$Address->billing_postcode }}</td>
                            </tr>



     </table>

    </div>


    <h4>Product Info</h4>
            <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Final Price</th>
                        <th scope="col">Image</th>
                      </tr>
                    </thead>
                    <tbody>

                  @foreach($order->OrderDetailsData as $value)
                      <tr>
                        <th scope="row">1</th>
                        <td>{{ $value->product->custom_product_id }}</td>
                        <td>{{ $value->product->item_title }}</td>
                        <td>${{ $value->product->final_price }}</td>
                        <td>
                           @if(!empty($value->product->mainphoto))
                           <img src="{{ asset(Storage::url($value->product->mainphoto)) }}"  style="width:150px;height:100px;"/>
                            @else
                            <img src="{{ asset('img/NoPhone_grande.png') }}" style="width:150px;height:100px;"/>
                            @endif
                                </td>
                      </tr>

                      @endforeach

                    </tbody>
                  </table>

        </div>
        <div class="box-footer">
                <a href="{{route('admin.Orders.index')}}" class="btn btn-default pull-left" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
    </div>
    @endforeach

</section>

@endsection
