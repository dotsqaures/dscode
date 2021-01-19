<?php $__env->startSection('title', 'Change Current Password'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Change Password
        </h1>
        <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> "Change Password"]]])); ?>

    </section>
    <section class="content" data-table="pages">
            <div class="row pages">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(__("Change Password")); ?></h3>
                        </div><!-- /.box-header -->
                    <?php echo e(Form::open(['route' => 'admin.updatepassword'])); ?>

                <div class="box-body">
                    <div class="row">
                            <div class="col-md-8 com-md-offset-2">
                            <div class="form-group<?php echo e($errors->has('current-password') ? ' has-error' : ''); ?>">
                                    <div class="row">
                                <label for="new-password" class="col-md-4 control-label">Current Password</label>
                                <div class="col-md-6">
                                    <input id="current-password" value="<?php echo e(old("current-password")); ?>" type="password" class="form-control" name="current-password" placeholder="Current Password" required>

                                    <?php if($errors->has('current-password')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('current-password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                    </div>
                            </div>

                            <div class="form-group<?php echo e($errors->has('new-password') ? ' has-error' : ''); ?>">
                                    <div class="row">
                                <label for="new-password" class="col-md-4 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password" type="password" value="<?php echo e(old("new-password")); ?>" class="form-control" placeholder="New Password" name="new-password" required>
                                    <?php if($errors->has('new-password')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('new-password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                    <div class="row">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" value="<?php echo e(old("new-password_confirmation")); ?>" class="form-control" name="new-password_confirmation" placeholder="Confirm New Password" required>
                                </div>
                                    </div>
                            </div>
                    </div>

                    </div> <!-- /.row -->
                 </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Change Password</button>
                    </div>
                    <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>