@extends('layouts.admin.master')
@section('title','Payment Manager')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->



<style>
    .ui-datepicker-prev {cursor:pointer}
    .ui-datepicker-next {cursor:pointer}
    #ui-datepicker-div{
        background: rgba(255,255,255,0.9);
      padding: 10px;
    border: 1px solid rgba(188, 186, 186, 0.5);
     box-shadow: 1px 4px 5px rgba(202, 201, 201, 0.5);
    }
    .ui-datepicker-calendar tr th { padding: 5px;}
    .ui-datepicker-header{position: relative;}
   .ui-datepicker-next{ right: 0; position: absolute;}
</style>



    <section class="content-header">
        <h1>
            Payment List
            <small>Here you can manage Payments</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="https://webappdeveloment.24livehost.com/public/admin/dashboard">
                <i class="fa fa-dashboard"></i>
                Home</a></li>

            <li class="breadcrumb-item active">
                    Payment List
</li>

</ol>
    </section>

    <section class="content" data-table="Orders">



            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('Payment List') }}</span></h3>
                            <div class="box-tools">
                                <!--<a href="{{route('admin.Orders.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add Tagline-->
                                </a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">

                                {{ Form::open(['url' => route('admin.Payments.index'),'method' => 'get']) }}
                                <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-3 form-group">
                                      {{ Form::select('status', ['' => 'Select Revenue Type',1 => 'Sales', 2 => 'Featured',3=>'All'], app('request')->query('status'), ['class' => 'form-control']) }}
                                   </div>

                                   <div class="col-md-2 form-group">
                                        {{ Form::text('start_date',  app('request')->input('start_date'), ['class' => 'form-control','placeholder'=>'Start Date','id'=>'datetimepicker1','required'=>true]) }}
                                     </div>

                                 <div class="col-md-2 form-group">
                                   {{ Form::text('end_date',  app('request')->input('end_date'), ['class' => 'form-control','placeholder'=>'End Date','id'=>'datetimepicker2','required'=>true]) }}
                                 </div>



                                    <div class="col-md-3 form-group">
                                        <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                                        <a href="{{ route('admin.Payments.index') }}" class="btn btn-warning" title="Reset"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}

                        <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th class="hd">#</th>



                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Total revenue</th>
                                        @if(app('request')->input('status') != 2)
                                        <th scope="col">Total refunded</th>
                                        @endif
                                    <th scope="col">Stripe Fee</th>
                                    @if(app('request')->input('status') == 3)
                                            <th scope="col">Admin Commission</th>
                                    @else
                                            <th scope="col">Admin Commission</th>
                                    @endif
                                    @if(app('request')->input('status') != 2)
                                     @if(app('request')->input('status') && app('request')->input('status') == 1)
                                            <th scope="col">Seller Commission</th>
                                        @else
                                        <th scope="col">Seller Commission</th>
				      @endif
                                      @endif
                                    </tr>
                                </thead>
                                        @if((count($orderData)>0) && (count($featureData)>0))
                                        
                                        <tbody>
                                                @php $total = '0'; $admin_charges=0;  @endphp
                                                @foreach($orderData as $order)

                                                @php $total +=   $order->total_amount;  @endphp

                                                    @if(isset($order->orderDetailsData[0]->product))

                                                        @foreach($order->orderDetailsData as $prod)
                                                        @php
                                                        if($prod->is_return == 0){
                                                        $admin_charges +=   $prod->Product->admin_charge;  
                                                        }
                                                      @endphp
                                                        @endforeach
                                                    @endif

                                                @endforeach

                                               @php 
                                               
                                               $totalfeatured = '0'; @endphp
                                               @foreach($featureData as $order)

                                               @php   $totalfeatured +=   $order->feature_price;  @endphp
                                               @endforeach


                                               @php $totalreturnval = '0';  @endphp
                                               @if(!empty($totalreturn))

                                               @foreach($totalreturn as $return)

                                               @php  $totalreturnval +=   $return['amount'];  @endphp
                                               @endforeach
                                               @endif


                                               @php
                                            
                                           $grand_total1 = $total + $totalfeatured;
                                           $grand_total2 = $grand_total1 - $totalreturnval;
                                           $grand_total = $grand_total2;
                                           $stpie_fee =   $grand_total-$admin_charges;
                                           $stripe_commistion = $stpie_fee * 2.9/100;
                                           $final_amt = $grand_total-($stripe_commistion + $admin_charges);
                                           $sellercomission = $grand_total-$stripe_commistion;

                                                    @endphp
                                                   <tr class="row-1">

                                                <td>1. </td>
                                                <td>
                                                    @if(!empty($startdate))
                                                    {{ date("d/m/Y", strtotime($startdate) ) }}
                                                    @else
                                                    {{ 'N/A' }}
                                                    @endif
                                                   </td>

                                                   <td>
                                                        @if(!empty($senddate))
                                                        {{ date("d/m/Y", strtotime($senddate) ) }}
                                                        @else
                                                        {{ 'N/A' }}
                                                        @endif
                                                       </td>

                                                <td>${{  $total + $totalfeatured }}</td>
                                                <td>${{ $totalreturnval  }}</td>
                                                <td>${{  number_format((float)($stripe_commistion), 2, '.', '')  }}</td>
                                                <td>${{ number_format((float)($admin_charges), 2, '.', '')  }}</td>
                                                <td>${{ number_format((float)($final_amt), 2, '.', '')  }}</td>



                                                  </tr>
                                                   </tbody>

                                        @elseif(count($orderData)>0)
                                        
                                        <tbody>
                                          @php $total = '0';$admin_charges = '0'; @endphp
                                            @foreach($orderData as $order)

                                            @php $total +=   $order->total_amount;  @endphp

                                                @if(isset($order->orderDetailsData[0]->product))

                                                    @foreach($order->orderDetailsData as $prod)
                                                    @php
                                                    
                                                    if($prod->is_return == 0){
                                                    $admin_charges +=   $prod->Product->admin_charge;  
                                                    }
                                                    @endphp
                                                    @endforeach
                                                @endif

                                            @endforeach

                                            @php $totalreturnval = '0';  @endphp
                                               @if(!empty($totalreturn))

                                               @foreach($totalreturn as $return)

                                               @php  $totalreturnval +=   $return['amount'];  @endphp
                                               @endforeach
                                               @endif

				   @php 
                                    
                                 $grand_total1 = $total;
                                 
                                   $grand_total = $grand_total1 - $totalreturnval;
                                    //$grand_total = $grand_total1;
                                    $stpie_fee =   $grand_total-$admin_charges;
                                    $stripe_commistion = $stpie_fee * 2.9/100;
                                    $final_amt = $grand_total-($stripe_commistion + $admin_charges);
                                    $sellercomission = $grand_total-$stripe_commistion;
                                           
                                   
                                 
				    @endphp

                                        <tr class="row-1">

                                                <td>1. </td>

                                          <td>
                                                    @if(!empty($startdate))
                                                    {{ date("d/m/Y", strtotime($startdate) ) }}
                                                    @else
                                                    {{ 'N/A' }}
                                                    @endif
                                                   </td>

                                                   <td>
                                                        @if(!empty($senddate))
                                                        {{ date("d/m/Y", strtotime($senddate) ) }}
                                                        @else
                                                        {{ 'N/A' }}
                                                        @endif
                                                       </td>
                                            <td>${{  number_format((float)$total, 2, '.', '') }}</td>
                                            <td>${{  $totalreturnval }}</td>
                                            <td>${{  number_format((float)($stripe_commistion), 2, '.', '')  }}</td>
                                            <td>${{ number_format((float)($admin_charges), 2, '.', '')  }}</td>
                                             
                                            <td>${{  number_format((float)($final_amt), 2, '.', '') }}</td>
                                            

                                       </tr>
                                        </tbody>

                                    @elseif(count($featureData)>0)

                                    <tbody>
                                            @php $total = '0'; @endphp
                                           @foreach($featureData as $order)

                                           @php   $total +=   $order->feature_price;  @endphp
                                           @endforeach
                                           <tr class="row-1">

                                                <td>1. </td>
<td>
                                                    @if(!empty($startdate))
                                                    {{ date("d/m/Y", strtotime($startdate) ) }}
                                                    @else
                                                    {{ 'N/A' }}
                                                    @endif
                                                   </td>

                                                   <td>
                                                        @if(!empty($senddate))
                                                        {{ date("d/m/Y", strtotime($senddate) ) }}
                                                        @else
                                                        {{ 'N/A' }}
                                                        @endif
                                                       </td>
                                                    <td>${{  $total }}</td>
                                                    @if(app('request')->input('status') != 2)
                                                      <td>${{  "-" }}</td>
                                                       @endif
                                                     
                                                    <td>${{  $total*(2.9/100) }}</td>
                                                    <td>${{  $total - ($total*(2.9/100)) }}</td>


                                              </tr>
                                               </tbody>


                                    @else

                                    <tfoot>
                                            <tr>
                                                <td colspan='7' align='center'> <strong>Record(s) not available.</strong> </td>
                                            </tr>
                                        </tfoot>

                                    @endif
                            </table>

                        </div>
                        <div class="box-footer clearfix">

                        </div>
                    </div>
                </div>



            </div>

            <canvas id="buyers" width="600" height="400"></canvas>




        </section>







@stop








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










