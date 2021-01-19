<?php $__env->startSection('title', !empty($products) ? 'Edit Product' : 'Add Product'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <!-- Content Header (category header) -->

    <section class="content-header">
        <h1>
            Manage Product
            <small>Here you can <?php echo e(!empty($products) ? 'edit' : 'add'); ?> Product</small>
        </h1>
        <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.product.index'],['label' => !empty($products) ? 'Edit Product' : 'Add Product' ]]])); ?>

    </section>
    <section class="content" data-table="categories">
            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(!empty($products) ? 'Edit Product' : 'Add Product'); ?> </h3>
                            <a href="<?php echo e(route('admin.product.index')); ?>" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                        </div><!-- /.box-header -->

                <?php if(isset($products)): ?>
                    <?php echo e(Form::model($products, ['route' => ['admin.product.update', $products->id], 'method' => 'patch','enctype'=>'multipart/form-data'])); ?>

                <?php else: ?>
                    <?php echo e(Form::open(['route' => 'admin.product.store','enctype'=>'multipart/form-data'])); ?>

                <?php endif; ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="form-group required <?php echo e($errors->has('category_id') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="category_id">Category</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::select('category_id', $categories, old("category_id"), ['class' => 'form-control'])); ?>

                                        <?php if($errors->has('category_id')): ?>
                                        <span class="help-block"><?php echo e($errors->first('category_id')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>



                              <div class="form-group required <?php echo e($errors->has('item_title') ? 'has-error' : ''); ?>">
                                <label for="title">Title</label>
                                <?php echo e(Form::text('item_title', old('title'), ['class' => 'form-control','placeholder' => 'Item Title'])); ?>

                                <?php if($errors->has('item_title')): ?>
                                <span class="help-block"><?php echo e($errors->first('item_title')); ?></span>
                                <?php endif; ?>
                              </div>






                            <div class="form-group required <?php echo e($errors->has('item_description') ? 'has-error' : ''); ?>">
                                <label for="description">item Description</label>
                                <?php echo e(Form::textarea('item_description', old('item_description'), ['class' => 'form-control','placeholder' => 'item Description', 'rows' => 4])); ?>

                                <?php if($errors->has('item_description')): ?>
                                <span class="help-block"><?php echo e($errors->first('item_description')); ?></span>
                                <?php endif; ?>
                            </div>






                        <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                            <label class="control-label" for="last_name">Status</label>
                        <?php echo e(Form::select('status', [1 => 'Active', 0 => 'In-Active'], old("status"), ['class' => 'form-control'])); ?>

                       </div>


 </div>

                        <div class="col-md-12">
                         <div class="form-group required <?php echo e($errors->has('qty') ? 'has-error' : ''); ?>">
                                <label for="title">Quantity</label>
                                <?php echo e(Form::text('qty', old('qty'), ['class' => 'form-control','placeholder' => 'Quantity'])); ?>

                                <?php if($errors->has('qty')): ?>
                                <span class="help-block"><?php echo e($errors->first('qty')); ?></span>
                                <?php endif; ?>
                          </div>


               </div>



               <div class="col-md-12 adddiv">


                <div class="col-md-4">
                <div class="form-group required <?php echo e($errors->has('wight') ? 'has-error' : ''); ?>">
                    <label for="title">Weight</label>
                    <?php echo e(Form::text('wight[]', null, ['class' => 'form-control','placeholder' => 'Weight'])); ?>

                    <?php if($errors->has('wight')): ?>
                    <span class="help-block"><?php echo e($errors->first('wight')); ?></span>
                    <?php endif; ?>
                </div>
                </div>
                <div class="col-md-4">

                  <div class="form-group required <?php echo e($errors->has('final_price') ? 'has-error' : ''); ?>">
                                <label for="title">Final price($)</label>
                                <?php echo e(Form::text('final_price[]', null, ['class' => 'form-control','placeholder' => 'Final Price'])); ?>

                                <?php if($errors->has('final_price')): ?>
                                <span class="help-block"><?php echo e($errors->first('final_price')); ?></span>
                                <?php endif; ?>
                    </div>
                </div>

                </div>

                <div class="add-more-row"></div>

                <div class="col-md-2">
                    <div class="form-group change">
                        <label for="">&nbsp;</label><br/>
                        <a class="btn btn-success add-more">+ Add More</a>
                    </div>
                </div>

                <br/>

               <div class="col-md-6">
               <div class="form-group">
                <label for="description">Product Image</label>
                <input multiple="multiple" name="product_image" type="file">
             </div>
            </div>
                    </div> <!-- /.row -->




                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                        <a href="<?php echo e(route('admin.product.index')); ?>" class="btn btn-warning btn-flat" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                    </div>
                    <?php echo e(Form::close()); ?>


                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>








<?php $__env->startSection('per_page_script'); ?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js" type="text/javascript"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script>

    $(document).ready(function() {
        $(".add-more").click(function(){
            var html = $(".adddiv").html();
            $(".add-more-row").append(html);
        });


    });

        $(function() {
            $('#datetimepicker1').datepicker();
          });


        function RemoveImage(productImageId)
        {

             var productImageID = productImageId;

             if(confirm("Are you sure you want to delete this?")){



              $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '<?php echo e(url('admin/product/deleteimage')); ?>'+'/'+productImageID,
                            type: 'GET',
                            dataType: 'JSON',
                            data: {

                                "id": productImageID // method and token not needed in data
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function (xhr) {

                            },

                            success: function (json) {

                                if (json.status === true) {

                                    $(".removeImage"+productImageID).hide();

                                } else {

                                }

                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });

                    }
                    else{
                        return false;
                    }






        }



</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>