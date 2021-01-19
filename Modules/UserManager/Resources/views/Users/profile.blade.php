@extends('layouts.inner_home')
@section('title','Manage')
@section('content')

@php
$login = Auth::user();




@endphp


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My  <span>Details</span></h1>
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
        @include('layouts.admin.flash.alert')

 <div class="add-product-page shad add-spacing">

        {{ Form::model($user, ['url' => ['update-profile', $user->id], 'method' => 'patch','enctype'=>'multipart/form-data']) }}

        <div class="row">





                <div class="col-sm-6">
              <div class="search-col required {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label for="title">First Name <span style="color:red">*</span></label>
                            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control stop_first_space','placeholder' => 'First Name']) }}
                            @if($errors->has('first_name'))
                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                </div>

                <div class="col-sm-6">
                        <div class="search-col required {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <label for="title">Last Name<span style="color:red">*</span></label>
                                {{ Form::text('last_name', old('last_name'), ['class' => 'form-control stop_first_space','placeholder' => 'Last Name']) }}
                                @if($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                </div>

                <div class="col-sm-6">
                        <div class="search-col required {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="title">Email Address</label>
                                    {{ Form::text('email', old('email'), ['class' => 'form-control','placeholder' => 'Email Address','readonly'=>'readonly']) }}
                                    @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
                        </div>
                </div>

                <div class="col-sm-6">
                        <div class="search-col {{ $errors->has('mobileno') ? ' has-error' : '' }}">
                                <label>Mobile PHONE NUMBER</label>
                                <div class="phone-no-outer">
                                 <span class="phone-no">+61</span>
                                {{ Form::text('mobileno', old('mobileno'), ['class' => 'form-control jbsekerregis','placeholder' => '(4XX XXX XXX)','autofocus' => true]) }}

                                </div>
                                @if($errors->has('mobileno'))

                              <span class="help-block">{{ $errors->first('mobileno') }}</span>
                                @endif
                            </div>
                </div>




                <div class="col-sm-6">

                     <div class="search-col">
                               <label for="description">Profile Photo</label>
                               <input  name="profle_photo" type="file" class="form-control">
                            </div>
@if(!empty($user->profle_photo))
                            <div class="select-items">



                                        <img src="{{ asset(Storage::url($user->profle_photo)) }}" style="width:100px; height:100px;"/>


                                         </div>
 @endif

                </div>



                <div class="col-sm-6">

                        <div class="search-col">
                           <label for="description">Business Logo</label>
                           <input  name="bussiness_logo" type="file" class="form-control">
                        </div>
                     @if(!empty($user->bussiness_logo))
                     <div class="select-items">
                     <img src="{{ asset(Storage::url($user->bussiness_logo)) }}" style="width:100px; height:100px;"/>
                     </div>
                     @endif

                </div>

                   <div class="col-sm-6">

                               <div class="search-col">
                                  <label for="description">Business Name</label>


                               {{ Form::text('bussiness_name', old('bussiness_name'), ['class' => 'form-control','placeholder' => 'Business Name']) }}
                               @if($errors->has('bussiness_name'))
                               <span class="help-block">{{ $errors->first('bussiness_name') }}</span>
                               @endif
                            </div>

                   </div>

                   <div class="col-sm-6">

                        <div class="search-col">
                           <label for="description">Business Location</label>


                        {{ Form::text('bussiness_location', old('bussiness_location'), ['class' => 'form-control','placeholder' => 'Business Location']) }}
                        @if($errors->has('bussiness_location'))
                        <span class="help-block">{{ $errors->first('bussiness_location') }}</span>
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













@include('includes.footer')
@endsection


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
{{ Html::script('js/jquery.mask.js') }}

<script>
        $(document).ready(function($){

        $(".jbsekerregis").mask("400 000 000");
        });


 $(function() {
$(".stop_first_space").on("keypress", function(e) {
    if (e.which === 32 && !this.value.length)
        e.preventDefault();
});
});



        function RemoveImage(productImageId)
        {

             var productImageID = productImageId;

             if(confirm("Are you sure you want to delete this?")){



              $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{url('deleteimage')}}'+'/'+productImageID,
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
