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
    <h1>My  <span>Profile</span></h1>
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

        {{ Form::model('', ['url' => route('update-password') , 'method' => 'post']) }}

        <div class="row">


                <div class="col-sm-4">
              <div class="search-col required {{ $errors->has('old_password') ? 'has-error' : '' }}">
                            <label for="title">Old Password</label>
                            {{ Form::password('old_password', array('placeholder'=>'Enter Old Password','class' => 'form-control')) }}

                            @if($errors->has('old_password'))
                            <span class="help-block">{{ $errors->first('old_password') }}</span>
                            @endif
                        </div>
                </div>

                <div class="col-sm-4">
                        <div class="search-col required {{ $errors->has('password') ? 'has-error' : '' }}">
                                      <label for="title">New Password</label>
                                      {{ Form::password('password', array('placeholder'=>'Enter New Password','class' => 'form-control')) }}

                                      @if($errors->has('password'))
                                      <span class="help-block">{{ $errors->first('password') }}</span>
                                      @endif
                                  </div>
                          </div>


                          <div class="col-sm-4">
                                <div class="search-col required {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                              <label for="title">Confirm New Password</label>
                                              {{ Form::password('password_confirmation', array('placeholder'=>'Enter New Password Again','class' => 'form-control')) }}

                                              @if($errors->has('password_confirmation'))
                                              <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
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




















