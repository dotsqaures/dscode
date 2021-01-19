@extends('layouts.admin.master')
@section('title','Order Manager')
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
            Sale List
            <small>Here you can manage Sale</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">
                <i class="fa fa-dashboard"></i>
                Home</a></li>

            <li class="breadcrumb-item active">
                    Sale List
</li>

</ol>
    </section>

    <section class="content" data-table="Orders">


            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('Sale List') }}</span></h3>
                            <div class="box-tools">
                                <!--<a href="{{route('admin.Orders.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add Tagline-->
                                </a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">

                                {{ Form::open(['url' => route('admin.Orders.index'),'method' => 'get']) }}
                                <div class="col-md-12">
                                <div class="row">



									<div class="col-md-2 form-group">
                                        {{ Form::text('start_date',  app('request')->input('start_date'), ['class' => 'form-control','placeholder'=>'Start Date','readonly'=>'readonly','id'=>'datetimepicker1','required'=>true]) }}
                                     </div>

                                 <div class="col-md-2 form-group">
                                   {{ Form::text('end_date',  app('request')->input('end_date'), ['class' => 'form-control','placeholder'=>'End Date','readonly'=>'readonly','id'=>'datetimepicker2','required'=>true]) }}
                                 </div>


                                 <div class="col-md-5 form-group">
                                    {{ Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: User Name']) }}
                                </div>

                                    <div class="col-md-3 form-group">
                                        <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                                        <a href="{{ route('admin.Orders.index') }}" class="btn btn-warning" title="Reset"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
			<div class="tab-pane active">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>


                                        <th scope="col"><a href="javascript:void(0)">Stamp Name</a></th>
                                        <th scope="col"><a href="javascript:void(0)">Price</a></th>
                                         <th scope="col"><a href="javascript:void(0)">Total Stamp</a></th>
                                          <th scope="col"><a href="javascript:void(0)">Remaining Stamp</a></th>
                                        <th scope="col"><a href="javascript:void(0)">User Name</a></th>
                                        <th scope="col"><a href="javascript:void(0)">Transcation id</a></th>
                                        <th scope="col">

                                         <a href="javascript:void(0)">Date</a></th>


                                        <th scope="col" class="actions" width="12%">Action</th>
                                    </tr>
                                </thead>
                                        @if(count($orderData)>0)
                                        <tbody>
                                    @php
                                    $i = (($orderData->currentPage() - 1) * ($orderData->perPage()) + 1)
                                    @endphp
                                    @foreach($orderData as $order)
                                    @php
                                    $userdata = \App\Helpers\BasicHelpers::UserInfo($order->user_id );
                                    $stampdata = \App\Helpers\BasicHelpers::stempinfor($order->charge_id);
                                    $totalRedemStamp = \App\Helpers\BasicHelpers::RedemStampTotal($order->id);
                                    @endphp
                                        <tr class="row-{{ $order->id }}">
                                            <td> {{$i}}. </td>


                                            @if(!empty($stampdata))
                                            <td>{{ $stampdata->title }}</td>
                                            @else
                                            <td>{{ "N/A" }}</td>
                                            @endif


                                            <td>{{ $order->total_amount }}</td>




                                            <td>{{ $stampdata->stemp_no }}</td>




                                            @if(!empty($stampdata))
                                            <td>{{ $stampdata->stemp_no - count($totalRedemStamp)   }}</td>
                                            @else
                                            <td>{{ "N/A" }}</td>
                                            @endif

                                            @if(!empty($userdata))
                                            <td>{{  $userdata->first_name }}</td>
                                            @else
                                            <td>{{ "N/A" }}</td>
                                            @endif

                                            <td>{{ $order->transcation_id }}</td>



                                            <td>{{ date('m/d/Y',strtotime($order->order_date)) }}</td>
                                            <td class="actions">
                                                <div class="form-group">
                                                     {{-- <a href="{{ route('admin.Orders.show',['id' => $order->id]) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a href="{{ route('admin.Order.edit',['id' => $order->id]) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>--}}
                                                    <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete {{ $order->id }}" data-url="{{ route('admin.Orders.destroy', $order->id) }}" data-original-title="Delete"><i class="fa fa-trash"></i></a>

                                                </div>
                                            </td>
                                        </tr>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                    </tbody>
                                    @else
                                    <tfoot>
                                        <tr>
                                            <td colspan='7' align='center'> <strong>Record Not Available</strong> </td>
                                        </tr>
                                    </tfoot>
                                    @endif
                            </table>
			   </div>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $orderData->appends(Request::query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
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

