@extends('layouts.admin.master')
@section('title','Listing  Details')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">

    <style>
            .listing-squence-outer{
                padding:0 15px;
                width: 100%;
            }
            .listing-squence {

                display: flex;
                list-style: none;
                padding-left: 0;
                flex-wrap: wrap;
                margin: 0 -15px;

            }
           .listing-squence li {

                padding: 5px;
                border: 1px solid #dddd;
                margin: 0 5px 10px;
            }
          .heading-label{
           
            font-weight: bold;
          }
    </style>

    <h1>
        Manage Listing Details
        <small>Here you can view Listing Details</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> "Listing",'route'=> 'admin.product.index'],['label' => 'Listing Details']]]) }}
</section>

<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $Product->item_title }}</h3>
            {{-- <a href="{{route('admin.product.index')}}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a> --}}
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="row">{{ __('Item Title') }}</th>
                    <td>{{ $Product->item_title }}</td>
                </tr>

                <tr>
                    <th scope="row">{{ __('IMEI/Serial Number') }}</th>
                    <td>
                        @if(!empty($Product->imei_code))
                        {{ $Product->imei_code }}
                        @else
                        {{ $Product->serial_number }}
                        @endif

                    </td>
                </tr>


                <tr>
                        <th scope="row">{{ __('Featured') }}</th>
                        <td>{{ $Product->is_feature ? __('Yes') : __('NO') }}</td>
                    </tr>


                <tr>
                    <th scope="row">{{ __('Manufacturer') }}</th>
                    <td>{{ $Product->category->title }}</td>
                </tr>

                  <tr>
                        <th scope="row">{{ __('Device Type') }}</th>
                        <td>{{ $Product->device_type }}</td>
                    </tr>

                    <?php if(!empty($Product->device_model)) { ?>
                    <tr>
                        <th scope="row">{{ __('Model Type') }}</th>
                        <?php   $modeltype = \App\Helpers\BasicHelpers::getmodeltyep($Product->device_model); ?>
                        <td>{{ $modeltype->model_name }}</td>
                    </tr>
                    <?php } ?>

                   <tr>
                        <th scope="row">{{ __('Seller Name') }}</th>
                        <td>{{ $Product->user->first_name }}</td>
                    </tr>

                    <tr>
                        <th scope="row">{{ __('Colour') }}</th>
                        <td>
                                @if(!empty( $Product->colour))
                                {{ $Product->colour }}
                              @else
                              {{ '-' }}
                              @endif
                              </td>
                    </tr>

                    <tr>
                        <th scope="row">{{ __('Storage') }}</th>
                        <td>  @if(!empty( $storageName->storage_name))
                                {{ $storageName->storage_name }}
                              @else
                              {{ '-' }}
                              @endif
                              </td>
                    </tr>


                    <tr>
                            <th scope="row">{{ __('Lowest Price Accepted') }}</th>
                            <td>{{ $Product->lowest_price ? $Product->lowest_price : __(' -- ') }}</td>
                        </tr>


                   @if(!empty($Carriername->carrier_name))
                    <tr>
                        <th scope="row">{{ __('Carrier name') }}</th>
                        <td>{{ $Carriername->carrier_name }}</td>
                    </tr>
                @endif
                    <tr>
                        <th scope="row">{{ __('Tagline') }}</th>
                        <td>{{ $Product->product_tag_one.', '.$Product->product_tag_two.', '.$Product->product_tag_three }}</td>
                    </tr>


                    <tr>
                    <th scope="row">{{ __('Selling price') }}</th>
                    <td>${{ $Product->selling_price }}</td>
                    </tr>


                    <tr>
                        <th scope="row">{{ __('Shipping Fee') }}</th>
                        <td>${{ $Product->shipping_charge ? $Product->shipping_charge : __(' -- ')  }}</td>
                        </tr>

                   <tr>
                    <th scope="row">{{ __('Admin commission') }}</th>
                    <td>${{ $Product->admin_charge ? $Product->admin_charge : __(' -- ')  }}</td>
                    </tr>


                     <tr>
                    <th scope="row">{{ __('Final price') }}</th>
                    <td>${{ $Product->final_price ? $Product->final_price : __(' -- ') }}</td>
                     </tr>



                    <tr>
                    <th scope="row">{{ __('Is Price Negotiable') }}</th>
                    <td>{{ $Product->is_price_negotiable ? __('Yes') : __('NO') }}</td>
                    </tr>




                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td>{{ $Product->created_at->toFormattedDateString() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Modified') }}</th>
                        <td>{{ $Product->updated_at->toFormattedDateString() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>    @if($Product->status == 1)
                                Approved
                                @elseif($Product->status == 2)
                                Rejected
                                @else
                                Pending
                                @endif
                         </td>
                    </tr>

                @if(isset($Product->verification_image_code))

                       <tr>
                            <th scope="row"><?= __('Image Verification Code') ?></th>
                            <td>{{ $Product->verification_image_code }}</td>
                        </tr>

                        <tr>
                                <th scope="row"><?= __('Verification Photo') ?></th>
                                <td><img src="{{ asset(Storage::url($Product->upload_verification_photo)) }}" style="width:100px; height:100px;"/></td>
                            </tr>

                      @endif



            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="heading-label">{{ __('Description') }}</h4>
                    {!! $Product->item_description !!}
                </div>
            </div>




            <div class="row">
                <div class="col-md-12">
                    @if(isset($Product->item_video))
            <video width="320" height="240" controls>
                <source src="{{ asset(Storage::url($Product->item_video)) }}" type="video/mp4">
            </video>
            @endif

            </div>
        </div>

            <div class="row">
                <div class="col-md-12">

                    <h4 class="heading-label">{{ __('Product Images') }}</h4>

 <div class="listing-squence-outer">
     <ul class="d-flex pl-0 flex-wrap listing-squence">

             @if(!empty($Product->imei_number_photo))
             <li>
                <img src="{{ asset(Storage::url($Product->imei_number_photo)) }}" style="width:100px; height:100px;"/>
            </li>
                @endif




                @if(!empty($Product->google_id_photo))
                <li>
                <img src="{{ asset(Storage::url($Product->google_id_photo)) }}" style="width:100px; height:100px;"/>
            </li>
                @endif



            @if(!empty($Product->mainphoto))
            <li>
            <img src="{{ asset(Storage::url($Product->mainphoto)) }}" style="width:100px; height:100px;"/>
           </li>
            @endif



           @if(!empty($Product->frontphoto))
           <li>
           <img src="{{ asset(Storage::url($Product->frontphoto)) }}" style="width:100px; height:100px;"/>
        </li>
           @endif


          @if(!empty($Product->backphoto))
          <li>
          <img src="{{ asset(Storage::url($Product->backphoto)) }}" style="width:100px; height:100px;"/>
        </li>
          @endif


         @if(!empty($Product->leftphoto))
         <li>
          <img src="{{ asset(Storage::url($Product->leftphoto)) }}" style="width:100px; height:100px;"/>
        </li>
          @endif


         @if(!empty($Product->rightphoto))
         <li>
         <img src="{{ asset(Storage::url($Product->rightphoto)) }}" style="width:100px; height:100px;"/>
        </li>
         @endif


        @if(!empty($Product->topphoto))
        <li>
        <img src="{{ asset(Storage::url($Product->topphoto)) }}" style="width:100px; height:100px;"/>
        </li>
        @endif


       @if(!empty($Product->bottomphoto))
       <li>
       <img src="{{ asset(Storage::url($Product->bottomphoto)) }}" style="width:100px; height:100px;"/>
    </li>
       @endif


      @if(!empty($Product->scratchphoto))
      <li>
      <img src="{{ asset(Storage::url($Product->scratchphoto)) }}" style="width:100px; height:100px;"/>
    </li>
      @endif


     @if(!empty($Product->allaccessories))
     <li>
      <img src="{{ asset(Storage::url($Product->allaccessories)) }}" style="width:100px; height:100px;"/>
    </li>
      @endif

     </ul>
 </div>









                </div>
            </div>

            <div class="row">
                    <div class="col-md-12">


                        <h4 class="heading-label">{{ __('Product Rating') }}</h4>
                        <div class="container">
                        <div class="row">

                                {{ Form::model($Product, ['route' => ['admin.product.update', $Product->id], 'method' => 'patch','enctype'=>'multipart/form-data']) }}
                                @if(!empty($Product))
                                    <input id="input-1" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $Product->star_ratting }}" data-size="xs" >
                                    @else
                                    <input id="input-1" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="" data-size="xs" >
                                    @endif
                                    <button class="btn btn-primary btn-flat strbtn" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                                {{ Form::close() }}

                            </div>
                        </div>

                    </div>
                </div>






        </div>
        <div class="box-footer">
                <a href="{{route('admin.product.index')}}" class="btn btn-default pull-left" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
    </div>
</section>



@endsection


@section('per_page_style')


<style>


            .rating-xs { font-size: 1.5em !important;}
            .strbtn { margin: 15px;}

    </style>
@stop


@section('per_page_script')


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js" type="text/javascript"></script>

@stop


