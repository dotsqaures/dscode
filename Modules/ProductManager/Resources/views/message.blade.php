@extends('layouts.inner_home')
@section('title','Product')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My <span>Chat</span></h1>
    </div>
    @include('layouts.admin.flash.alert')



    </div>


    <div class="product-lists mrg-t20">
    <div class="row">



    <div class="col-md-4 product-category-col ">
    <input type="checkbox" id="togglebox" class="togglebox dekstop-tab-hide" />
    <nav id="expand-fullpagemenu">

    <label for="togglebox" id="closex" class="toggleclose dekstop-tab-hide">Close</label>

    <div class="product-category-box shad my-product-col">

            @include('layouts.sidebar')


    </div>

  </nav>

    </div>

    <div class="col-md-8  ">


    <div class="message-block shad">

    <div class="message-thread-part content">


        @if(count($totalMessage)>0)
        @foreach($totalMessage as $message)

    @if($logInedUser->id == $message->sender_id)

    <div class="message-box-area message-sender">
    <div class="message-profile-pic">
        @if(!empty($logInedUser->profle_photo))
        <img src="{{ asset(Storage::url($logInedUser->profle_photo)) }}" alt="">
        @else
        <img src="{{ asset('img/default-man.jpg') }}" alt="">
        @endif
    </div>
    <div class="message-area">
    <div class="message-username">{{ $logInedUser->first_name.' '.$logInedUser->last_name}}</div>
    <div class="message-box">
    {{ $message->message}}

    </div>
    <div class="message-date-time"> {{ date('Y-m-d H:i A', strtotime($message->created_at)) }}</div>
    </div>
   </div>

   @else

    <div class="message-box-area message-receiver">
    <div class="message-profile-pic">

        @if(!empty($message->userdatasender->profle_photo))
        <img src="{{ asset(Storage::url($message->userdatasender->profle_photo)) }}" alt="">
        @else
        <img src="{{ asset('img/default-man.jpg') }}" alt="">
        @endif
    </div>
    <div class="message-area">
    <div class="message-username">{{ $message->userdatasender->first_name.' '.$message->userdatasender->last_name}}</div>
    <div class="message-box">
            {{ $message->message}}

    </div>
    <div class="message-date-time"> {{ date('Y-m-d H:i A', strtotime($message->created_at)) }}</div>
   </div>
   </div>

   @endif

   @endforeach
   @else

   <div class="message-box-area message-receive">
        <p>No Message here</p>
       </div>

   @endif


   </div>

    <div class="chat-reply-box">

            {{ Form::open(['url' => 'addnewmessage','enctype'=>'multipart/form-data']) }}

            <input type="hidden" name="product_id" value="{{ $productId }}"/>
            <input type="hidden" name="sender_id" value="{{ $logInedUser->id }}" />

            @if($logInedUser->role_id == 2)
           <input type="hidden" name="receiver_id" value="{{ $products->user_id }}" />
           @else
           <input type="hidden" name="receiver_id" value="{{ $senderid }}" />

           @endif

           <textarea name="message" cols="" rows="" class="form-control" required="required"></textarea>
   <div class="chat-btn mrg-t20 justify-content-end d-flex">

       <button type="submit" class="btn blue-btn">Send Message</button>
    </div>


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






