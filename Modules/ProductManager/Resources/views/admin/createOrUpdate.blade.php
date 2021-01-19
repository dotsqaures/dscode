@extends('layouts.admin.master')
@section('title', !empty($products) ? 'Edit Product' : 'Add Product')
@section('content')
@include('layouts.admin.flash.alert')


    <!-- Content Header (category header) -->

    <section class="content-header">
        <h1>
            Manage Product
            <small>Here you can {{ !empty($products) ? 'edit' : 'add' }} Product</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.product.index'],['label' => !empty($products) ? 'Edit Product' : 'Add Product' ]]]) }}
    </section>
    <section class="content" data-table="categories">
            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ !empty($products) ? 'Edit Product' : 'Add Product' }} </h3>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                        </div><!-- /.box-header -->

                @if(isset($products))
                    {{ Form::model($products, ['route' => ['admin.product.update', $products->id], 'method' => 'patch','enctype'=>'multipart/form-data']) }}
                @else
                    {{ Form::open(['route' => 'admin.product.store','enctype'=>'multipart/form-data']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="form-group required {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="category_id">Category</label>
                                    <div class="col-md-6">
                                        {{ Form::select('category_id', $categories, old("category_id"), ['class' => 'form-control']) }}
                                        @if($errors->has('category_id'))
                                        <span class="help-block">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>



                              <div class="form-group required {{ $errors->has('item_title') ? 'has-error' : '' }}">
                                <label for="title">Title</label>
                                {{ Form::text('item_title', old('title'), ['class' => 'form-control','placeholder' => 'Item Title']) }}
                                @if($errors->has('item_title'))
                                <span class="help-block">{{ $errors->first('item_title') }}</span>
                                @endif
                              </div>






                            <div class="form-group required {{ $errors->has('item_description') ? 'has-error' : '' }}">
                                <label for="description">item Description</label>
                                {{ Form::textarea('item_description', old('item_description'), ['class' => 'form-control','placeholder' => 'item Description', 'rows' => 4]) }}
                                @if($errors->has('item_description'))
                                <span class="help-block">{{ $errors->first('item_description') }}</span>
                                @endif
                            </div>






                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="control-label" for="last_name">Status</label>
                        {{ Form::select('status', [1 => 'Active', 0 => 'In-Active'], old("status"), ['class' => 'form-control']) }}
                       </div>


 </div>

                        <div class="col-md-12">
                         <div class="form-group required {{ $errors->has('qty') ? 'has-error' : '' }}">
                                <label for="title">Quantity</label>
                                {{ Form::text('qty', old('qty'), ['class' => 'form-control','placeholder' => 'Quantity']) }}
                                @if($errors->has('qty'))
                                <span class="help-block">{{ $errors->first('qty') }}</span>
                                @endif
                          </div>


               </div>



               <div class="col-md-12 adddiv">


                <div class="col-md-4">
                <div class="form-group required {{ $errors->has('wight') ? 'has-error' : '' }}">
                    <label for="title">Weight</label>
                    {{ Form::text('wight[]', null, ['class' => 'form-control','placeholder' => 'Weight']) }}
                    @if($errors->has('wight'))
                    <span class="help-block">{{ $errors->first('wight') }}</span>
                    @endif
                </div>
                </div>
                <div class="col-md-4">

                  <div class="form-group required {{ $errors->has('final_price') ? 'has-error' : '' }}">
                                <label for="title">Final price($)</label>
                                {{ Form::text('final_price[]', null, ['class' => 'form-control','placeholder' => 'Final Price']) }}
                                @if($errors->has('final_price'))
                                <span class="help-block">{{ $errors->first('final_price') }}</span>
                                @endif
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
                        <a href="{{ route('admin.product.index') }}" class="btn btn-warning btn-flat" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                    </div>
                    {{ Form::close() }}

                    </div>
                </div>
            </div>
        </section>
@stop








@section('per_page_script')


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
                            url: '{{url('admin/product/deleteimage')}}'+'/'+productImageID,
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
@stop


