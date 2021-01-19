@extends('layouts.admin.master')
@section('title','Listing')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            Manage Product
            <small>Here you can manage Products</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> 'Listing','route'=> \Request::route()->getName()]]]) }}
    </section>

    <section class="content" data-table="products">
            <div class="row products">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('All Product') }}</span></h3>
                            <div class="box-tools">
                                <a href="{{route('admin.product.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Product
                                </a>
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
                                        <th scope="col">Product Image</th>
                                        <th scope="col">SKU No.</th>
                                        <th scope="col">Product Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th>Quantity</th>
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



                       @if(!empty($product->mainphoto))

                      <a class="example-image-link" href="{{ asset(Storage::url($product->mainphoto)) }}" data-lightbox="example-2" data-title="Optional caption."><img src="{{ asset(Storage::url($product->mainphoto)) }}" alt="" style="width:70px; height: 70px;"></a>

                      @else
                        <a href="javascript:void(0)"><img src="{{ asset('img/PhoneMeeting.jpg') }}" alt="" style="width:70px; height: 70px;"></a>

                      @endif

                                            </td>
                                    <td>

                                        {{ $product->custom_product_id }}

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



                                           <td class="wrap-txt">Active </td>
                                            <td>{{ date('d/m/Y',strtotime($product->created_at)) }}</td>
                                            <td class="actions wrap-txt">
                                                <div class="form-group">
                                                    <a href="{{ route('admin.product.show',['id' => $product->id]) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                    <!--<a href="{{ route('admin.product.edit',['id' => $product->id]) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>-->
                                                    <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete {{ $product->title }}" data-url="{{ route('admin.product.destroy', $product->id) }}" data-title="{{ $product->title }}"><i class="fa fa-trash"></i></a>

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



@stop









