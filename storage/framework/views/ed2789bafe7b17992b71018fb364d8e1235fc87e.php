<?php $__env->startSection('title', !empty($adminUser) ? 'Update Profile' : 'Add Profile'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Header (adminUser header) -->
    <section class="content-header">

        <h1>
            Manage Admin Users
            <small>Here you can update admin profile</small>
        </h1>
        <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> 'Update Profile']]])); ?>

    </section>
    <section class="content" data-table="adminUsers">
            <div class="row adminUsers">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(!empty($adminUser) ? 'Edit Profile' : 'Add Admin User'); ?> </h3>

                        </div><!-- /.box-header -->

                <?php if(isset($adminUser)): ?>
                    <?php echo e(Form::model($adminUser, ['url' => route('admin.update-profile') , 'method' => 'patch'])); ?>

                <?php else: ?>
                    <?php echo e(Form::open(['url' => route('admin.update-profile', app('request')->query())])); ?>

                <?php endif; ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group required <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="name">Full Name</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'First Name'])); ?>

                                        <?php if($errors->has('name')): ?>
                                        <span class="help-block"><?php echo e($errors->first('name')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                              </div>

                              <div class="form-group required <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="last_name">Email</label>
                                        <div class="col-md-6">
                                            <?php echo e(Form::text('email', old('email'), ['type' => 'email','class' => 'form-control','placeholder' => 'Email'])); ?>

                                            <?php if($errors->has('email')): ?>
                                            <span class="help-block"><?php echo e($errors->first('email')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                              </div>

                              <div class="form-group required <?php echo e($errors->has('mobile') ? 'has-error' : ''); ?>">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="last_name">Mobile</label>
                                        <div class="col-md-6">
                                            <?php echo e(Form::text('mobile', old('mobile'), ['class' => 'form-control','placeholder' => 'Mobile'])); ?>

                                            <?php if($errors->has('mobile')): ?>
                                            <span class="help-block"><?php echo e($errors->first('mobile')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                              </div>


                        </div>
                    </div> <!-- /.row -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Update </button>
                    </div>
                    <?php echo e(Form::close()); ?>


                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>