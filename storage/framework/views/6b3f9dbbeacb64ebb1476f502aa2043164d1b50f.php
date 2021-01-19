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
        Manage Restaurant
        <small>Here you can manage Restaurant user </small>
    </h1>
    <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.restaurents.index'],['label' => !empty($restro) ? 'Edit Restaurant' : 'Add Restaurant' ]]])); ?>

</section>
<section class="content" data-table="restaurents">
    <div class="row restaurents">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> </h3>
                    <a href="<?php echo e(route('admin.restaurents.index', app('request')->query())); ?>" class="btn btn-default pull-right" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                </div><!-- /.box-header -->

                <?php if(isset($restro)): ?>
                <?php
                $queryStr['id'] = $restro->id;
                $queryStr = array_merge( $queryStr , app('request')->query());
                ?>
                <?php echo e(Form::model($restro, ['url' => route('admin.restaurents.update', $queryStr) , 'method' => 'patch','enctype'=>'multipart/form-data'])); ?>

                <?php else: ?>
                <?php echo e(Form::open(['url' => route('admin.restaurents.store', app('request')->query()),'enctype'=>'multipart/form-data'])); ?>

                <?php endif; ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="first_name">Restaurant Name</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Restaurent Name'])); ?>


                                    </div>
                                </div>
                            </div>

                            <div class="form-group  <?php echo e($errors->has('location') ? 'has-error' : ''); ?>">
                                <label for="description">Location</label>
                                <?php echo e(Form::textarea('location', old('location'), ['class' => 'form-control','placeholder' => 'Location', 'rows' => 4])); ?>

                                <?php if($errors->has('location')): ?>
                                <span class="help-block"><?php echo e($errors->first('location')); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group <?php echo e($errors->has('lat') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Latitude</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::text('lat', old('lat'), ['class' => 'form-control','placeholder' => 'Restaurent Latitude'])); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group <?php echo e($errors->has('lng') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Longitude</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::text('lng', old('lng'), ['class' => 'form-control','placeholder' => 'Restaurent Longitude'])); ?>

                                    </div>
                                </div>
                            </div>



                            <div class="form-group  <?php echo e($errors->has('desciption') ? 'has-error' : ''); ?>">
                                <label for="description">Description</label>
                                <?php echo e(Form::textarea('desciption', old('desciption'), ['class' => 'form-control','placeholder' => 'Description', 'rows' => 4])); ?>

                                <?php if($errors->has('desciption')): ?>
                                <span class="help-block"><?php echo e($errors->first('desciption')); ?></span>
                                <?php endif; ?>
                            </div>






                            <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Status</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Restaurant Image</label>
                                    <div class="col-md-6">
                                        <?php echo e(Form::file('restro_picture', null, array('id' => 'image', 'class' => 'custom-file-control', 'placeholder' => ''))); ?>

                                        <?php if($errors->has('restro_picture')): ?>
                                        <span class="help-block" style="color:red;">Only jpg,png,gif image type allow</span>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Day</label>

                                    <div class="col-md-2">
                                       Select CheckBox for working Day
                                    </div>

                                    <div class="col-md-2">
                                        Morning Open Time
                                    </div>

                                    <div class="col-md-2">
                                        Morning Close Time
                                    </div>


                                    <div class="col-md-2">
                                        Evening Open Time
                                    </div>

                                    <div class="col-md-2">
                                        Evening Close Time
                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Monday</label>

                                    <div class="col-md-2">
                                        <input  name="day[]" type="checkbox" value="Monday">
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_open_time[]', null, ['class' => 'form-control timepicker24','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_close_time[]', null, ['class' => 'form-control timepicker1','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_open_time[]', null, ['class' => 'form-control timepicker2','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_close_time[]', null, ['class' => 'form-control timepicker3','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Tuesday</label>

                                    <div class="col-md-2">
                                        <input  name="day[]" type="checkbox" value="Tuesday">
                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_open_time[]', null, ['class' => 'form-control timepicker4','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_close_time[]', null, ['class' => 'form-control timepicker5','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_open_time[]', null, ['class' => 'form-control timepicker6','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_close_time[]', null, ['class' => 'form-control timepicker7','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>

                                </div>
                            </div>



                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Wednesday</label>

                                    <div class="col-md-2">
                                        <input  name="day[]" type="checkbox" value="Wednesday">
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_open_time[]', null, ['class' => 'form-control timepicker8','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_close_time[]', null, ['class' => 'form-control timepicker9','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_open_time[]', null, ['class' => 'form-control timepicker10','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_close_time[]', null, ['class' => 'form-control timepicker11','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>

                                </div>
                            </div>



                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Thursday</label>

                                    <div class="col-md-2">
                                        <input  name="day[]" type="checkbox" value="Thursday">
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_open_time[]', null, ['class' => 'form-control timepicker12','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_close_time[]', null, ['class' => 'form-control timepicker13','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_open_time[]', null, ['class' => 'form-control timepicker14','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_close_time[]', null, ['class' => 'form-control timepicker15','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Friday</label>

                                    <div class="col-md-2">
                                        <input  name="day[]" type="checkbox" value="Friday">
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_open_time[]', null, ['class' => 'form-control timepicker16','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_close_time[]', null, ['class' => 'form-control timepicker17','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_open_time[]', null, ['class' => 'form-control timepicker18','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_close_time[]', null, ['class' => 'form-control timepicker19','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-1 control-label" for="last_name">Saturday</label>

                                    <div class="col-md-2">
                                        <input  name="day[]" type="checkbox" value="Saturday">
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_open_time[]', null, ['class' => 'form-control timepicker20','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('morning_close_time[]', null, ['class' => 'form-control timepicker21','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>


                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_open_time[]', null, ['class' => 'form-control timepicker22','placeholder' => 'Open Time','autocomplete'=>'off'])); ?>

                                    </div>

                                    <div class="col-md-2">
                                        <?php echo e(Form::text('evening_close_time[]', null, ['class' => 'form-control timepicker23','placeholder' => 'Close Time','autocomplete'=>'off'])); ?>

                                    </div>

                                </div>
                            </div>











                                                        </div>
                                                </div> <!-- /.row -->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                                                <a href="<?php echo e(route('admin.restaurents.index', app('request')->query())); ?>" class="btn btn-warning btn-flat" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                                            </div>
                                            <?php echo e(Form::close()); ?>


                                        </div>
                                </div>
                            </div>
                            </section>
                            <?php $__env->stopSection(); ?>
<?php $__env->startSection('per_page_script'); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
    var i;
for (i = 1; i < 25; i++) {

    $('.timepicker'+i).timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        minTime: '10',
        maxTime: '11:00pm',
        defaultTime: '',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: false
    });

}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script>
//var address = 'new york';

 //src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1ToQq1qjQepmK-KM1UOuKUs62maV4I28&libraries=places">



 

  //Call the function with address as parameter
  //getLocation('New York');


</script>

    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>