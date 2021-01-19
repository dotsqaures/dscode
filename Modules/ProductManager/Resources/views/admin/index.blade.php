@extends('layouts.admin.master')
@section('title','Listing')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            Manage Listings
            <small>Here you can manage Listings</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> 'Listing','route'=> \Request::route()->getName()]]]) }}
    </section>

    <section class="content" data-table="products">
            <div class="row products">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('All Listings') }}</span></h3>
                            <div class="box-tools">
                                <!--<a href="{{route('admin.product.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Listing
                                </a>-->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">

                                {{ Form::open(['url' => route('admin.product.index'),'method' => 'get']) }}
                                <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                            {{ Form::select('category_id', $categories, app('request')->query('category_id'), ['class' => 'form-control']) }}
                                    </div>
                                    <div class="col-md-2 form-group">
                                            {{ Form::select('status', ['' => 'All',1 => 'Approved', 2 => 'Rejected',0=>'Pending'], app('request')->query('status'), ['class' => 'form-control']) }}
                                        </div>
                                    <div class="col-md-5 form-group">
                                        {{ Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: Product name, Description, Phone Conditions']) }}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                                        <a href="{{ route('admin.product.index') }}" class="btn btn-warning" title="Cancel"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}

                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">IMEI/Serial Image</th>
                                        <th scope="col">IMEI/Serial Code</th>
                                        <th scope="col">Product Title</th>
                                        <th scope="col">Manufacturer</th>
                                        <th scope="col">Seller Name</th>

                                        <th scope="col">Final price</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" width="18%">Created</th>
                                        <th scope="col" class="actions" width="12%">Actions</th>
                                    </tr>
                                </thead>
                                        @if($products->count()>0)
                                        <tbody>
                                    @php
                                    $i = (($products->currentPage() - 1) * ($products->perPage()) + 1)
                                    @endphp
                                    @foreach($products as $product)

                                        <tr class="row-{{ $product->id }}">
                                            <td> {{$i}}. </td>

                                            <td>



                       @if(!empty($product->imei_number_photo))

                      <a class="example-image-link" href="{{ asset(Storage::url($product->imei_number_photo)) }}" data-lightbox="example-2" data-title="Optional caption."><img src="{{ asset(Storage::url($product->imei_number_photo)) }}" alt="" style="width:70px; height: 70px;"></a>

                      @else
                        <a href="javascript:void(0)"><img src="{{ asset('img/PhoneMeeting.jpg') }}" alt="" style="width:70px; height: 70px;"></a>

                      @endif

                                            </td>
                                            <td>
                                                @if(!empty($product->imei_code))
                                                {{$product->imei_code}}
                                                @else
                                                {{ $product->serial_number }}
                                                @endif
                                            </td>
                                            <td>{{$product->item_title}}</td>
                                            <td>{{$product->category->title}}</td>
                                            <td>
                                                @if(isset($product->user->first_name))
                                                {{ $product->user->first_name }}
                                                @else
                                                {{ '--' }}
                                                @endif

                                            </td>

                                            <td>${{$product->final_price}}</td>
 <td>
        <input id="input-1" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $product->star_ratting }}" data-size="xs" disabled="">
 </td>


 <td class="wrap-txt">

                                            @if($product->status == 1)
                                            <a href="javascript:void(0)" class="" data-toggle="tooltip" alt="View setting" title="" data-original-title="Approved" style="color:#069220f2; font-weight:bold">Approved</i></a>
                                            <a href="{{ route('admin.product.reject',['id' => $product->id]) }}" class="btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="Reject">Reject</i></a>
                                            @elseif($product->status == 2)
                                            <a href="javascript:void(0)" class="" data-toggle="tooltip" alt="View setting" title="" data-original-title="Rejected" style="color:#c60f09; font-weight:bold">Rejected</i></a>
                                            <a href="{{ route('admin.product.accept',['id' => $product->id]) }}" class="btn btn-warning btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="Approve">Approve</i></a>


                                            @else
                                            <a href="{{ route('admin.product.accept',['id' => $product->id]) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="Approve">Approve</i></a>
                                            <a href="{{ route('admin.product.reject',['id' => $product->id]) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="Reject">Reject</i></a>

                                              @endif


                                            </td>
                                            <td>{{ date('d/m/Y',strtotime($product->created_at)) }}</td>
                                            <td class="actions wrap-txt">
                                                <div class="form-group">
                                                    <a href="{{ route('admin.product.show',['id' => $product->id]) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                    <!--<a href="{{ route('admin.product.edit',['id' => $product->id]) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>-->
                                                    <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete {{ $product->title }}" data-url="{{ route('admin.product.destroy', $product->id) }}" data-title="{{ $product->title }}"><i class="fa fa-trash"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btn-flat"  alt="" title="Send notification to seller" data-original-title="Send notification to seller" onClick="openModel('{{ $product->id }}','{{ $product->user_id }}');"><i class="fa fa-bell"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                    </tbody>
                                    @else
                                    <tfoot>
                                        <tr>
                                            <td colspan='7' align='center'> <strong>Record Not Available</strong> </td>
                                        </tr>
                                    </tfoot>
                                    @endif
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $products->appends(Request::query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop

@section('per_page_style')


<style>
    .wrap-txt{
        white-space: nowrap;
    }
        .btn-success, .btn-warning {

            padding: 4px 12px !important}

            .rating-container .clear-rating{display:none !important}
            .rating-container .caption{display:none !important}
            .rating-xs { font-size: 1.5em !important;}

    </style>
@stop

<div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Send Email Notification to Seller regarding this product. </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>



      {{ Form::open(['route' => 'admin.product.sentnotitifytoseller','enctype'=>'multipart/form-data','id'=>'comment']) }}

            <div class="modal-body">
                <div id="showerrormessage" ></div>

                    <div class="form-group required">
                    <label for="exampleFormControlTextarea1">Message</label>
                    <textarea  class="form-control rounded-0" id="exampleFormControlTextarea1" rows="6" name="message" pattern="^\S+$" required></textarea>
                    </div>

                    <input type="hidden" name="productid" class="productid">
                    <input type="hidden" name="userid" class="userid">



            </div>
            <div class="modal-footer">
                    <button class="btn btn-primary btn-flat" title="Submit" type="button" id='submitBtn'><i class="fa fa-fw fa-save"></i> Submit</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
            </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>

@section('per_page_script')

<script>
        function openModel(productid,sellerid)
        {
            $(".productid").val(productid);
            $(".userid").val(sellerid);
            $('#myModal').modal('show');

        }


        $("#submitBtn").click(function(){
            var txt = $('#exampleFormControlTextarea1').val();
            var len =txt.trim().length;
            if (len < 1)
            {
             $("#showerrormessage").html('<p style="color:red">Please enter data in message field.</p>');
            }else{

            $("#comment").submit(); // Submit the form
            }

        });


    </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js" type="text/javascript"></script>

<!--<link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">

<script src="{{asset('js/lightbox-plus-jquery.min.js')}}"></script>-->

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

@stop






