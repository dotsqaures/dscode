@extends('layouts.inner_home')
@section('title','My Revenue')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My<span> Revenue</span></h1>
    </div>
    @include('layouts.admin.flash.alert')



    </div>


    <div class="product-lists mrg-t20">
    <div class="row">



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


            <div class="message-block message-list shad">

            <div class="heading"><h2>My Revenue</h2></div>
            <div class="my-revenu-outer">

                <form role="form" method="post" action="{{ url('my-revenue') }}">
                    @csrf
                    <ul class="my-revenu">
                    <li>
                        <div class="form-group">
                            {{ Form::text('start_date',  app('request')->input('start_date'), ['class' => 'form-control','placeholder'=>'Start Date','id'=>'datetimepicker1','required'=>true,"autocomplete"=>"off"]) }}
                         </div>
                    </li>
                    <li>
                        <div class="form-group">
                            {{ Form::text('end_date',  app('request')->input('end_date'), ['class' => 'form-control','placeholder'=>'End Date','id'=>'datetimepicker2','required'=>true,"autocomplete"=>"off"]) }}
                         </div>
                    </li>
                    <li>
                        <div class="form-group">
                            <button class="btn blue-btn" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                         </div>
                    </li>
                    <li>
                        <div class="form-group">

                            <a href="" class="btn blue-btn">Reset</a>
                         </div>
                    </li>
                    </ul>







                        {{ Form::close() }}
            </div>
            @if(count($orderData)>0)
            <div class="message-tbl">

            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
              <tr>
                <th>S.No</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Revenue</th>

              </tr>

          @php $total_selling = '0'; $admin_total='0'; @endphp
            @foreach($orderData as $order)

                    @if(isset($order->orderDetailsData[0]->product))

                    @foreach($order->orderDetailsData as $prod)
                    @php

                    $total_selling += $prod->Product->final_price;
                    $admin_total += $prod->Product->admin_charge;
                    @endphp

                    @endforeach
                    @endif
            @endforeach

            @php
            if(count($orderData)>0){
              $getChargeAmount = $total_selling - $admin_total;

            $stripeCommission = round($getChargeAmount * 2.9 / 100);

            $totalRevenue = $getChargeAmount - $stripeCommission;

            }else{
                $totalRevenue = 0;
            }
              @endphp

              <tr>
                <td>{{ '1' }}</td>
                <td>{{  date("d/m/Y", strtotime($monthdate)) }}</td>
                <td>{{ date("d/m/Y", strtotime($senddate)) }}</td>
                <td>{{ '$'.$totalRevenue}}</td>



              </tr>



            </table>
           </div>

           @else

           <div class="col-lg-12 col-sm-12 listing-product-col px-0">

                <p>No Revenue listed.</p>
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






<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
<script>

         $(function() {
            $('#datetimepicker1').datepicker({
                 changeMonth: true,
                changeYear: true,
                maxDate: '0'
            });
          });

          $(function() {
            $('#datetimepicker2').datepicker({
                changeMonth: true,
                changeYear: true,
                maxDate: '0' });
          });
</script>
