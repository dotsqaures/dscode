@extends('layouts.inner_home')
@section('title','Add a Listing ')
@section('content')

@php
$login = Auth::user();

$adminChangre = '5';
$length = 8;
$token = "";
$codeAlphabet = "ABCDEFM0123456789";
$codeAlphabet.= "0123456QRSTUVWXYZ";
$max = strlen($codeAlphabet); // edited
for ($i=0; $i < $length; $i++) {
$token .= $codeAlphabet[random_int(0, $max-1)];
}

@endphp


<div class="middle-wrapper ">
    <div class="container">
        <div class="pad-t40 pad-b40">
            <div class="d-flex align-items-center justify-content-between title-heading">
                <div class="heading">
                    <h1>Add <span>a Listing</span></h1>
                </div>

            </div>


            <div class="product-lists mrg-t20">
                <div class="row">

                    <div class="col-sm-12">
                        <a class="product-search dekstop-tab-hide" href="javascript:void(0)" onClick="expandfullscreenmenu('open')">
                            <i class="fas fa-bars"></i>Menus </a>
                    </div>

                    <div class="col-md-4 product-category-col ">
                        <input type="checkbox" id="togglebox" class="togglebox dekstop-tab-hide" />
                        <nav id="expand-fullpagemenu">

                            <label for="togglebox" id="closex" class="toggleclose dekstop-tab-hide">Close</label>

                            <div class="product-category-box shad my-product-col">

                                @include('layouts.sidebar')


                            </div>

                        </nav>

                    </div>

                    <div class="col-md-8 product-showcase grid-view-product my-product-lists  my-account-inner">

                        <?php
                        if (isset($products)) {
                            $values = false;
                        } else {
                            $values = true;
                        }
                        ?>
                        <div class="add-product-page sell-device-box  shad add-spacing add-mst-dst">
                            <h2>Sell your device for more</h2>
                            <p>It's free to sell | Sell directly to users without a middleman | Secured transactions</p>

                            <div class="sell-inner-box">
                                <div class="sell-inner-list">
                                    <div class="img-sec">
                                         <img src="{{ asset('img/add-list1.png') }}" alt="">
                                    
                                    </div>
                                    <div class="sell-text-box">
                                        <h3>Add a listing</h3>
                                        <p>List your device for sale below</p>
                                    </div>
                                </div>     
                                <div class="sell-inner-list">
                                    <div class="img-sec">  <img src="{{ asset('img/add-list2.png') }}" alt=""></div>
                                    <div class="sell-text-box">
                                        <h3>Add Payment details</h3>
                                        <p>Upadte payment details so you can receive payment in your account</p>
                                    </div>
                                </div>     
                                <div class="sell-inner-list">
                                    <div class="img-sec"> <img src="{{ asset('img/add-list3.png') }}" alt=""></div>
                                    <div class="sell-text-box">
                                        <h3>Hear from buyers</h3>
                                        <p>Once your listing is approved, buyers will view and respond and may make an offer</p>
                                    </div>
                                </div>     
                                <div class="sell-inner-list">
                                    <div class="img-sec"> <img src="{{ asset('img/add-list4.png') }}" alt=""></div>
                                    <div class="sell-text-box">
                                        <h3>Wrap it up</h3>
                                        <p>Buyer pays for your device via <a href="{{ url('pages/faq') }} ">Stripe.</a>
                                            Mail your device to the buyer's  address. </p>
                                    </div>
                                </div>     
                                <div class="sell-inner-list">
                                    <div class="img-sec">  <img src="{{ asset('img/add-list5.png') }}" alt=""></div>
                                    <div class="sell-text-box">
                                        <h3>Add a listing</h3>
                                        <p>Get paid as soon as the buyer receive the device</p>
                                    </div>
                                </div>     
                            </div>

                        </div>

                     
                        <div class="add-product-page shad add-spacing add-mst-dst">

                            <div class="chk-link flex-wrap flex-md-nowrap">
                                <div class="pr-3">
                                    <div class="junk-box">
                                         <img src="{{ asset('img/no-stopping.svg') }}" alt="" width="30" height="30" alt="">
                                         No junk policy
                                    </div>
                                    We only allow fully working devices to be sold on our platform. If you are selling a broken mobile phone, you can sell it here.
                                </div>
                                <a class="btn blue-btn sell-btn my-3" href="http://sellmybrokenphone.com.au/" target="_blank">Sell my broken Phone</a>
                            </div>
                        </div>

                        <div class="add-product-page shad add-spacing">


                            @if(isset($products))
                            {{ Form::model($products, ['url' => ['editnewProduct', $products->id], 'method' => 'patch','enctype'=>'multipart/form-data','id'=>'frmvalidatex','name'=>'frm']) }}
                            @else
                            {{ Form::open(['url' => 'addnewProduct','enctype'=>'multipart/form-data','id'=>'frmvalidatex','name'=>'frm']) }}

                            @endif


                            <div class="row">

                                <div class="col-sm-12 mb-md-4 inner-main-title">

                                    @if(isset($products))
                                    Edit a Listing
                                    @else
                                    Add a Listing
                                    @endif

                                </div>



                                <div class="col-sm-6">
                                    <div class="search-col">
                                        <label class="" for="category_id">Device</label>
                                        {{ Form::select('device_type', $Devices, old("device_type"), ['class' => 'form-control','id'=>'devicetype']) }}
                                        @if($errors->has('device_type'))
                                        <span class="help-block">{{ $errors->first('device_type') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="col-sm-6">
                                    <div class="search-col required {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                        <label class="" for="category_id">Brand</label>
                                        {{ Form::select('category_id', $categories, old("category_id"), ['class' => 'form-control devicemenufacturer',   'disabled' => $values]) }}
                                        @if($errors->has('category_id'))
                                        <span class="help-block">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="search-col required {{ $errors->has('device_model') ? 'has-error' : '' }}">
                                        <label class="" for="category_id">Model</label>
                                        <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg" style="display:none;">
                                        <div class="devicemodels">
                                            <select class="form-control devicemdelss" name="device_model"  {{ (isset($products)) ? '' : 'disabled' }}>
                                                <option value="">Select Model</option>
                                                @if(isset($products))
                                                @foreach($DevicesModel as $item)
                                                <option value="{{$item['id']}}" @if(!empty($products->device_model == $item['id'])) {{ 'selected' }} @else {{ '' }} @endif>{{$item['model_name']}}</option>
                                                @endforeach
                                                @else
                                                @foreach($DevicesModel as $item)
                                                <option value="{{$item['id']}}">{{$item['model_name']}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        @if($errors->has('device_model'))
                                        <span class="help-block">{{ $errors->first('device_model') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="search-col required {{ $errors->has('colour') ? 'has-error' : '' }}">
                                        <label class="" for="category_id">Colour</label>
                                        {{ Form::select('colour', $colors, old("colour"), ['class' => 'form-control showcolour','disabled' =>$values]) }}
                                        @if($errors->has('colour'))
                                        <span class="help-block">{{ $errors->first('colour') }}</span>
                                        @endif
                                    </div>



                                </div>




                                <div class="col-sm-6">
                                    <div class="search-col info-icon required {{ $errors->has('storage') ? 'has-error' : '' }}">
                                        <label class="" for="storage">Storage</label>
                                        {{ Form::select('storage', $storage, old("storage"), ['class' => 'form-control showstorage','disabled' =>$values]) }}
                                        @if($errors->has('storage'))
                                        <span class="help-block">{{ $errors->first('storage') }}</span>
                                        @endif
                                        <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title='To check the storage of your device:Apple Devices: Settings > General > About > Capacity
                                           Android: Settings >  Search "Storage"
                                           Other Devices: Settings > Search "Storage".'><i class="far fa-question-circle"></i></a>

                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="search-col required {{ $errors->has('carrier_id') ? 'has-error' : '' }}">
                                        <label class="" for="carrier_id">Carrier</label>
                                        {{ Form::select('carrier_id', $Carriers, old("carrier_id"), ['class' => 'form-control showcarrier']) }}
                                        @if($errors->has('carrier_id'))
                                        <span class="help-block">{{ $errors->first('carrier_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-4 imeicodes">
                                    <div class="search-col info-icon required {{ $errors->has('imei_code') ? 'has-error' : '' }}">
                                        <label for="title">IMEI</label>
                                        {{ Form::text('imei_code', old('title'), ['class' => 'form-control imeinumber','placeholder' => 'IMEI XXXXX XXXXX XXXXX','onfocusout'=>'MakeTitleDynamic()','disabled' =>$values]) }}
                                        @if($errors->has('imei_code'))
                                        <span class="help-block">{{ $errors->first('imei_code') }}</span>
                                        @endif
                                        <div class="showimieserialexits"></div>
                                        <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderserialnumber" style="display:none;">
                                        <p style="font-size:12px;padding:0px"><strong></strong> Dial *#06# on your phone's keypad to see the IMEI number.</p>
                                        <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="IMEI is a 15-digit number unique to your device."><i class="far fa-question-circle"></i></a>
                                    </div>

                                </div>


                                <div class="col-sm-4 serialnumber" style="display:none;">
                                    <div class="search-col info-icon required {{ $errors->has('serial_number') ? 'has-error' : '' }}">
                                        <label for="title">SERIAL Number</label>
                                        {{ Form::text('serial_number', old('serial_number'), ['class' => 'form-control serailnumbertxt', 'id'=>'serailnumbertxtid','placeholder' => 'Serial Number','onfocusout'=>'MakeTitleDynamicSerialNumber()','disabled' =>$values,'maxlength'=>'11']) }}
                                        @if($errors->has('serial_number'))
                                        <span class="help-block">{{ $errors->first('serial_number') }}</span>
                                        @endif
                                        <div class="showserialexits"></div>
                                        <p style="font-size:12px;padding:0px"><strong>Note: </strong>123ABC1234</p>
                                        <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="Serial Number"><i class="far fa-question-circle"></i></a>
                                    </div>

                                </div>

                                <div class="col-sm-8">
                                    <div class="search-col required {{ $errors->has('item_title') ? 'has-error' : '' }}">
                                        <label for="title">Title</label>
                                        {{ Form::text('item_title', old('title'), ['class' => 'form-control dynamic-title','placeholder' => 'Listing Title','readonly' =>true]) }}
                                        @if($errors->has('item_title'))
                                        <span class="help-block">{{ $errors->first('item_title') }}</span>
                                        @endif

                                    </div>

                                </div>



                                <div class="col-sm-12">

                                    <p style="font-weight:600;font-size:14px;text-transform: uppercase; padding-bottom: 6px;">Listing Taglines</p>
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="search-col pb-1 pb-sm-0">
                                                <div class="search-col {{ $errors->has('product_tag_one') ? 'has-error' : '' }}" style="padding-bottom: 5px;">

                                                    {{ Form::text('product_tag_one',  old("product_tag_one"), ['class' => 'form-control' ,'id'=>'headlineone','placeholder' => 'Tagline 1']) }}

                                                    @if($errors->has('product_tag_one'))
                                                    <span class="help-block">{{ $errors->first('product_tag_one') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="search-col pb-1 pb-sm-0">
                                                <div class="search-col {{ $errors->has('product_tag_two') ? 'has-error' : '' }}" style="padding-bottom: 5px;">

                                                    {{ Form::text('product_tag_two',  old("product_tag_two"), ['class' => 'form-control' ,'id'=>'headlinetwo','placeholder' => 'Tagline 2']) }}
                                                    @if($errors->has('product_tag_two'))
                                                    <span class="help-block">{{ $errors->first('product_tag_two') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="search-col pb-1 pb-sm-0">
                                                <div class="search-col {{ $errors->has('product_tag_three') ? 'has-error' : '' }}" style="padding-bottom: 5px;">

                                                    {{ Form::text('product_tag_three',  old("product_tag_three"), ['class' => 'form-control' ,'id'=>'headlinethree','placeholder' => 'Tagline 3']) }}
                                                    @if($errors->has('product_tag_three'))
                                                    <span class="help-block">{{ $errors->first('product_tag_three') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <p>Taglines will enhance the sellability of your device. Please select three taglines that best suit your device.</p>


                                </div>

                                <?php
                                if (isset($products)) {
                                    if (!empty($products->item_description)) {
                                        ?>

                                        <div class="col-sm-12">
                                            <div class="search-col required {{ $errors->has('item_description') ? 'has-error' : '' }}">
                                                <label for="description">Description</label>
                                                {{ Form::textarea('item_description', old('item_description'), ['class' => 'form-control','placeholder' => 'item Description', 'rows' => 4]) }}
                                                @if($errors->has('item_description'))
                                                <span class="help-block">{{ $errors->first('item_description') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    <?php } else { ?>



                                    <?php
                                    }
                                } else {
                                    ?>

                                    <div class="col-sm-12">
                                        <div class="search-col required {{ $errors->has('item_description') ? 'has-error' : '' }}">
                                            <label for="description">Description</label>
                                            {{ Form::textarea('item_description', old('item_description'), ['class' => 'form-control','placeholder' => 'Example: Selling my Apple iPhone X 64GB. Phone is in a good condition. It has a few scratches on the back but functions perfectly. Comes with all accessories.', 'rows' => 4]) }}
                                            @if($errors->has('item_description'))
                                            <span class="help-block">{{ $errors->first('item_description') }}</span>
                                            @endif
                                        </div>
                                    </div>
<?php } ?>



                                <div class="col-sm-12">
                                    <div class="row add-pro-price">
                                        <div class="col-md-12 col-lg-3">

                                            <div class="search-col plus-icon required {{ $errors->has('selling_price') ? 'has-error' : '' }}">
                                                <label for="title">My selling price ($)</label>
                                                {{ Form::number('selling_price', old('selling_price'), ['class' => 'form-control','id'=>'sellingprice','placeholder' => 'Selling Price','onfocusout'=>"calculatetotalprice()","min"=>'1']) }}
                                                @if($errors->has('selling_price'))
                                                <span class="help-block">{{ $errors->first('selling_price') }}</span>
                                                @endif
                                                <div class="showvalidationmessage"></div>
                                                <p>Currently your device is worth $XXX - $XXX. Recently sold for $XXX.</p>

                                            </div>


                                        </div>
                                        <div class="col-md-12 col-lg-3">

                                            <div class=" search-col info-icon-inner plus-icon {{ $errors->has('shipping_charge') ? 'has-error' : '' }}">
                                                <label class="" for="last_name">Shipping Fee ($)</label>
                                                {{ Form::number('shipping_charge',  old("shipping_charge"), ['class' => 'form-control','id'=>'shippngchargedit','onfocusout'=>"newtotalprice()","min"=>'1']) }}
                                                <div class="shipingeditfiled"></div>
                                                <p>See shipping <a href="https://auspost.com.au/sending/send-within-australia/parcel-post" target="_blank">fees.</a></p>
                                                <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="Average postage fee including packaging  is $10-15. It is mandatory to ship devices with a tracking number. It is recommended to add extra cover (~$2.50-5)."><i class="far fa-question-circle"></i></a>
                                            </div>

                                        </div>

                                        <div class="col-md-12 col-lg-3">

                                            <div class="search-col {{ $errors->has('admin_charge') ? 'has-error' : '' }}">
                                                <label class="" for="last_name">SELLBUYDEVICE Fee ($)</label>
                                                {{ Form::text('admin_charge',  old("admin_charge"), ['class' => 'form-control' ,'id'=>'adminCharge','readonly'=>true]) }}

                                                <p>Paid by the buyer.</p>
                                                <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="Sellers do not pay fees to SellBuyDevice. This auto-calculated fee is paid by buyer to SellBuyDevice."><i class="far fa-question-circle"></i></a>


                                            </div>


                                        </div>

                                        <div class="col-md-12 col-lg-3">
                                            <div class="search-col equal-icon {{ $errors->has('final_price') ? 'has-error' : '' }}">
                                                <label class="" for="last_name">Total Price ($) </label>
                                                {{ Form::text('final_price',  old("final_price"), ['class' => 'form-control','id'=>'finalprice','readonly'=>true]) }}
                                                <p>Total price paid by the buyer.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>



                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="search-col info-icon {{ $errors->has('is_price_negotiable') ? 'has-error' : '' }}">
                                        <label class="" for="last_name">Is the Price Negotiable? 
                                        </label>
                                        {{ Form::select('is_price_negotiable', [1 => 'Yes', 0 => 'No'], old("is_price_negotiable"), ['class' => 'form-control']) }}
                                        <div class="showlowesrmessage"></div>
                                        <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="By selecting yes, you allow a buyer to make an offer to negotiate the price."><i class="far fa-question-circle"></i></a>

                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="search-col info-icon {{ $errors->has('lowest_price') ? 'has-error' : '' }}">
                                        <label class="" for="last_name">Lowest Price Accepted ($)</label>
                                        {{ Form::number('lowest_price', old("lowest_price"), ['class' => 'form-control lowesprice','onfocusout'=>'checklowestprice()',]) }}
                                        <div class="showlowesrmessage"></div>
                                        <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="If your price is negotiable, please enter the lowest price you are willing to accept. If an offer is made by a potential buyer below this price, we will automatically reject it for you. Please note: The lowest price will not be displayed to potential buyers."><i class="far fa-question-circle"></i></a>
                                    </div>

                                </div>

                                @if(isset($products))
                                @if(!empty($products->broken_device_id))
                                <div class="col-sm-12">
                                    @else
                                    <div class="col-sm-12" style="display:none;">
                                        @endif
                                        @else
                                        <div class="col-sm-12 showtestyourdivice" style="display:none;">
                                            @endif
                                            <label>Test Your Device (Ensure there no abnormalities in the following functions )</label>
                                            <div class="brokendevices">
                                                <ul class="chk-custom d-flex flex-wrap justify-content-between  flex-wrap chk-box-list">

                                                    @if(isset($products))


                                                    @if(!empty($products->broken_device_id))

                                                    @foreach($brokendevices as $broken)

                                                    @if(in_array($broken->id, unserialize($products->broken_device_id)))
                                                    <li>
                                                        <div class="chk">
                                                            <input type="checkbox" id="{{ $broken->id }}" value="{{ $broken->id }}" name="broken_device_id[]" checked>
                                                            <label for="{{ $broken->id }}"></label>
                                                        </div>
                                                        <p>{{ $broken->broken_title }}</p>
                                                    </li>
                                                    @else 

                                                    <li>
                                                        <div class="chk">
                                                            <input type="checkbox" id="{{ $broken->id }}" value="{{ $broken->id }}" name="broken_device_id[]">
                                                            <label for="{{ $broken->id }}"></label>
                                                        </div>
                                                        <p>{{ $broken->broken_title }}</p>
                                                    </li>

                                                    @endif



                                                    @endforeach

                                                    @else

                                                    @foreach($brokendevices as $broken)
                                                    <li>
                                                        <div class="chk">
                                                            <input type="checkbox" id="{{ $broken->id }}" value="{{ $broken->id }}" name="broken_device_id[]">
                                                            <label for="{{ $broken->id }}"></label>
                                                        </div>
                                                        <p>{{ $broken->broken_title }}</p>
                                                    </li>
                                                    @endforeach

                                                    @endif




                                                    @else


                                                    @foreach($brokendevices as $broken)



                                                    <!--<li>
                                                        <div class="chk">
                                                                <input type="checkbox" id="{{ $broken->id }}" value="{{ $broken->id }}" name="broken_device_id[]">
                                                                <label for="{{ $broken->id }}"></label>
                                                         </div>
                                                         <p>{{ $broken->broken_title }}</p>
                                                    </li>-->
                                                    @endforeach

                                                    @endif

                                                </ul>
                                            </div>

                                            @if($errors->has('broken_device_id'))
                                            <span class="help-block" style="color:#ff2000;font-size:12px;">Please check test your device.</span>
                                            @endif
                                        </div>

                                        <div class="col-sm-12">
                                            <div class=" d-flex flex-wrap align-items-center chk-link if-text">
                                                <p class="pr-3 pt-0">If your mobile phone does not satisfy the above criteria, you can sell it here.</p><a class="btn blue-btn sell-btn my-2" href="http://sellmybrokenphone.com.au/" target="_blank">Sell my broken Phone</a>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">

                                            <div class="inner-des height-auto">
                                                <ul>
                                                    <li>Payment will be sent via <a href="https://stripe.com/au">Stripe</a> to Seller's bank account.</li>
                                                    <li>Stripe will charge their <a href="https://stripe.com/au/pricing">fees</a> in accordance with their policies.</li>
                                                </ul>
                                            </div>

                                        </div>

                                        <div class="col-sm-12">
                                            <div class="chk-custom d-flex chk-box-list {{ $errors->has('termcondition') ? 'has-error' : '' }}">
                                                <div class="chk">

                                                    @if(isset($products))

                                                    @if($products->termcondition == '1')
                                                    <input type="checkbox" id="termcondition" name="termcondition" value="1" checked>
                                                    <label for="termcondition"></label>

                                                    @else

                                                    <input type="checkbox" id="termcondition" name="termcondition" value="1">
                                                    <label for="termcondition"></label>

                                                    @endif


                                                    @else

                                                    <input type="checkbox" id="termcondition" name="termcondition" value="1">
                                                    <label for="termcondition"></label>

                                                    @endif


                                                </div>

                                                <p>I declare that all the information I have provided is true and correct.</p>
                                                <div class="error termcondition-error" for="termcondition" style="color:red">Please accept the declaration.</div>
                                                @if($errors->has('termcondition'))
                                                <span class="help-block">Please accept declaration.</span>
                                                @endif

                                            </div>
                                        </div>






                                    </div>





                                    <input type="hidden" name="status" value="0">

                                    <input type="hidden" name="user_id" value="{{ $login->id }}"/>



                                    <div class="d-flex justify-content-center  align-items-center form-bottm">


                                        <div class="register-btn">
                                            <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="frmsubmitloader" style="display:none;">

                                            <input class="submit btn blue-btn" type="submit" value="Next">


                                        </div>

                                        </form>




                                    </div>



                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>






        @include('includes.footer')
        @endsection



        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script>

                            $(function() {
                            $('select[name=device_model]').change(function() {

                            $(".imeinumber").val('');
                            $(".dynamic-title").val('');
                            $(".serailnumbertxt").val('');
                            });
                            $('select[name=colour]').change(function() {

                            $(".imeinumber").val('');
                            $(".dynamic-title").val('');
                            $(".serailnumbertxt").val('');
                            });
                            $('select[name=storage]').change(function() {
                            $(".imeinumber").val('');
                            $(".dynamic-title").val('');
                            $(".serailnumbertxt").val('');
                            });
                            $('select[name=carrier_id]').change(function() {
                            $(".imeinumber").val('');
                            $(".dynamic-title").val('');
                            $(".serailnumbertxt").val('');
                            });
                            });
                            function checklowestprice()
                            {
                            var lowestprice = $('.lowesprice').val();
                            var finaslprice = $('#finalprice').val();
                            if (parseInt(lowestprice) > parseInt(finaslprice)){
                            $('.lowesprice').val('');
                            $(".showlowesrmessage").html("<p style='color:red'>Lowest price should be less than to total price.</p>");
                            setTimeout(function(){  $(".showlowesrmessage").html(''); }, 5000);
                            return false;
                            }

                            }

                            $(function() {
                            $('select[name=device_type]').change(function() {
                            var selectedval = this.value;
                            $(".imeinumber").val('');
                            $(".dynamic-title").val('');
                            $(".serailnumbertxt").val('');
                            if (selectedval == 'iPhones' || selectedval == 'Phones')
                            {
                            $(".serialnumber").hide();
                            $('.imeinumber').attr('disabled', false);
                            $(".imeicodes").show();
                            } else{

                            $(".serialnumber").show();
                            $('.serailnumbertxt').attr('disabled', false);
                            $(".imeicodes").hide();
                            }

                            if (selectedval == ''){

                            } else{
                            $(".showloaderimg").show();
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('selectmenufacturer')}}' + '/' + selectedval,
                                    type: 'GET',
                                    dataType: 'html',
                                    data: {

                                    "id": selectedval // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {

                                    $('.devicemenufacturer').attr('disabled', false);
                                    $(".showloaderimg").hide();
                                    $(".devicemenufacturer").html(json);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('selectbrokendevice')}}' + '/' + selectedval,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {

                                    "id": selectedval // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {
                                    if (json.status == true){
                                    $(".showtestyourdivice").show();
                                    $(".brokendevices").html(json.message);
                                    } else{
                                    $(".showtestyourdivice").hide();
                                    }

                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            }

                            });
                            });
                            $(function() {
                            $('select[name=category_id]').change(function() {
                            var selectedval = this.value;
                            if (selectedval == '' || selectedval == 'null')
                            {
                            return false;
                            }
                            else{

                            $(".showloaderimg").show();
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('selectmodel')}}' + '/' + selectedval,
                                    type: 'GET',
                                    dataType: 'html',
                                    data: {

                                    "id": selectedval // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {

                                    $('.devicemodels').attr('disabled', false);
                                    $(".showloaderimg").hide();
                                    $(".devicemodels").html(json);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            }


                            });
                            });
                            function getColourStorage(id)
                            {

                            var selectedval = id.value;
                            if (selectedval == ''){

                            } else{
                            $(".showloaderimg").show();
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('selectcolor')}}' + '/' + selectedval,
                                    type: 'GET',
                                    dataType: 'html',
                                    data: {

                                    "id": selectedval // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {

                                    $('.showcolour').attr('disabled', false);
                                    $(".showloaderimg").hide();
                                    $(".showcolour").html(json);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('selectstorage')}}' + '/' + selectedval,
                                    type: 'GET',
                                    dataType: 'html',
                                    data: {

                                    "id": selectedval // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {

                                    $('.showstorage').attr('disabled', false);
                                    $(".showloaderimg").hide();
                                    $(".showstorage").html(json);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            }


                            }




                            function MakeTitleDynamic()
                            {
                            $(".dynamic-title").val('');
                            var deviceType = $("#devicetype").val();
                            var brandType = $(".devicemenufacturer option:selected").text();
                            var ModelType = $(".devieModel option:selected").text();
                            var ColorType = $(".showcolour option:selected").text();
                            var StorageType = $(".showstorage option:selected").text();
                            var CarrierType = $(".showcarrier option:selected").text();
                            var imeinumber = $(".imeinumber").val();
                            if (imeinumber != ''){
                            $(".showloaderserialnumber").show();
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('checkimeinumber')}}' + '/' + imeinumber,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {

                                    "id": imeinumber // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {
                                    $(".showloaderserialnumber").hide();
                                    if (json.status == false)
                                    {
                                    $(".showimieserialexits").html("<p style='color:red'>" + json.message + "</p>");
                                    setTimeout(function(){  $(".showimieserialexits").html(''); }, 5000);
                                    return false;
                                    } else{

                                    var Imei7character = imeinumber.substr( - 8);
                                    var imeicodestitle = Imei7character.replace(/\s/g, '');
                                    if (ColorType == 'No Record found.' || ColorType == 'Select Colour'){
                                    ColorType = '';
                                    }
                                    if (StorageType == 'No Record found.' || StorageType == 'Select Storage'){
                                    StorageType = '';
                                    }

                                    if (CarrierType == 'No Record found.' || CarrierType == 'Select Carrier'){
                                    CarrierType = '';
                                    }

                                    if (brandType == 'No Record found.' || brandType == 'Select Brand'){
                                    brandType = '';
                                    }
                                    var DynamicTitle = brandType + ' ' + deviceType + ' ' + ModelType + ' ' + StorageType + ' ' + ColorType + ' ' + CarrierType + ' ' + imeicodestitle;
                                    $(".dynamic-title").val(DynamicTitle);
                                    }

                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            } else{

                            $(".showimieserialexits").html("<p style='color:red'>IMEI number is required.</p>");
                            setTimeout(function(){  $(".showimieserialexits").html(''); }, 1000);
                            return false;
                            }

                            }

                            function MakeTitleDynamicSerialNumber()
                            {
                            $(".dynamic-title").val('');
                            var deviceType = $("#devicetype").val();
                            var brandType = $(".devicemenufacturer option:selected").text();
                            var ModelType = $(".devieModel option:selected").text();
                            var ColorType = $(".showcolour option:selected").text();
                            var StorageType = $(".showstorage option:selected").text();
                            var CarrierType = $(".showcarrier option:selected").text();
                            var serialnumber = $(".serailnumbertxt").val();
                            if (serialnumber != ''){
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('checkserialnumber')}}' + '/' + serialnumber,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {

                                    "id": serialnumber // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {
                                    $(".showloaderserialnumber").hide();
                                    if (json.status == false)
                                    {
                                    $(".showserialexits").html("<p style='color:red'>" + json.message + "</p>");
                                    setTimeout(function(){  $(".showserialexits").html(''); }, 2000);
                                    return false;
                                    } else{

                                    var serialnumbertxt = serialnumber.substr( - 8);
                                    var serialnumbertitle = serialnumbertxt.replace(/\s/g, '');
                                    if (ColorType == 'No Record found.' || ColorType == 'Select Colour'){
                                    ColorType = '';
                                    }
                                    if (StorageType == 'No Record found.' || StorageType == 'Select Storage'){
                                    StorageType = '';
                                    }
                                    if (CarrierType == 'No Record found.' || CarrierType == 'Select Carrier'){
                                    CarrierType = '';
                                    }

                                    if (brandType == 'No Record found.' || brandType == 'Select Brand'){
                                    brandType = '';
                                    }
                                    var DynamicTitle = brandType + ' ' + deviceType + ' ' + ModelType + ' ' + StorageType + ' ' + ColorType + ' ' + CarrierType + ' ' + serialnumbertitle;
                                    $(".dynamic-title").val(DynamicTitle);
                                    }

                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            } else{

                            $(".showserialexits").html("<p style='color:red'>Serial number is required.</p>");
                            setTimeout(function(){  $(".showserialexits").html(''); }, 1000);
                            return false;
                            }


                            }




                            function calculatetotalprice(e)
                            {
                            var sellingpriceflot = $("#sellingprice").val();
                            var sellingprice = Math.round(sellingpriceflot);
                            $(".showvalidationmessage").html('<p style="color:red"></p>');
                            if (sellingprice < 0) {
                            $(".showvalidationmessage").html('<p style="color:red"></p>');
                            setTimeout(function(){ $(".showvalidationmessage").html('<p style="color:red"></p>'); }, 2000);
                            return false;
                            }




                            if (sellingprice == '')
                            {
                            $("#shippngchargedit").val('');
                            $("#adminCharge").val('');
                            $("#finalprice").val('');
                            //$(".showvalidationmessage").html('<p style="color:red">this field is required</p>');
                            // setTimeout(function(){ $(".showvalidationmessage").html('<p style="color:red"></p>'); }, 2000);
                            return false;
                            } else {

                            $(".showloaderimgselling").show();
                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('totalsellingprice')}}' + '/' + sellingprice,
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {

                                    "price": sellingprice // method and token not needed in data
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function (xhr) {

                                    },
                                    success: function (json) {

                                    $(".showloaderimgselling").hide();
                                    $("#shippngchargedit").val(json.shippingCharge);
                                    $("#adminCharge").val(json.SellingCharge);
                                    var total = parseInt(json.SellingCharge) + parseInt(json.shippingCharge) + parseInt(sellingprice);
                                    $("#finalprice").val(parseInt(total));
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                            }

                            }


                            $(document).ready(function() {

                            var admincharge = $("#adminCharge").val();
                            var sellingpriceflot = $("#sellingprice").val();
                            var shippingprice = $("#shippngchargedit").val();
                            if (sellingpriceflot != ''){
                            var sellingprice = Math.round(sellingpriceflot);
                            var total = parseInt(admincharge) + parseInt(shippingprice) + parseInt(sellingprice);
                            $("#finalprice").val(parseInt(total));
                            }

                            });
                            function newtotalprice()
                            {

                            var shippingprice = $("#shippngchargedit").val();
                            if (shippingprice < 0) {
                            $(".shipingeditfiled").html('<p style="color:red"></p>');
                            setTimeout(function(){ $(".shipingeditfiled").html('<p style="color:red"></p>'); }, 2000);
                            return false;
                            }

                            if (shippingprice == '')
                            {
                            $(".shipingeditfiled").html('<p style="color:red"></p>');
                            setTimeout(function(){ $(".shipingeditfiled").html('<p style="color:red"></p>'); }, 2000);
                            return false;
                            } else{

                            var sellingpriceflot = $("#sellingprice").val();
                            var sellingprice = Math.round(sellingpriceflot);
                            var admincharge = $("#adminCharge").val();
                            var total = parseInt(admincharge) + parseInt(shippingprice) + parseInt(sellingprice);
                            $("#finalprice").val(parseInt(total));
                            }

                            }




                            function RemoveImage(productImageId)
                            {

                            var productImageID = productImageId;
                            if (confirm("Are you sure you want to delete this?")){



                            $.ajax({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                                    url: '{{url('deleteimage')}}' + '/' + productImageID,
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

                                    $(".removeImage" + productImageID).hide();
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


        <?php
        $headlineone = '';
        foreach ($headlines1 as $value) {

            $headlineone .= '"' . $value->tag_title . '",';
        }
        $headlinetwo = '';
        foreach ($headlines2 as $value) {

            $headlinetwo .= '"' . $value->tag_title . '",';
        }
        $headlinethree = '';
        foreach ($headlines3 as $value) {

            $headlinethree .= '"' . $value->tag_title . '",';
        }
        ?>

        <script>
            $(document).ready(function() {
            $(function() {
            var availableTags = [

<?php echo $headlineone ?>

            ];
            $("#headlineone").autocomplete({
            source: availableTags
            });
            });
            $(function() {
            var availableTags = [

<?php echo $headlinetwo ?>

            ];
            $("#headlinetwo").autocomplete({
            source: availableTags
            });
            });
            $(function() {
            var availableTags = [

<?php echo $headlinethree ?>

            ];
            $("#headlinethree").autocomplete({
            source: availableTags
            });
            });
            });
        </script>

        <script>
            $(document).ready(function() {
            $(".termcondition-error").hide();
            $('#frmvalidatex').validate({



            rules: {
            device_type : { required: true},
                    category_id : { required: true},
                    device_model : { required: true},
                    //colour : { required: true,},
                    //storage : { required: true,},
                    lowest_price : {required: true, min:1},
                    carrier_id : { required: true},
                    imei_code :{required: true, minlength: 17, maxlength: 17},
                    serial_number :{required: true, minlength: 11, maxlength: 11},
                    item_description : {required: true},
                    product_tag_one : {required: true},
                    product_tag_two : {required: true},
                    product_tag_three : {required: true},
                    selling_price : {required:true},
                    shipping_charge : {required:true},
                    item_title : {required:true},
                    final_price : {required:true, max:5000},
            },
                    messages :{
                    "device_type" : { required : 'Please select device.'},
                            "category_id" : { required : 'Please select brand.'},
                            "device_model" : { required : 'Please select model.'},
                            "colour" : { required : 'Please select colour.'},
                            "storage" : { required : 'Please select storage.'},
                            "carrier_id" : { required : 'Please select carrier.'},
                            "imei_code" : { required : 'Please enter IMEI number.', minlength:'IMEI minimum length is 15 characters', maxlength:'IMEI minimum length 15 characters'},
                            "serial_number" : { required : 'Please enter serial number.', minlength:'Serial number should be minimum 10 alphanumeric characters.', maxlength:'Serial number should be maximum 10 alphanumeric characters'},
                            "product_tag_one" : { required : 'Please enter tagline 1.'},
                            "product_tag_two" : { required : 'Please enter tagline 2.'},
                            "product_tag_three" : { required : 'Please enter tagline 3.'},
                            'selling_price' : { required : 'Please enter selling price.'},
                            'lowest_price' : { required : 'Please enter lowest price.', min:'Please enter lowest price greater than to 0.'},
                            'item_title' : { required : 'Listing title  is required.'},
                            'final_price' : { required : 'Final price  is required.', max:'Final price not more than $5000.'},
                            'shipping_charge' : { required : 'Shipping Fee  is required.'},
                            'item_description' : { required : 'Description  is required.'},
                    },
                    submitHandler: function(form) {

                    $(".frmsubmitloader").show();
                    if ($("input[name=termcondition]").is(":checked") == true) {
                    postContent('test');
                    } else{
                    $(".frmsubmitloader").hide();
                    $(".termcondition-error").show();
                    }




                    },
                    invalidHandler: function(frm, validator) {

                    $(".frmsubmitloader").hide();
                    },
            });
            });
            function postContent(postData) {


            $(form).submit();
            $(".frmsubmitloader").hide();
            return true;
            }
        </script>
        {{ Html::script('js/jquery.mask.js') }}

        <script>
            $(document).ready(function($){

            $(".imeinumber").mask("00000 00000 00000");
            $(".serailnumbertxt").mask('Z', {translation:  {'Z': {pattern: /[a-zA-Z0-9 ]/, recursive: true}}});
            var element = document.getElementById('serailnumbertxtid');
            element.addEventListener('input', function () {

            reformatInputField();
            });
            function reformatInputField() {
            function format(value) {
            return value.replace(/[^\dA-Z]/gi, '')
                    .toUpperCase()
                    .replace(/(.{5})/g, '$1 ')
                    .trim();
            }
            function countSpaces(text) {
            var spaces = text.match(/(\s+)/g);
            return spaces ? spaces.length : 0;
            }

            var position = element.selectionEnd;
            var previousValue = element.value;
            element.value = format(element.value);
            if (position !== element.value.length) {
            var beforeCaret = previousValue.substr(0, position);
            var countPrevious = countSpaces(beforeCaret);
            var countCurrent = countSpaces(format(beforeCaret));
            element.selectionEnd = position + (countCurrent - countPrevious);
            }
            }


            var selectedval = $("#devicetype").val();
            if (selectedval != ''){
            if (selectedval == 'iPhones' || selectedval == 'Phones')
            {
            $(".serialnumber").hide();
            $('.imeinumber').attr('disabled', false);
            $(".imeicodes").show();
            } else{

            $(".serialnumber").show();
            $('.serailnumbertxt').attr('disabled', false);
            $(".imeicodes").hide();
            }
            } else{

            }
            });



        </script>
