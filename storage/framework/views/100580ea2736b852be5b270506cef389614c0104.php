<?php $__env->startSection('title','Users list'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Users
            <small>Here you can manage Employee </small>
        </h1>
        <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> \Request::route()->getName()]]])); ?>

    </section>
    <?php
    $qparams = app('request')->query();
    if(!app('request')->query('role')){
        $qparams['role'] = 1;
    }
    ?>
    <section class="content" data-table="users">
            <div class="row users">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase"><?php echo e(__('List users')); ?></span></h3>
                            <div class="box-tools">
                                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Employee</a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <div class="">
                                        <ul class="nav nav-tabs">

                                        </ul>
                                        <div class="tab-content" style="margin-top:10px;">
                                            <?php echo e(Form::open(['url' => route('admin.users.employee', $qparams),'method' => 'get'])); ?>

                                            <div class="col-md-12">
                                                    <?php echo e(Form::hidden('role', $qparams['role'])); ?>

                                            <div class="row">
                                                <div class="col-md-2 form-group">
                                                    <?php echo e(Form::select('status', ['' => 'All',1 => 'Active', 0 => 'Inactive'], app('request')->query('status'), ['class' => 'form-control'])); ?>

                                                </div>

                                                <div class="col-md-5 form-group">
                                                    <?php echo e(Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: name, email, mobile'])); ?>

                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                                                    <a href="<?php echo e(route('admin.users.employee',['role' => $qparams['role'] ])); ?>" class="btn btn-warning" title="Cancel"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                                                 </div>
                                            </div>
                                        </div>
                                            <?php echo e(Form::close()); ?>

                                                <div class="tab-pane active">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th scope="col">

                                                                    <a href="javascript:void(0)">Employee Name</a>
                                                                </th>
                                                                <th scope="col"><a href="javascript:void(0)">Employee Code</a></th>
                                                                <th scope="col"><a href="javascript:void(0)">Email</a></th>
                                                                <th scope="col"><a href="javascript:void(0)">Restaurent Name</a></th>

                                                                <th scope="col" width="8%"><?php
                                                                        $sorting['sort'] = "status";
                                                                       ?>
                                                                       <a href="<?php echo e(URL::route('admin.users.index',$sorting)); ?>">Status</a></th>
                                                                <th scope="col" width="18%">created</th>
                                                                <th scope="col" class="actions" width="12%">Action</th>
                                                            </tr>
                                                        </thead>
                                                                <?php if($users->count() > 0): ?>
                                                                <tbody>
                                                            <?php
                                                            $i = (($users->currentPage() - 1) * ($users->perPage()) + 1)
                                                            ?>
                                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="row-<?php echo e($user->id); ?>">
                                                                    <td> <?php echo e($i); ?>. </td>
                                                                    <td><?php echo e($user->name); ?></td>
                                                                    <td><?php echo e($user->employee_code); ?></td>
                                                                    <td><?php echo e($user->email); ?></td>
                                                                    <td><?php echo e($user->restuarents_id); ?></td>


                                                                    <td><?php echo e($user->status == 1 ? "Active" : "In-Active"); ?></td>
                                                                    <td><?php echo e($user->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT'))); ?></td>
                                                                    <td class="actions">
                                                                        <?php
                                                                            $queryStr['id'] = $user->id;
                                                                            //$queryStr = array_merge( $queryStr , $qparams);
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <a href="<?php echo e(route('admin.users.show', $queryStr)); ?>" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                                            <a href="<?php echo e(route('admin.users.edit', $queryStr)); ?>" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>

                                                                            <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete <?php echo e($user->name); ?>" data-url="<?php echo e(route('admin.users.destroy', $user->id)); ?>" data-title="<?php echo e($user->name); ?>"><i class="fa fa-trash"></i></a>
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
                            <?php echo e($users->appends(Request::query())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>