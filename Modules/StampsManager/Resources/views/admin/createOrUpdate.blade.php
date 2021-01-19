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
        Manage Stamp Card
        <small>Here you can manage stamp card </small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.stamps.index'],['label' => !empty($restro) ? 'Edit Stamp' : 'Add Stamp' ]]]) }}
</section>
<section class="content" data-table="stamps">
    <div class="row stamps">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> </h3>
                    <a href="{{ route('admin.stamps.index', app('request')->query()) }}" class="btn btn-default pull-right" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                </div><!-- /.box-header -->

                @if(isset($restro))
                @php
                $queryStr['id'] = $restro->id;
                $queryStr = array_merge( $queryStr , app('request')->query());
                @endphp
                {{ Form::model($restro, ['url' => route('admin.stamps.update', $queryStr) , 'method' => 'patch','enctype'=>'multipart/form-data']) }}
                @else
                {{ Form::open(['url' => route('admin.stamps.store', app('request')->query()),'enctype'=>'multipart/form-data']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">

                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="first_name">Title(Buy stamp cards)</label>
                                    <div class="col-md-6">
                                        {{ Form::text('title', old('title'), ['class' => 'form-control','placeholder' => 'Title']) }}

                                    </div>
                                </div>
                            </div>


                             <div class="form-group {{ $errors->has('stemp_no') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">How Many Stamps</label>
                                    <div class="col-md-6">
                                            {{ Form::select('stemp_no', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5', '6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','15'=>'15','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90','100'=>'100'], old("status"), ['class' => 'form-control']) }}
                              </div></div></div>

                              <div class="form-group {{ $errors->has('stemp_valid') ? 'has-error' : '' }}">
                                <div class="row">
                                <label class="col-md-3 control-label" for="last_name">Valid Till</label>
                                    <div class="col-md-6">
                                        {{ Form::select('stemp_valid', ['1 Months' => '1 Months', '2 Months' => '2 Months','3 Months'=>'3 Months','6 Months'=>'6 Months','12 Months'=>'12 Months','24 Months'=>'24 Months','36 Months'=>'36 Months','48 Months'=>'48 Months','60 Months'=>'60 Months'], old("status"), ['class' => 'form-control']) }}
                                </div></div></div>


                                <div class="form-group {{ $errors->has('normal_price') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="first_name">Normal Price</label>
                                        <div class="col-md-6">
                                            {{ Form::number('normal_price', old('normal_price'), ['class' => 'form-control normalprice','placeholder' => 'Normal Price']) }}

                                        </div>
                                    </div>
                                </div>



                                <div class="form-group {{ $errors->has('descoun_price') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="first_name">Discount Price</label>
                                        <div class="col-md-6">
                                            {{ Form::number('descoun_price', old('descoun_price'), ['class' => 'form-control discountprice','placeholder' => 'Discount Price',"onfocusout"=>"calculateSaving()"]) }}

                                        </div>
                                        <div class="ShowMessage"></div>
                                    </div>
                                </div>


                                <div class="form-group {{ $errors->has('saving_price') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="first_name">Saving (Kr)</label>
                                        <div class="col-md-6">
                                            {{ Form::number('saving_price', old('saving_price'), ['class' => 'form-control savingprice','placeholder' => 'Saving',"readonly"=>true]) }}

                                        </div>
                                    </div>
                                </div>



                            <div class="form-group  {{ $errors->has('short_description') ? 'has-error' : '' }}">
                                <label for="description">Short Description</label>
                                {{ Form::textarea('short_description', old('short_description'), ['class' => 'form-control','placeholder' => 'Short Description', 'rows' => 4]) }}
                                @if($errors->has('short_description'))
                                <span class="help-block">{{ $errors->first('short_description') }}</span>
                                @endif
                            </div>



                            <div class="form-group  {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">Description</label>
                                {{ Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Description', 'rows' => 4]) }}
                                @if($errors->has('description'))
                                <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>






                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Status</label>
                                    <div class="col-md-6">
                                        {{ Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Stamp Card Image</label>
                                    <div class="col-md-6">
                                        {{ Form::file('stamp_picture', null, array('id' => 'image', 'class' => 'custom-file-control', 'placeholder' => '')) }}
                                        @if($errors->has('stamp_picture'))
                                        <span class="help-block" style="color:red;">Only jpg,png,gif image type allow</span>
                                        @endif
                                    </div>

                                </div>
                            </div>













                                                        </div>
                                                </div> <!-- /.row -->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                                                <a href="{{ route('admin.stamps.index', app('request')->query()) }}" class="btn btn-warning btn-flat" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXZKrj9Z9SBgjD1E9CTk5f4d5rh0Mwvcc&libraries=places&callback=initAutocomplete"
    async defer></script>


        {{ Html::script('js/jquery.mask.js') }}

        <script>
                $(document).ready(function($){

                $(".jbsekerregis").mask("400 000 000");
                });
        </script>

    @stop
