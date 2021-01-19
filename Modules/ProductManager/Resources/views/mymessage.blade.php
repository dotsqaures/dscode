@extends('layouts.inner_home')
@section('title','Product')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My <span>Message</span></h1>
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


            <div class="message-block message-list shad">

            <div class="heading"><h2>Message  List</h2></div>

            <div class="message-tbl">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <th>Buyer Name</th>
                <th class="message-cell">Message</th>
                <th>Message Date</th>
                <th>Action</th>
              </tr>

              @if(count($Product)>0)
              @foreach($Product as $product)

              <tr>
                <td>{{ $product->userdatasender->first_name.' '.$product->userdatasender->last_name}}</td>
                <td>{{ substr($product->message,0,100).'...' }}</td>
                <td>{{ date('Y-m-d H:i A', strtotime($product->created_at)) }}</td>
                @php
                $messageCount  = \App\Helpers\BasicHelpers::CountUnreadMessageforSeller($product->product_id,$logInedUser->id,$product->userdatasender->id);
                @endphp
                <td ><div class="action-btn"><a href="{{ url('sellermessage/'.$product->product_id.'/'.$product->sender_id)}}" class="btn blue-btn">View

                        <?php
                        if($messageCount > 0) { ?>



                        <span class="message-countbox">{{ $messageCount }}</span>

                        <?php } ?>

                   </a></div></td>
              </tr>


              @endforeach
               @else

               <tr>
                   <td>
               <p>Currently buyer not showing any interest in this product</p>
                   </td>
               </tr>

              @endif



            </table>
            </div>




                    <div class="d-flex justify-content-end">
                            {{ $Product->links() }}
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






