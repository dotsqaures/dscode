<?php if(session()->has('success')): ?>

<div class="alert alert-success alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

        <strong><?php echo e(session()->get('success')); ?></strong>

</div>

<?php endif; ?>


<?php if(session()->has('error')): ?>

<div class="alert alert-danger alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

        <strong><?php echo e(session()->get('error')); ?></strong>

</div>

<?php endif; ?>

<?php if(session()->has('warning')): ?>

<div class="alert alert-warning alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

	<strong><?php echo e(session()->get('warning')); ?></strong>

</div>

<?php endif; ?>


<?php if(session()->has('info')): ?>

<div class="alert alert-info alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

	<strong><?php echo e(session()->get('info')); ?></strong>

</div>

<?php endif; ?>


<?php if($errors->any()): ?>

<div class="alert alert-danger">

	<button type="button" class="close" data-dismiss="alert">×</button>	
	<ul>
		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>
</div>

<?php endif; ?>