@extends('layouts.inner_home')
@section('title','Step 2')
@section('content')

@php
 $login = Auth::user();

 $adminChangre = '5';
 $length = 8;
 $token = "";
 $codeAlphabet = "ABCDEFGHIJKLM0123456789";
 $codeAlphabet.= "0123456789NOPQRSTUVWXYZ";
 $max = strlen($codeAlphabet); // edited
 for ($i=0; $i < $length; $i++) {
  $token .= $codeAlphabet[random_int(0, $max-1)];
 }

@endphp


<div class="middle-wrapper step2">
    <div class="container">
    <div class="pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>Add <span>a Listing</span></h1>
    </div>
<a class="btn blue-btn back-btn-ht" href="{{ url('/editProduct/'.$Productid )}}">Back</a>
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



        <div class="add-product-page shad add-spacing">

@include('layouts.admin.flash.alert')



            {{ Form::open(['url' => 'addstep2','enctype'=>'multipart/form-data','name'=>'frmstep2','id'=>'frmvalidatestep2',]) }}



            <div class="row">
                    <div class="col-md-12">

<input type="hidden" value="{{ $Productid }}" name="productid">

                   <ul class="d-flex flex-wrap listing-photo top-listing-block">
                        <div class="showerrormesage"></div>
                            <div class="listing-photo-title">Verification Photos<a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="We require werification photos to check if the device is legitimate. This helps us reduce fraudulent listings on our platform and thereby increase the trust between our buyers and sellers."><i class="far fa-question-circle"></i></a></div>



                           <li>
                               <div class="content">
                                       <div class="file-outer {{ $errors->has('imei_number_photo') ? 'has-error' : ''}}">
                                           <i class="fa fa-plus"></i>

                                             <input type="file" class="custom-flie" name="imei_number_photo" onchange="readURL(this,'1')">
                                             
                                       </div>


                                      <div class="img-box">
                                          @if(!empty($products->imei_number_photo))
                                        <img src="{{ asset(Storage::url($products->imei_number_photo)) }}" alt="" id="imeiNumber1">
                                         @else
                                         <img src="../img/mobile-imei.jpg" alt="" id="imeiNumber1">
                                         @endif

                                    </div>
                                      <div class="photo-title">
                                            @if(!empty($products->imei_code))
                                               {{ 'IMEI number photo' }}
                                            @elseif(!empty($products->serial_number))
                                              {{ 'Serial number photo' }}

                                            @endif

                                        </div>


                                      @if($errors->has('imei_number_photo'))
                                      <span class="help-block">{{ $errors->first('imei_number_photo') }}</span>
                                      @endif
                                </div>

                                <div class="right-prt-text"><p>Dial *#06# on your phone and take a photo of it with another device. The phone must be seen in the photo. No screenshots accepted.</p></div>

                           </li>
                           <li>
                               <div class="content">
                                      <div class="file-outer {{ $errors->has('google_id_photo') ? 'has-error' : ''}}">
                                            <i class="fa fa-plus"></i>
                                              <input type="file" class="custom-flie" name="google_id_photo" onchange="readURL(this,'2')">
                                        </div>
                                      <div class="img-box">
                                            @if(!empty($products->google_id_photo))
                                            <img src="{{ asset(Storage::url($products->google_id_photo)) }}" alt="" id="imeiNumber2">
                                             @else
                                             <img src="../img/apple-id.jpg" alt="" id="imeiNumber2">
                                             @endif
                                       </div>
                                      <div class="photo-title">Apple ID/Google ID photo</div>
                                      @if($errors->has('google_id_photo'))
                                      <span class="help-block">{{ $errors->first('google_id_photo') }}</span>
                                      @endif
                                </div>
                              <div class="right-prt-text"><p>iPhones: Settings > Account > Sign Out. Android: Settings > Accounts > Remove Google Account. Take a photo of your account page after signing out.</p></div>
                           </li>

                           </ul>

<!--                           <span class="inc-text-tb sec-text-tvp">
                           @if(!empty($products->imei_code))
                            {{ 'Dial *#06# on your phone’s keypad to see your device’s IMEI number.' }}
                        @elseif(!empty($products->serial_number))
                            {{ '' }}

                        @endif

                            </span>-->


                           <ul class="d-flex flex-wrap listing-photo">
                            <div class="listing-photo-title">Listing Photos <a href="javascript:void(0)" class="tooltip-icon" data-toggle="tooltip" title="Add all of the recommended photos as shown will increase the sellability of your device."><i class="far fa-question-circle"></i></a></div>
                            <span class="inc-text-tb">Increase your device's selling chances by adding clear photos taken under good lighting.</span>


                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="mainphoto" onchange="readURL(this,'4')">
                                       </div>
                                      <div class="img-box">
                                            @if(!empty($products->mainphoto))
                                            <img src="{{ asset(Storage::url($products->mainphoto)) }}" alt="" id="imeiNumber4">
                                             @else
                                             <img src="../img/mobile-front.jpg" alt="" id="imeiNumber4">
                                             @endif

                                      </div>
                                      <div class="photo-title">Front</div>
                                </div>

                           </li>
                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="backphoto" onchange="readURL(this,'5')">
                                       </div>
                                      <div class="img-box">

                                          @if(!empty($products->backphoto))
                                            <img src="{{ asset(Storage::url($products->backphoto)) }}" alt="" id="imeiNumber5">
                                             @else
                                             <img src="../img/mobile-back.jpg" alt="" id="imeiNumber5">
                                             @endif
                                        </div>
                                      <div class="photo-title">back</div>
                                </div>

                           </li>
                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="leftphoto" onchange="readURL(this,'6')">
                                       </div>
                                      <div class="img-box">
                                            @if(!empty($products->leftphoto))
                                            <img src="{{ asset(Storage::url($products->leftphoto)) }}" alt="" id="imeiNumber6">
                                             @else
                                             <img src="../img/mobile-left.jpg" alt="" id="imeiNumber6">
                                             @endif

                                       </div>
                                      <div class="photo-title">Left Side</div>
                                </div>

                           </li>

                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="rightphoto" onchange="readURL(this,'7')">
                                       </div>
                                      <div class="img-box">

                                            @if(!empty($products->rightphoto))
                                            <img src="{{ asset(Storage::url($products->rightphoto)) }}" alt="" id="imeiNumber7">
                                             @else
                                             <img src="../img/mobile-right.jpg" alt="" id="imeiNumber7">
                                             @endif

                                        </div>
                                      <div class="photo-title">Right side</div>
                                </div>

                           </li>
                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="topphoto" onchange="readURL(this,'8')">
                                       </div>
                                      <div class="img-box">
                                            @if(!empty($products->topphoto))
                                            <img src="{{ asset(Storage::url($products->topphoto)) }}" alt="" id="imeiNumber8">
                                             @else
                                             <img src="../img/mobile-bot.jpg" alt="" id="imeiNumber8">
                                             @endif


                                        </div>
                                      <div class="photo-title">Top</div>
                                </div>

                           </li>
                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="bottomphoto" onchange="readURL(this,'9')">
                                       </div>
                                      <div class="img-box">

                                            @if(!empty($products->bottomphoto))
                                            <img src="{{ asset(Storage::url($products->bottomphoto)) }}" alt="" id="imeiNumber9">
                                             @else
                                             <img src="../img/mobile-top.jpg" alt="" id="imeiNumber9">
                                             @endif

                                        </div>
                                      <div class="photo-title">Bottom</div>
                                </div>

                           </li>

                           <li>
                                <div class="content">
                                        <div class="file-outer">
                                            <i class="fa fa-plus"></i>
                                              <input type="file" class="custom-flie" name="scratchphoto" onchange="readURL(this,'10')">
                                        </div>
                                       <div class="img-box">

                                            @if(!empty($products->scratchphoto))
                                            <img src="{{ asset(Storage::url($products->scratchphoto)) }}" alt="" id="imeiNumber10">
                                             @else
                                             <img src="../img/mobile-scratch.jpg" alt="" id="imeiNumber10">
                                             @endif

                                       </div>
                                       <div class="photo-title">Scratches/Marks/Dents</div>
                                 </div>

                            </li>

                            <li>
                                    <div class="content">
                                            <div class="file-outer">
                                                <i class="fa fa-plus"></i>
                                                  <input type="file" class="custom-flie" name="scratchphoto2" onchange="readURL(this,'12')">
                                            </div>
                                           <div class="img-box">

                                                @if(!empty($products->scratchphoto2))
                                                <img src="{{ asset(Storage::url($products->scratchphoto2)) }}" alt="" id="imeiNumber12">
                                                 @else
                                                 <img src="../img/mobile-scratch1.jpg" alt="" id="imeiNumber12">
                                                 @endif

                                             </div>
                                           <div class="photo-title">Other Scratches/Marks/Dents</div>
                                     </div>

                                </li>



                           <li>
                               <div class="content">
                                       <div class="file-outer">
                                           <i class="fa fa-plus"></i>
                                             <input type="file" class="custom-flie" name="allaccessories" onchange="readURL(this,'11')">
                                       </div>
                                      <div class="img-box">

                                            @if(!empty($products->allaccessories))
                                            <img src="{{ asset(Storage::url($products->allaccessories)) }}" alt="" id="imeiNumber11">
                                             @else
                                             <img src="../img/mobile-accessories.jpg" alt="" id="imeiNumber11">
                                             @endif

                                        </div>
                                      <div class="photo-title">All Items You Will Ship</div>
                                </div>

                           </li>

                           </ul>






                        </div>


            </div>



        <div class="d-flex justify-content-center  align-items-center form-bottm">
        <div class="register-btn">
<img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="frmsubmitloader" style="display:none;">
                <input class="submit btn blue-btn" type="submit" value="Submit For Approval" id="submitfrm">


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






<style>
    #mainphoto-error{ padding:18px 0 0 0}
    #backphoto-error{ padding:18px 0 0 0}
</style>






@include('includes.footer')
@endsection


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>






<script>


 function readURL(input,nubr)
 {
    $(".showerrormesage").show();
    $(".showerrormesage").html("<p></p>");
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
   if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
   {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#imeiNumber'+nubr).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
   }else{

    $(".showerrormesage").html("<p style='color:red'>Image Format Not valid.Please use png,jpeg,jpg,gif image format </p>");
    setTimeout(function() {
        $('.showerrormesage').fadeOut('fast');
    }, 3000);


}


 }

</script>

<?php if(empty($products->imei_number_photo)){ ?>

<script>
        $(document).ready(function() {

            $('#frmvalidatestep2').validate({

             rules: {
                imei_number_photo:{
                    required: true,

                },
                mainphoto:{
                    required: true,

                },
                backphoto:{
                    required: true,

                }

              },

              messages :{
                imei_number_photo:{
                        required: "This photo is required.",

                    },
                    mainphoto:{
                        required: "Front photo is required.",

                    },
                    backphoto:{
                        required: "Back photo is required.",

                    }
                },



              submitHandler: function(form) {
               $(".frmsubmitloader").show();   
               postContent('test');

              },
               invalidHandler: function(frm, validator) {
                  $(".frmsubmitloader").hide();
                },



            });

          });

          function postContent(postData) {
    
             $(".frmsubmitloader").hide();
             $("#submitfrm").attr("disabled", "disabled");
             $(form).submit();
             

            return true;

        }
        </script>


<?php } ?>
