<?php $__env->startSection('title','Stamp Histroy'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
        Total Redeem Stamp : <?php echo e(count($totalredem)); ?>


        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin/dashboard')); ?>">
                <i class="fa fa-dashboard"></i>
                Home</a></li>

            <li class="breadcrumb-item active">
                histroy List
</li>

</ol>
    </section>

    <section class="content" data-table="Orders">


            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase"><?php echo e(__('Stamp Histroy List')); ?></span></h3>
                            <div class="box-tools">
                                <!--<a href="<?php echo e(route('admin.Orders.create')); ?>" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add Tagline-->
                                </a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">

                            <?php echo e(Form::open(['url' => route('admin.Orders.histroy'),'method' => 'get'])); ?>

                            <div class="col-md-12">
                            <div class="row">



                                <div class="col-md-2 form-group">
                                    <?php echo e(Form::text('start_date',  app('request')->input('start_date'), ['class' => 'form-control','placeholder'=>'Start Date','readonly'=>'readonly','id'=>'datetimepicker1','required'=>true])); ?>

                                 </div>



                             <div class="col-md-2 form-group">
                               <?php echo e(Form::text('end_date',  app('request')->input('end_date'), ['class' => 'form-control','placeholder'=>'End Date','readonly'=>'readonly','id'=>'datetimepicker2','required'=>true])); ?>

                             </div>

                             <div class="col-md-5 form-group">
                                <?php echo e(Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: Employee Code'])); ?>

                            </div>

                                <div class="col-md-3 form-group">
                                    <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                                    <a href="<?php echo e(route('admin.Orders.histroy')); ?>" class="btn btn-warning" title="Reset"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                    <?php echo e(Form::close()); ?>


			<div class="tab-pane active">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th scope="col"><a href="javascript:void(0)">User Name</a></th>
                                        <th scope="col"><a href="javascript:void(0)">Stamp Name</a></th>
                                        <th scope="col"><a href="javascript:void(0)">Cafe</a></th>
                                        <th scope="col"><a href="javascript:void(0)">Redeem Stamp</a></th>
                                       <th scope="col"><a href="javascript:void(0)">Redeem Date</a></th>


                                        <th scope="col">




                                    </tr>
                                </thead>
                                        <?php if(count($orderData)>0): ?>
                                        <tbody>
                                    <?php
                                    $i = (($orderData->currentPage() - 1) * ($orderData->perPage()) + 1)
                                    ?>
                                    <?php $__currentLoopData = $orderData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $userdata = \App\Helpers\BasicHelpers::UserInfo($order->user_id);
                                    $EmployeRestatent = \App\Helpers\BasicHelpers::Restaurentname($order->redeem_code);
                                    $stampdata = \App\Helpers\BasicHelpers::stempinfor($order->stamp_id);
                                    $totalredem = \App\Helpers\BasicHelpers::orderredem($order->stamp_id,$order->order_id);
                                    ?>
                                        <tr class="row-<?php echo e($order->id); ?>">
                                            <td> <?php echo e($i); ?>. </td>

                                            <?php if(!empty($userdata)): ?>
                                            <td><?php echo e($userdata->first_name); ?></td>
                                            <?php else: ?>
                                            <td><?php echo e("N/A"); ?></td>
                                            <?php endif; ?>

                                            <?php if(!empty($stampdata)): ?>
                                            <td><?php echo e($stampdata->title); ?></td>
                                            <?php else: ?>
                                            <td><?php echo e("N/A"); ?></td>
                                            <?php endif; ?>

                                            <?php if(!empty($EmployeRestatent)): ?>
                                            <td><?php echo e($EmployeRestatent->first_name." - ".$EmployeRestatent->restuarents_id); ?></td>
                                            <?php else: ?>
                                            <td><?php echo e("N/A"); ?></td>
                                            <?php endif; ?>

                                            <td>1</td>
                                            <td><?php echo e(date('d-m-Y h:i:s a', strtotime($order->created_at))); ?></td>






                                        </tr>
                                    <?php
                                        $i++;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <?php else: ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan='7' align='center'> <strong>Record Not Available</strong> </td>
                                        </tr>
                                    </tfoot>
                                    <?php endif; ?>
                            </table>
			   </div>
                        </div>
                        <div class="box-footer clearfix">
                            <?php echo e($orderData->appends(Request::query())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>
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


<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>