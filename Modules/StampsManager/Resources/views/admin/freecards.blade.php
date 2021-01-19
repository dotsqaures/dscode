@extends('layouts.admin.master')

@section('content')
@include('layouts.admin.flash.alert')

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
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.stamps.index'],['label' => !empty($restro) ? 'Edit Stamp' : 'Add Stamp' ]]]) }}
</section>
<section class="content" data-table="stamps">
    <div class="row stamps">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> </h3>

                </div><!-- /.box-header -->

                @if(isset($restro))
                @php
                $queryStr['id'] = $restro->id;
                $queryStr = array_merge( $queryStr , app('request')->query());
                @endphp
                {{ Form::model($restro, ['url' => route('admin.stamps.update', $queryStr) , 'method' => 'patch','enctype'=>'multipart/form-data']) }}
                @else
                {{ Form::open(['url' => route('admin.stamps.updatefreecard', app('request')->query()),'enctype'=>'multipart/form-data']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">




                             <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Select User</label>
                                    <div class="col-md-6">
                                            {{ Form::select('user_id', $userdata, old("user_id"), ['class' => 'form-control','required'=>true,'id'=>'select-state']) }}
                              </div></div></div>

                              <div class="form-group {{ $errors->has('charge_id') ? 'has-error' : '' }}">
                                <div class="row">
                                <label class="col-md-3 control-label" for="last_name">Select Stamp</label>
                                    <div class="col-md-6">
                                        {{ Form::select('charge_id', $stampdata , old("charge_id"), ['class' => 'form-control','required'=>true]) }}
                                </div></div></div>








                                                        </div>
                                                </div> <!-- /.row -->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>

                                            </div>
                                            {{ Form::close() }}

                                        </div>
                                </div>
                            </div>
                            </section>
                            @stop
@section('per_page_script')
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

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />


        <script>
            $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });  
        </script>

    @stop
