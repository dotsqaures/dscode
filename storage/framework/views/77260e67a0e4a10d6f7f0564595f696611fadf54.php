<?php $__env->startSection('title','Restaurent list'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Restaurant
            <small>Here you can manage Restaurant </small>
        </h1>
            <?php echo e(Breadcrumbs::render('common',['append' => [['label' => 'Restaurent Manager']]])); ?>


    </section>

    <section class="content" data-table="users">
            <div class="row users">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase"><?php echo e(__('Restaurant List')); ?></span></h3>
                            <div class="box-tools">
                                <a href="<?php echo e(route('admin.restaurents.create')); ?>" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Restaurant</a
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <div class="">
                                        <ul class="nav nav-tabs">

                                        </ul>
                                        <div class="tab-content" style="margin-top:10px;">

                                                <div class="tab-pane active">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th scope="col">

                                                                       Name
                                                                   </th>
                                                                   <th scope="col">

                                                                    Location
                                                                </th>



                                                                <th scope="col" width="8%"> Status</th>


                                                                <th scope="col" width="18%">Created</th>
                                                                <th scope="col" class="actions" width="12%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                                <?php if($resto->count() > 0): ?>
                                                                <tbody>
                                                            <?php
                                                            $i = (($resto->currentPage() - 1) * ($resto->perPage()) + 1)
                                                            ?>
                                                            <?php $__currentLoopData = $resto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="row-<?php echo e($val->id); ?>">
                                                                    <td> <?php echo e($i); ?>. </td>

                                                                    <td><?php echo e($val->name); ?></td>

                                                                    <td><?php echo e($val->location); ?></td>

                                                                    <td><?php echo e($val->status == 1 ? "Active" : "In-Active"); ?></td>

                                                                    <td><?php echo e($val->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT'))); ?></td>
                                                                    <td class="actions">
                                                                        <?php
                                                                            $queryStr['id'] = $val->id;
                                                                            //$queryStr = array_merge( $queryStr , $qparams);
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <a href="<?php echo e(route('admin.restaurents.show', $queryStr)); ?>" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                                            <a href="<?php echo e(route('admin.restaurents.edit', $queryStr)); ?>" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>

                                                                            <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete <?php echo e($val->name); ?>" data-url="<?php echo e(route('admin.restaurents.destroy', $val->id)); ?>" data-title="Delete <?php echo e($val->name); ?>"><i class="fa fa-trash"></i></a>
                                                                        </div>
                                                                    </td>
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
                                </div>
                        </div>
                        <div class="box-footer clearfix">
                            <?php echo e($resto->appends(Request::query())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>