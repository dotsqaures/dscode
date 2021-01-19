<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- Content Header (user header) -->
<section class="content-header">
<style>
.phone-no {
    position: absolute;
    left: 0;
    height: 100%;
    display: flex;
    -webkit-display: flex;
    justify-content: center;
    -webkit-justify-content: center;
    align-items: center;
    -webkit-align-items: center;
    background: #fff;
    border-radius: 4px 0 0 4px;
    color: #000;
    width: 45px;
    border-right: 1px solid #e0e0e0;
}
.phone-no-outer {
    position: relative;
    background-color: #f5f5f5 !important;
    border-color: #e0e0e0 !important;
    padding-left: 45px;
    border: 1px solid;
    border-radius: 4px;
}
.phone-no-outer .form-control{
border: none;
}
</style>
    <h1>
        Manage Free Stamp Card To User
        <small>Here you can manage free stamp card to user </small>
    </h1>
    <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.stamps.index'],['label' => !empty($restro) ? 'Edit Stamp' : 'Add Stamp' ]]])); ?>

</section>
<section class="content" data-table="stamps">
    <div class="row stamps">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> </h3>

                </div><!-- /.box-header -->

                <?php if(isset($restro)): ?>
                <?php
                $queryStr['id'] = $restro->id;
                $queryStr = array_merge( $queryStr , app('request')->query());
                ?>
                <?php echo e(Form::model($restro, ['url' => route('admin.stamps.update', $queryStr) , 'method' => 'patch','enctype'=>'multipart/form-data'])); ?>

                <?php else: ?>
                <?php echo e(Form::open(['url' => route('admin.stamps.updatefreecard', app('request')->query()),'enctype'=>'multipart/form-data'])); ?>

                <?php endif; ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">




                             <div class="form-group <?php echo e($errors->has('user_id') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Select User</label>
                                    <div class="col-md-6">
                                            <?php echo e(Form::select('user_id', $userdata, old("user_id"), ['class' => 'form-control','required'=>true])); ?>

                              </div></div></div>

                              <div class="form-group <?php echo e($errors->has('charge_id') ? 'has-error' : ''); ?>">
                                <div class="row">
                                <label class="col-md-3 control-label" for="last_name">Select Stamp</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::select('charge_id', $stampdata , old("charge_id"), ['class' => 'form-control','required'=>true])); ?>

                                </div></div></div>








                                                        </div>
                                                </div> <!-- /.row -->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>

                                            </div>
                                            <?php echo e(Form::close()); ?>


                                        </div>
                                </div>
                            </div>
                            </section>
                            <?php $__env->stopSection(); ?>
<?php $__env->startSection('per_page_script'); ?>
<script>


    function calculateSaving(){

        var normalprice = $(".normalprice").val();
        var discountprice = $(".discountprice").val();
        if(normalprice != ''){
        var saving = discountprice - normalprice ;
         var savingprice = Math.abs(saving);
         var finalpricer = savingprice.toFixed(2);

         $(".savingprice").val(finalpricer);
        }else{
            $(".ShowMessage").html('<p style="color:red">Normal price is required</p>');
        }

    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXZKrj9Z9SBgjD1E9CTk5f4d5rh0Mwvcc&libraries=places&callback=initAutocomplete"
    async defer></script>


        <?php echo e(Html::script('js/jquery.mask.js')); ?>


        <script>
                $(document).ready(function($){

                $(".jbsekerregis").mask("400 000 000");
                });
        </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>