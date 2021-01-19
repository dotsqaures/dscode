<?php $__env->startSection('title','Email Templates'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Email Templates
            <small>Here you can manage the email templates</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(url('admin.dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="javascript:void(0)" class="active">Email Templates</a></li>
        </ol>
    </section>
    <section class="content" data-table="emailHooks">
        <div class="row emailHooks">
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><span class="caption-subject font-green bold uppercase"><?php echo e(__('List Email Templates')); ?></span></h3>
                        <div class="box-tools">
                           
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                     <?php if(!$emailTemplates->isEmpty()): ?>
                            <ul class="timeline">
                               <?php $__currentLoopData = $emailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emailTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="time-label">
                                        <span class="bg-navy">
                                            <?php echo e($emailTemplate->created_at->toFormattedDateString()); ?>

                                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-anchor bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> <?php echo e($emailTemplate->created_at->format('H:i A')); ?></span>

                                            <h3 class="timeline-header">
                                               <a href="<?php echo e(route('admin.hooks')); ?>/<?php echo e($emailTemplate->email_hook->id); ?>"> <?php echo e($emailTemplate->email_hook->title); ?> (<?php echo e($emailTemplate->email_hook->slug); ?>) </a>
                                            </h3>
                                            <div class="timeline-body">
                                                <h3 style="margin-top: 0px;"> <small>
                                                        <a href="<?php echo e(route('admin.email-preferences.show', ['id' => $emailTemplate->email_preference->id])); ?>"><?php echo e($emailTemplate->email_preference->title); ?></a>
                                                    </small>
                                                </h3>
                                                <?php echo e($emailTemplate->subject); ?>

                                            </div>
                                            <div class="timeline-footer form-inline">
                                                <a href="<?php echo e(route('admin.email-templates.show', ['id' => $emailTemplate->id])); ?>" class="btn btn-default btn-xs"><i class="fa fa-eye" data-toggle="tooltip" data-placement="left" data-title="View" data-original-title="" title=""></i></a>
                                                <a href="<?php echo e(route('admin.email-templates.edit', ['id' => $emailTemplate->id])); ?>" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" data-title="Edit" data-original-title="Edit" title=""></i></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                            <?php else: ?>
                            <div style="align:center;">  <strong>Record Not Available</strong> </div>
                            <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="col-md-5">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-exclamation"></i> Important Rules
                            </h3>

                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>
                                For each email style or email preference that would be added to the system, make sure it has these hooks:
                            </p>
                            <ul>
                                <li>
                                    <small class="label bg-yellow">
                                        ##SYSTEM_LOGO##
                                    </small> - Will be replaced by logo from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ##SYSTEM_APPLICATION_NAME##
                                    </small> - Will be replaced by application name from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ##EMAIL_CONTENT##
                                    </small> - Will be replaced by email message from email hook settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ##EMAIL_FOOTER##
                                    </small> - Will be replaced by email footer from email hook settings.
                                </li>
                            </ul>
                        </div><!-- ./box-body -->
                    </div>
                </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>