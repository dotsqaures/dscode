<?php $__env->startSection('title','Reset Password'); ?>
<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>
    <p class="login-box-msg" style="padding-bottom: 5px;"><?php echo e(__('Forgot Password ?')); ?></p>
    <p  style="padding-left: 15px;"><small>Enter your e-mail address below to reset your password.</small> </p>
    <form method="POST" action="<?php echo e(route('admin.password.email')); ?>">
            <?php echo csrf_field(); ?>
    <div class="form-group has-feedback">
            <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="Enter your e-mail address" name="email" value="<?php echo e(old('email')); ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>

    <div class="row">
        <div class="col-xs-4 pull-left">
                <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-default btn-block btn-flat">Back</a>
        </div><!-- /.col -->
        <div class="col-xs-8 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <?php echo e(__('Send Password Reset Link')); ?>

                    </button>
        </div><!-- /.col -->
    </div>
</form>
    <br>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.login', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>