<?php $__env->startSection('title','Category'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category Manager
            <small>Here you can manage category</small>
        </h1>
        <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> \Request::route()->getName()]]])); ?>

    </section>

    <section class="content" data-table="categories">

            <?php echo e(Form::open(['url' => route('admin.categories.index'),'method' => 'get'])); ?>

            <div class="col-md-12">
            <div class="row">

                <div class="col-md-2 form-group">
                        <?php echo e(Form::select('status', ['' => 'All',1 => 'Active', 0 => 'In-Active'], app('request')->query('status'), ['class' => 'form-control'])); ?>

                    </div>
                <div class="col-md-5 form-group">
                    <?php echo e(Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: Category name, Description'])); ?>

                </div>
                <div class="col-md-3 form-group">
                    <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-warning" title="Cancel"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                </div>
            </div>
        </div>
    <?php echo e(Form::close()); ?>


            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase"><?php echo e(__('List Category')); ?></span></h3>
                            <div class="box-tools">
                                <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Category
                                </a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th scope="col">Parent Category</th>
                                        <th scope="col">Sub Category</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col" width="18%">created</th>
                                        <th scope="col" class="actions" width="12%">Action</th>
                                    </tr>
                                </thead>
                                        <?php if($categories): ?>
                                        <tbody>
                                    <?php
                                    $i = (($categories->currentPage() - 1) * ($categories->perPage()) + 1)
                                    ?>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr class="row-<?php echo e($category->id); ?>">
                                            <td> <?php echo e($i); ?>. </td>

                                            <td>
                                                <?php if(!empty($category->parent_id)): ?>
                                                <?php echo e(\app\Helpers\BasicHelpers::GetparentCategory($category->parent_id)); ?>

                                                <?php else: ?>
                                                <?php echo e($category->title); ?>

                                                <?php endif; ?>


                                            </td>



                                            <td>

                                                 <?php if(!empty($category->parent_id)): ?>
                                                 <?php echo e($category->title); ?>

                                                <?php else: ?>
                                                <?php echo e('--'); ?>

                                                <?php endif; ?>

                                            </td>
                                            <td> <?php echo e($category->slug); ?></td>
                                            <td><?php echo e($category->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT'))); ?></td>
                                            <td class="actions">
                                                <div class="form-group">
                                                    
                                                    <a href="<?php echo e(route('admin.categories.edit',['id' => $category->id])); ?>" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete <?php echo e($category->title); ?>" data-url="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" data-title="<?php echo e($category->title); ?>"><i class="fa fa-trash"></i></a>

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
                        <div class="box-footer clearfix">
                            <?php echo e($categories->appends(Request::query())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>