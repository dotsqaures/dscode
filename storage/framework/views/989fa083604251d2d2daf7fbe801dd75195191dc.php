<?php $__env->startSection('title', __('Not Found')); ?>
<?php $__env->startSection('content'); ?>

<div class="middle-wrapper">
    <div class="container">

            <div class="error-page">
                    <div class="cart-dtl-box shad">
                      <img src="<?php echo e(asset('img/error.png')); ?>" alt=""/>
                      <h2 class="pb-0">Error</h2>
                      <h2>Page not found</h2>
                      <p>The page you are looking for ways moved, removed, renamed or might never existed.</p>
                      <a href="<?php echo e(app('router')->has('frontend.home') ? route('frontend.home') : url('/')); ?>" class="btn-custom">Go home</a>
                    </div>
                  </div>

    </div>
  </div>


  <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('errors::layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>