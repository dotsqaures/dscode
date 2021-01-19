<?php $__env->startSection('title','Login'); ?>
<?php $__env->startSection('content'); ?>
   <p class="login-box-msg">Sign in to start your session</p>
    <?php
    $cfo = [];
     if(Request::cookie('adminckrem')){
         $cfo = json_decode(Request::cookie('adminckrem'), true);
     }
    ?>
    <form method="POST" action="<?php echo e(route('admin.login')); ?>">
         <?php echo csrf_field(); ?>
      <div class="form-group has-feedback<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email') ? old('email') : (!empty($cfo['email']) ? $cfo['email'] : '')); ?>" placeholder="<?php echo e(__('E-Mail Address')); ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <?php if($errors->has('email')): ?>
                <span class="help-block" role="alert">
                    <strong><?php echo e($errors->first('email')); ?></strong>
                </span>
            <?php endif; ?>
      </div>
      <div class="form-group has-feedback<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
        <input id="password" type="password" class="form-control" value="<?php echo e(old('password') ? old('password') :  (!empty($cfo['password']) ? $cfo['password'] : '')); ?>" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php if($errors->has('password')): ?>
                <span class="help-block" role="alert">
                    <strong><?php echo e($errors->first('password')); ?></strong>
                </span>
            <?php endif; ?>
      </div>
      <div class="row">
        <div class="col-xs-8">
                <input value="0" type="hidden" name="remember">
          <div class="checkbox icheck">
              <label style="display: none">
              <input class="form-check-input" value="1" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked="checked"' : (!empty($cfo['remember']) ? 'checked="checked"' : '')); ?> > <?php echo e(__('Remember Me')); ?>

            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<div class="social-auth-links text-center">
      <p>- OR -</p>
     <a href="<?php echo e(route('admin.password.request')); ?>">I forgot my password</a>
    </div>
    <!-- /.social-auth-links -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.login', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>