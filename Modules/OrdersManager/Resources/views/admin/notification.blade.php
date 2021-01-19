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
        Send Notification
        <small>Here you can manage Notification  </small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.Orders.notification'],['label' => 'Send Notitication' ]]]) }}
</section>
<section class="content" data-table="restaurents">
    <div class="row restaurents">
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
                {{ Form::model($restro, ['url' => route('admin.Orders.update', $queryStr) , 'method' => 'patch','enctype'=>'multipart/form-data']) }}
                @else
                {{ Form::open(['url' => route('admin.Orders.store', app('request')->query()),'enctype'=>'multipart/form-data']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">



                            <div class="form-group ">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="device_type">Select User</label>
                                    <div class="col-md-6">
                                        <div class="multiselect">
                                            <div class="selectBox" onclick="showCheckboxesCondition()">
                                                <select class="form-control">
                                                    <option>Select User</option>

                                                </select>
                                                <div class="overSelect"></div>
                                            </div>
                                            <div id="checkboxescondition">

                                                <label for="ss">
                                                    <input type="checkbox" id="ss" name="all" value="1">All Select</label>

                                               @foreach($Userlist as $user)
                                               <label for="$user->id">
                                                    <input type="checkbox" id="one" class="otherchk" name="user_id[]" value="{{ $user->id }}" >{{ $user->first_name }}</label>

                                                    @endforeach
                                                </div>
                                        </div> </div>
                                </div>
                            </div>






                            <div class="form-group  {{ $errors->has('desciption') ? 'has-error' : '' }}">
                                <label for="description">Message</label>
                                {{ Form::textarea('desciption', old('desciption'), ['class' => 'form-control','placeholder' => 'Description', 'rows' => 4]) }}
                                @if($errors->has('desciption'))
                                <span class="help-block">{{ $errors->first('desciption') }}</span>
                                @endif
                            </div>






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


                            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>


            $("#ss").click(function(){
                if($(this).is(":checked")) {
                    $('.otherchk').prop('checked',true);
                  }else{
                    $('.otherchk').prop('checked',false);
                  }
               });
</script>

 @stop


 <style>
    .check-btn-list input[type=checkbox], input[type=radio] {
        position: relative;
        margin: 0 2px 0 10px;
        top: 2px;
    }
    .check-btn-list .col-md-9 {
        padding-left: 5px;
    }
    .multiselect label {
        display: block !important;
        margin: 0;
        border-bottom: 1px #dadada solid;
        padding: 4px 12px;
    }
    .multiselect label input[type=checkbox] {
        position: relative;
        margin: 0 5px 0 0;
        top: 2px;
    }
    .multiselect {
        width: 200px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }





    #checkboxesnetwork {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxesnetwork label {
        display: block;
    }

    #checkboxesnetwork label:hover {
        background-color: #1e90ff;
    }

     #checkboxescondition {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxescondition label {
        display: block;
    }

    #checkboxescondition label:hover {
        background-color: #1e90ff;
    }


</style>

 <script>
 var expanded = false;
    function showCheckboxesCondition() {
        var checkboxesstorage = document.getElementById("checkboxescondition");
        if (!expanded) {
            checkboxesstorage.style.display = "block";
            expanded = true;
        } else {
            checkboxesstorage.style.display = "none";
            expanded = false;
        }
    }



 </script>









