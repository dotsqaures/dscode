@extends('layouts.inner_home')
@section('title','Add Payment Detail')
@section('content')

@php
$login = Auth::user();




@endphp


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>Add Payment  <span>Details</span></h1>
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

        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

 <div class="add-product-page shad add-spacing">

        {{ Form::model('', ['url' => ['update-account-stripe'], 'method' => 'post','enctype'=>'multipart/form-data']) }}

        <div class="row">




            <div class="col-sm-6">


                <div class="search-col required  {{ $errors->has('account_holder_name') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                    <label for="title">Account Holder Name </label>
                                        {{ Form::text('account_holder_name', old('account_holder_name') ? old('accont_name') : ($user->profile ? $user->profile->account_holder_name : '') ,
                                            ['class' => 'form-control','placeholder' => 'Account Holder Name']) }}
                                            
                                             @if($errors->has('account_holder_name'))
                                            <span class="help-block">{{ $errors->first('account_holder_name') }}</span> @endif

                    </div>

            </div>

                <div class="col-sm-6">


                    <div class="search-col required  {{ $errors->has('routing_number') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                        <label for="title">BSB Number</label>
                                            {{ Form::text('routing_number', old('routing_number') ? old('routing_number') : ($user->profile ? $user->profile->routing_number : '') ,
                                                ['class' => 'form-control','placeholder' => 'BSB Number']) }}
                                                @if($errors->has('routing_number'))
                                                <span class="help-block">{{ $errors->first('routing_number') }}</span> @endif
                     </div>

                </div>

                <div class="col-sm-6">

                     <div class="search-col required  {{ $errors->has('account_number') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                        <label for="title">Bank Account Number</label>
                        {{ Form::text('account_number', old('account_number') ? old('account_number') : ($user->profile ? $user->profile->account_number : ''),
                                                ['class' => 'form-control','placeholder' => 'Account Number']) }}
                                                 @if($errors->has('account_number'))
                                                <span class="help-block">{{ $errors->first('account_number') }}</span> @endif
                      </div>


                </div>

                <div class="col-sm-6">

                 <label>Date of Birth</label>

                        <div class="row">

                        <div class="col-sm-6">

                                <div class="search-col pb-3 pb-sm-2 required  {{ $errors->has('dob') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                                    <input name="dob" id="datepicker" class="form-control" autocomplete="off">
                                    @if($errors->has('dob'))
                                    <span class="help-block">{{ $errors->first('dob') }}</span> @endif
                                    </div>

                            </div>



                        </div>

                </div>

              


                <div class="col-sm-12">

                    <label>Address</label>
                        <div class="row">

                          <div class="col-sm-4">

                                <div class="search-col pb-3 pb-sm-2  {{ $errors->has('city') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                                    <label for="title">Suburb</label>
                                    {{ Form::text('city', old('city') ? old('city') :($user->profile ? $user->profile->city : ''),
                                                            ['class' => 'form-control','placeholder' => 'Suburb']) }}
                                                             @if($errors->has('city'))
                                                            <span class="help-block">{{ $errors->first('city') }}</span> @endif
                                </div>


                          </div>
                          <div class="col-sm-4">
                                <div class="search-col pb-3 pb-sm-2  {{ $errors->has('state') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                                    <label for="title">State</label>
                                    <select class="form-control" name="state" id="selectbillingstate1">
                                            <option value="">Please select state</option>
                                            <option value="NSW">New South Wales</option>
                                            <option value="QLD">Queensland</option>
                                            <option value="SA">South Australia</option>
                                            <option value="TAS">Tasmania</option>
                                            <option value="VIC">Victoria</option>
                                            <option value="WA">Western Australia</option>

                                        </select>
                                        @if($errors->has('state'))
                                        <span class="help-block">{{ $errors->first('state') }}</span> @endif

                                </div>
                          </div>
                          <div class="col-sm-4">
                                <div class="search-col pb-3 pb-sm-2  {{ $errors->has('postal_code') ? 'has-error' : '' }}"> <i class="iconimg"></i>
                                    <label for="title">PostCode</label>
                                    {{ Form::text('postal_code', old('postal_code') ? old('postal_code') :($user->profile ? $user->profile->postal_code : ''),
                                                            ['class' => 'form-control','placeholder' => 'PostCode']) }}
                                                             @if($errors->has('postal_code'))
                                                            <span class="help-block">{{ $errors->first('postal_code') }}</span> @endif
                                </div>
                          </div>
                           </div>


                      </div>

                      <div class="col-sm-12">

                            <div class="search-col">
                                <label> Full Address</label>

                       <textarea class="form-control" name="address" type="text"></textarea>
                           </div>
                     </div>





                <div class="col-sm-12">
                   <div class="form-group">
                    <p style="padding: 0px 0 20px;line-height:0"><strong> Requirements for ID verification.</strong> </p>
                    <p style="padding: 0px 0 20px;line-height:0"> Acceptable documents vary by country, although a passport scan is always acceptable and preferred.</p>
                    <p style="padding: 0px 0 20px;line-height:0"> Scans of front and back are required for government issued IDs and driver license.</p>
                    <p style="padding: 0px 0 20px;line-height:0"> Files need to be JPEGs or PNGs and should be smaller than 5 mb. We can't verify PDF.</p>
                            <p style="padding: 0px 0 20px;line-height:0"> Files should be in color, be rotated with the image right-side up, and have all information clearly legible.
                    </p>
                     </div>
                </div>


            <div class="col-sm-6">
                <div class="search-col required {{ $errors->has('stripe_document_front') ? 'has-error' : '' }}">
                    <label style="display:block;">Verification Document Front</label>
                        <input class="" type="file" name="stripe_document_front" />
                        @if($errors->has('stripe_document_front'))
                        <span style="display:block" class="help-block">{{ $errors->first('stripe_document_front') }}</span> @endif
                        @php
               $filepath = '/storage/users/doc/';
               @endphp
               @if(!empty($user->profile->stripe_document_front) && file_exists(public_path() . $filepath . $user->profile->stripe_document_front)) <a href="{{ url($filepath. $user->profile->stripe_document_front) }}" download>download</a>
                       @endif
                                                    </div>

            </div>

            <div class="col-sm-6">
                <div class="search-col require {{ $errors->has('stripe_document_back') ? 'has-error' : '' }}">
                            <label style="display:block;">Verification Document Back</label>
                                <input class="" type="file" name="stripe_document_back" />
                                @if($errors->has('stripe_document_back'))
                                <span style="display:block" class="help-block">{{ $errors->first('stripe_document_back') }}</span> @endif
                                @php
                       $filepath = '/storage/users/doc/';
                       @endphp


                       @if(!empty($user->profile->stripe_document_back) && file_exists(public_path() . $filepath . $user->profile->stripe_document_back)) <a href="{{ url($filepath. $user->profile->stripe_document_back) }}" download>download</a>
                               @endif
                                                            </div>
            </div>







                <div class="col-sm-6 d-none d-sm-block "></div>










        </div>
        <div class="d-flex justify-content-centers  align-items-center form-bottm">
                <div class="register-btn">
                        <button type="submit" class="btn blue-btn">SUBMIT</button>


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



<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
        changeMonth: true,
            changeYear: true,
        dateFormat: 'dd/mm/yy',
        yearRange: '1950:2005',
        maxDate: new Date(2005, 11,31)
    });
  } );
  </script>
