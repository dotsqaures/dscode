<?php $__env->startSection('title','View Restaurent Detail'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<section class="content-header">
    <h1>
        Manage Restaurant
        <small>Here you can view restaurant details</small>
    </h1>
    <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.restaurents.index'],['label' => 'View Restaurent Details']]])); ?>

</section>
<?php $calendar_type=[1=>'OutLook',2=>'Gmail',3=>'Yahoo',4=>'Mac(thunderbird)']; ?>
<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?php echo e($restro->name); ?></h3>
            

            <div class="box-body">
                <table class="table table-hover table-striped">


                        <tr>
                                <th scope="row"><?php echo e(__('Location')); ?></th>
                                <td><?php echo e($restro->location); ?></td>
                            </tr>

                            <tr>
                                <th scope="row"><?php echo e(__('Latitude')); ?></th>
                                <td><?php echo e($restro->lat); ?></td>
                            </tr>

                            <tr>
                                <th scope="row"><?php echo e(__('Longitude')); ?></th>
                                <td><?php echo e($restro->lng); ?></td>
                            </tr>



                            <tr>
                                <th scope="row"><?php echo e(__('Description')); ?></th>
                                <td><?php echo e($restro->desciption); ?></td>
                            </tr>




                      <tr>
                            <th scope="row"><?= __('Created') ?></th>
                            <td><?php echo e($restro->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT'))); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('Modified')); ?></th>
                            <td><?php echo e($restro->updated_at->format(config('get.ADMIN_DATE_TIME_FORMAT'))); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo e(__('Status')); ?></th>
                            <td><?php echo e($restro->status ? __('Active') : __('Inactive')); ?></td>
                        </tr>


                        <?php if(!empty($restro->restro_picture)): ?>
                        <tr>
                            <th scope="row"><?= __('Restaurant Image') ?></th>
                            <td>

                          <img src="<?php echo e(asset(Storage::url($restro->restro_picture))); ?>" style="width:100px; height:100px;"/>

                            </td>
                        </tr>
                        <?php endif; ?>

                    </table>

<?php if(count($restro->restaurantTime)>0): ?>


                    <table class="table table-hover table-striped">
                        <th>SNO</th>
                        <th>Day</th>
                        <th>Morning Open/Close Time</th>
                        <th>Evening Open/Close Time</th>
                 <?php $__currentLoopData = $restro->restaurantTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timess): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>1</td>
                            <td><?php echo e($timess->week_day); ?></td>
                            <td><?php echo e($timess->morning_open_time.'-'.$timess->morning_close_time); ?></td>
                            <td><?php echo e($timess->evening_open_time.'-'.$timess->evening_close_time); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>

                  <?php endif; ?>

            </div>

            <div class="box-footer">
                <a href="<?php echo e(route('admin.restaurents.index', app('request')->query())); ?>" class="btn btn-default pull-left" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
            </div>
        </div>
    </div>


    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>