<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Setting
                <small>Update SMTP configuration details</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(url('dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo e(route('setting.general')); ?>">Settings</a></li>
                <li><a href="javascript:void(0)" class="active">SMTP</a></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-8">
                    <div class="box box-default settings">
                        <div class="box-header with-border">
                            <h3 class="box-title">SMTP Detail</h3>
                        </div><!-- /.box-header -->
                        <form method="post"  accept-charset="utf-8" role="form"
                              action="<?php echo e(route('setting.smtp.update')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Constant/Slug<span class="text-danger"></span></label>
                                            <?php echo e(Form::text('setting[0][slug]','SMTP_ALLOW',['class' => 'form-control','readonly' => 'readonly'])); ?>

                                            <?php echo e(Form::hidden('setting[0][title]','SMTP ALLOW',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[0][field_type]','text',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[0][manager]','smtp',['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="smtp_allow">Config Value</label>
                                            <div class="form-group field-switch-type">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <?php echo e(Form::hidden('setting[0][config_value]',0)); ?>

                                                    <?php echo e(Form::checkbox('setting[0][config_value]',1,(isset($smtp[0]['config_value']) && $smtp[0]['config_value'] == 1) ? true : false,['class' => 'switch-status','id' => 'smtp_allow'])); ?>


                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Constant/Slug<span class="text-danger"></span></label>
                                            <?php echo e(Form::text('setting[1][slug]','SMTP_EMAIL_HOST',['class' => 'form-control','readonly' => 'readonly'])); ?>

                                            <?php echo e(Form::hidden('setting[1][title]','Email Host Name',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[1][field_type]','text',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[1][manager]','smtp',['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="smtp-host-config">Config Value</label>
                                            <?php echo e(Form::text('setting[1][config_value]',isset($smtp[1]['config_value']) ? $smtp[1]['config_value']: '' ,['class' => 'form-control','placeholder' => 'SMTP server Host','id' => 'smtp-host-config'])); ?>

                                        </div>
                                    </div>
                                </div><!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Constant/Slug<span class="text-danger"></span></label>
                                            <?php echo e(Form::text('setting[2][slug]','SMTP_USERNAME',['class' => 'form-control','readonly' => 'readonly'])); ?>

                                            <?php echo e(Form::hidden('setting[2][title]','SMTP Username',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[2][field_type]','text',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[2][manager]','smtp',['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Config Value</label>
                                            <?php echo e(Form::text('setting[2][config_value]',isset($smtp[2]['config_value']) ? $smtp[2]['config_value']: '',['class' => 'form-control','placeholder' => 'SMTP Username'])); ?>

                                        </div>
                                    </div>
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Constant/Slug<span class="text-danger"></span></label>
                                            <?php echo e(Form::text('setting[3][slug]','SMTP_PASSWORD',['class' => 'form-control','readonly' => 'readonly'])); ?>

                                            <?php echo e(Form::hidden('setting[3][title]','SMTP password',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[3][field_type]','text',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[3][manager]','smtp',['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Config Value</label>
                                            <?php echo e(Form::text('setting[3][config_value]',isset($smtp[3]['config_value']) ? $smtp[3]['config_value']: '',['class' => 'form-control','placeholder' => 'SMTP Password'])); ?>

                                        </div>
                                    </div>
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Constant/Slug<span class="text-danger"></span></label>
                                            <?php echo e(Form::text('setting[4][slug]','SMTP_PORT',['class' => 'form-control','readonly' => 'readonly'])); ?>

                                            <?php echo e(Form::hidden('setting[4][title]','SMTP port',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[4][field_type]','text',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[4][manager]','smtp',['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Config Value</label>
                                            <?php echo e(Form::text('setting[4][config_value]',isset($smtp[4]['config_value']) ? $smtp[4]['config_value']: '',['class' => 'form-control','placeholder' => 'SMTP Port'])); ?>

                                        </div>
                                    </div>
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Constant/Slug<span class="text-danger"></span></label>
                                            <?php echo e(Form::text('setting[5][slug]','SMTP_TLS',['class' => 'form-control','readonly' => 'readonly'])); ?>

                                            <?php echo e(Form::hidden('setting[5][title]','SMTP Tls',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[5][field_type]','text',['class' => 'form-control'])); ?>

                                            <?php echo e(Form::hidden('setting[5][manager]','smtp',['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="5-config-value">Config Value</label>
                                            <div class="form-group field-switch-type">
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <?php echo e(Form::hidden('setting[5][config_value]',0)); ?>

                                                    <?php echo e(Form::checkbox('setting[5][config_value]',1,(isset($smtp[5]['config_value']) && $smtp[5]['config_value'] == 1) ? true : false,['class' => 'switch-status'])); ?>

                                                    <span></span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i
                                            class="fa fa-fw fa-save"></i> Submit
                                </button>

                            </div>
                        </form>
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
                                For each config settings that would be added to the system, make sure it has these
                                constant/slug:
                            </p>
                            <ul>
                                <li>
                                    <small class="label bg-yellow">
                                        MAIN_LOGO
                                    </small>
                                    - Will be replaced by logo from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        MAIN_FAVICON
                                    </small>
                                    - Will be replaced by favicon icon image from the admin settings.
                                </li>

                            </ul>
                        </div><!-- ./box-body -->
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>