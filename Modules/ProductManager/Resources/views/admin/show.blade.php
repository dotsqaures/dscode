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
        Manage Product Details
        <small>Here you can view Product Details</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> "Listing",'route'=> 'admin.product.index'],['label' => 'Product Details']]]) }}
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
                    <th scope="row">{{ __('SKU No') }}</th>
                    <td>

                        {{ $Product->custom_product_id }}


                    </td>
                </tr>

                <tr>
                    <th scope="row">{{ __('Category') }}</th>
                    <td>{{ $Product->category->title }}</td>
                </tr>

                <tr>
                    <th scope="row">{{ __('Quantity') }}</th>
                    <td>{{ $Product->qty }}</td>
                </tr>

                      <tr>
                    <th scope="row">{{ __('Final price') }}</th>
                    <td>${{ $Product->final_price ? $Product->final_price : __(' -- ') }}</td>
                     </tr>



                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td>{{ $Product->created_at->toFormattedDateString() }}</td>
                    </tr>

                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>    @if($Product->status == 1)
                                Active
                                @elseif($Product->status == 0)
                                In-Active
                                @else
                                In-Active
                                @endif
                         </td>
                    </tr>

                @if(isset($Product->mainphoto))


                         <tr>
                                <th scope="row"><?= __('Product Photo') ?></th>
                                <td><img src="{{ asset(Storage::url($Product->mainphoto)) }}" style="width:100px; height:100px;"/></td>
                            </tr>

                            @else

                            <tr>
                                <th scope="row"><?= __('Product Photo') ?></th>
                                <td><img src="{{ asset('img/PhoneMeeting.jpg') }}" style="width:100px; height:100px;"/></td>
                            </tr>

                         @endif

                         <tr>
                            <th scope="row"><?= __('Bar Code Label') ?></th>
                            <td><div id="printlabel">{{ 'SBR'.$Product->custom_product_id }}</div>
                            <a href="javascript:void()" class="btn btn-default pull-left" onclick="printDivLabel()">Print Label</a>
                        </td>
                        </tr>
<br/><br/>

                         <tr>
                            <th scope="row"><?= __('Bar Code') ?></th>
                            <td><div id="demo"></div>
                            <a href="javascript:void()" class="btn btn-default pull-left" onclick="printDiv()">Print Bar Code</a>
                            </td>
                         </tr>



            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="heading-label">{{ __('Description') }}</h4>
                    {!! $Product->item_description !!}
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


<style type="text/css" media="print">


    @media printlabel {
        body * {
          visibility: hidden;
        }
        #printlabel * {
          visibility: visible;
          color: white;
          font-size: 5rem;
        }

      }

      #printlabel {
        color: pink;
        background: #AAAAAA;
      }


    </style>
@stop


@section('per_page_script')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('js/jquery-barcode.js')}}" ></script>

<script>

    var barcodeval =  'SBR'+'{{ $Product->custom_product_id }}';


$("#demo").barcode(

barcodeval,// Value barcode (dependent on the type of barcode)
"code93", // type (string)

);



function printDiv(){
    var divToPrint=document.getElementById('demo');

    var newWin=window.open('','Print-Window');

    newWin.document.open();


    newWin.document.write('<html><body onload="window.print()" style="font-size:11px; font-weight:bold; color:#000000;">'+divToPrint.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},10);
}

function printDivLabel(){

    var divToPrint=document.getElementById('printlabel');

    var newWin=window.open('','Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},10);
}

</script>
@stop


