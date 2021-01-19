<?php if(count($breadcrumbs)): ?>
    <ol class="breadcrumb">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($breadcrumb->url && !$loop->last): ?>
                <li class="breadcrumb-item"><a href="<?php echo e($breadcrumb->url); ?>">
                    <?php
                    if(isset($breadcrumb->icon) && !empty($breadcrumb->icon)){
                    ?>
                    <i class="<?php echo e($breadcrumb->icon); ?>"></i>
                    <?php
                        }
                    ?>
                    <?php echo e($breadcrumb->title); ?></a></li>
            <?php else: ?>
                <li class="breadcrumb-item active">
                    <?php
                    if(isset($breadcrumb->icon) && !empty($breadcrumb->icon)){
                    ?>
                    <i class="<?php echo e($breadcrumb->icon); ?>"></i>
                   <?php
                        }
                    ?>
                    <?php echo e($breadcrumb->title); ?>

                </li>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>

<?php endif; ?>
