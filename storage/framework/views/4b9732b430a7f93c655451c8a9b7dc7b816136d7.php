<?php $__env->startSection('title', !empty($category) ? 'Edit Category' : 'Add Category'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Content Header (category header) -->
    <section class="content-header">
        <h1>
            Manage Catgeory
            <small>Here you can <?php echo e(!empty($category) ? 'edit' : 'add'); ?> Catgeory</small>
        </h1>
        <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.categories.index'],['label' => !empty($category) ? 'Edit Category' : 'Add Category' ]]])); ?>

    </section>
    <section class="content" data-table="categories">
            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(!empty($category) ? 'Edit Catgeory' : 'Add Catgeory'); ?> </h3>
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-default pull-right" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                        </div><!-- /.box-header -->

                <?php if(isset($category)): ?>
                    <?php echo e(Form::model($category, ['route' => ['admin.categories.update', $category->id], 'method' => 'patch','files'=>'true'])); ?>

                <?php else: ?>
                    <?php echo e(Form::open(['route' => 'admin.categories.store','files'=>'true'])); ?>

                <?php endif; ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group <?php echo e($errors->has('parent_id') ? 'has-error' : ''); ?>">
                                <label class="control-label" for="last_name">Parent Category</label>
                                        <?php echo e(Form::select('parent_id', $Parentcategories, old("parent_id"), ['class' => 'form-control'])); ?>

                           </div>

                              <div class="form-group required <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                                <label for="title">Title</label>
                                <?php echo e(Form::text('title', old('title'), ['class' => 'form-control','placeholder' => 'Title'])); ?>

                                <?php if($errors->has('title')): ?>
                                <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                              </div>

                              <div class="form-group <?php echo e($errors->has('slug') ? 'has-error' : ''); ?>">
                                <label for="title">Slug</label>
                                <?php echo e(Form::text('slug', old('slug'), ['class' => 'form-control','placeholder' => 'Slug'])); ?>

                                <?php if($errors->has('slug')): ?>
                                <span class="help-block"><?php echo e($errors->first('slug')); ?></span>
                                <?php endif; ?>
                              </div>

                              <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                                    <label class="control-label" for="last_name">Status</label>
                                            <?php echo e(Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control'])); ?>

                          </div>



                        </div>

                        <div class="col-md-6">
                            <div class="form-group required <?php echo e($errors->has('meta_title') ? 'has-error' : ''); ?>">
                                <label for="title">Meta Title</label>
                                <?php echo e(Form::text('meta_title', old('meta_title'), ['class' => 'form-control','placeholder' => 'Meta Title'])); ?>

                                <?php if($errors->has('meta_title')): ?>
                                <span class="help-block"><?php echo e($errors->first('meta_title')); ?></span>
                                <?php endif; ?>
                              </div>

                              <div class="form-group required <?php echo e($errors->has('meta_keyword') ? 'has-error' : ''); ?>">
                                <label for="title">Meta Keyword</label>
                                <?php echo e(Form::text('meta_keyword', old('meta_keyword'), ['class' => 'form-control','placeholder' => 'Meta Keyword'])); ?>

                                <?php if($errors->has('meta_keyword')): ?>
                                <span class="help-block"><?php echo e($errors->first('meta_keyword')); ?></span>
                                <?php endif; ?>
                              </div>

                              <div class="form-group required <?php echo e($errors->has('meta_description') ? 'has-error' : ''); ?>">
                                <label for="description">Meta Description</label>
                                <?php echo e(Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control','placeholder' => 'Meta Description', 'rows' => 4])); ?>

                                <?php if($errors->has('meta_description')): ?>
                                <span class="help-block"><?php echo e($errors->first('meta_description')); ?></span>
                                <?php endif; ?>
                            </div>







                        </div>


                    </div> <!-- /.row -->


                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-warning btn-flat" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                    </div>
                    <?php echo e(Form::close()); ?>


                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>