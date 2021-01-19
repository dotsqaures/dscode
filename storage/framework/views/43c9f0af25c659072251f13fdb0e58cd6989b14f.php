<?php $__env->startSection('title'); ?> Settings <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Setting
                <small>Here you can manage the settings</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(url('dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo e(route('setting.general')); ?>" class="active">Settings</a></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-8">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">List Settings</span></h3>
                            <div class="box-tools">
                                <!--<a href="<?php echo e(route('setting.general.add')); ?>" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> New Setting</a>-->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col"><a href="<?php echo e(URL::route('setting.general',['sort' => 'title','direction'=> request()->direction == 'asc' ? 'desc' : 'asc'])); ?>">Title</a></th>
                                    <th scope="col"><a href="<?php echo e(URL::route('setting.general',['sort' => 'slug','direction'=> request()->direction == 'asc' ? 'desc' : 'asc'])); ?>">Constant</a></th>
                                    <th scope="col">Value</th>
                                    <th scope="col" class="actions" style="width: 15%;">Actions</th>
                                </tr>
                                </thead>
                                    <?php if($settings->count() > 0): ?>
                                    <tbody>
                                <?php
                                $i = (($settings->currentPage() - 1) * ($settings->perPage()) + 1)
                                ?>
                                <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td> <?php echo e($i); ?>. </td>
                                        <td><?php echo e($setting->title); ?></td>
                                        <td><?php echo e($setting->slug); ?></td>
                                        <td><?php echo e($setting->config_value); ?></td>
                                        <td class="actions">
                                            <div class="btn-group">
                                                <a href="<?php echo e(url('admin/settings/general/view/'.$setting->id)); ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                <a href="<?php echo e(url('admin/settings/general/edit/'.$setting->id)); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
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
                            <?php echo e($settings->appends(Request::query())->links()); ?>

                         </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-exclamation"></i> Important Rules
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>
                                For each config settings that would be added to the system, make sure it has these constant/slug:
                            </p>
                            <ul>
                                <li>
                                    <small class="label bg-yellow">
                                        SITE_TITLE
                                    </small> - Will be replaced by website title from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ADMIN_EMAIL
                                    </small> - Will be replaced by admin email from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        FROM_EMAIL
                                    </small> - Will be replaced by email from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        WEBSITE_OWNER
                                    </small> - Will be replaced by Owner name from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        TELEPHONE
                                    </small> - Will be replaced by phone number from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ADMIN_PAGE_LIMIT
                                    </small> - Will be replaced by admin page limit from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        FRONT_PAGE_LIMIT
                                    </small> - Will be replaced by front page limit from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ADMIN_DATE_FORMAT
                                    </small> - Will be replaced by admin date format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ADMIN_DATE_TIME_FORMAT
                                    </small> - Will be replaced by admin date time format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        FRONT_DATE_FORMAT
                                    </small> - Will be replaced by front date format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        FRONT_DATE_TIME_FORMAT
                                    </small> - Will be replaced by front date time format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        CONTACT_US_TEXT
                                    </small> - Will be replaced by front date time format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        GOOGLE_MAP_KEY
                                    </small> - Will be replaced by front date time format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        OFFICE_ADDRESS
                                    </small> - Will be replaced by front date time format from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        DEVELOPMENT_MODE
                                    </small> - Will be replaced by debug mode from admin settings.
                                </li>


                            </ul>
                        </div><!-- ./box-body -->
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>