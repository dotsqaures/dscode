@extends('layouts.inner_home')
@section('title','Verification')
@section('content')


<div class="middle-wrapper linerbg">
        <div class="container">
        <div class="register-page login-page pad-t70 pad-b70">
        <div class="text-center icon"><img src="{{ asset('img/login-icon.png') }}" alt=""></div>
        <div class="heading text-center">
        <h1>Verification <span>Code</span></h1>
        </div>


        <div class="form-block">


            <!-- Nav tabs -->
                <!-- Nav tabs links -->

                  <!-- Nav tabs -->
                <!-- Tab panes -->
                  <div class="tab-content">

                    <div id="mobile">
                        <div class="showmessage" style="color:green"></div>
                        <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg" style="display:none;">
                      @include('layouts.admin.flash.alert')
                <form method="POST" action="{{ route('verifyotptoken') }}">
                        @csrf



        <div class="search-col {{ $errors->has('otp_token') ? ' has-error' : '' }}">
                <label>Enter Verification Code </label>
                {{ Form::number('otp_token', old('otp_token'), ['class' => 'form-control'.($errors->has('otp_token') ? ' is-invalid' : ''),'placeholder' => 'Enter Verification Code.','autofocus' => true,'required'=>true]) }}

                <p style="font-size:12px;">If you have not received the OTP yet, please click<a href="javascript:void(0)" onclick='ResendOtp()' style="text-decoration:underline"> here </a> to  resend.</p>
            </div>




        <div class="register-btn d-block mrg-t30">

                <button type="submit" class="btn blue-btn">Verify</button>

        </div>

    </form>
                    </div>
                  </div>




        </div>







        </div>




        </div>

        </div>

        @include('includes.footer')
@endsection


<script>

    function ResendOtp(){

        $(".showloaderimg").show();

      $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url('resendotp')}}',
            type: 'GET',
            dataType: 'html',
            data: {},
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {

            },

            success: function (json) {

                $(".showloaderimg").hide();
                $(".showmessage").addClass("alert alert-success alert-block ");
             $(".showmessage").html(json);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

    }

</script>
