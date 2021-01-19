@extends('layouts.inner_home')
@section('title','Cart')
@section('content')





    <div class="middle-wrapper">
            <div class="container">
              <div class="cart-page-block shopping-cart-block">
                 <div class="row">
                   <div class="col-md-8">
                     <div class="cart-dtl-box shad">
                            <div class="showaddtoCartmessage"></div>
                        <h3 class="d-inline-block mr-3">Shopping <strong>Cart</strong></h3>
                       <span class="d-inline-block">@include('layouts.admin.flash.alert')</span>


              @if(count($productData)>0)
              @php $total = 0; @endphp
              @foreach($productData as $product)
                @php $total += $product->final_price; @endphp

            <div class="hmt-shopping" id="remove{{ $product->id }}">
                         <div class="sho-img">
                                @if(!empty($product->mainphoto))
                                <img src="{{ asset(Storage::url($product->mainphoto)) }}" />
                                @else
                                <img src="{{ asset('img/NoPhone_grande.png') }}"/>
                                @endif

                            </div>

                         <div class="ipn-box">
                           <span><a href="{{ url('product/'.$product->product_slug)}}">{{ $product->item_title }}</a></span>
                           <p>{{ $product->device_type }}</p>
                           <strong>${{ $product->final_price }}</strong>
                         </div>
                         <a onClick="Removeitempopup('{{ $product->id }}')" href="javascript:void(0)" class="remove-btn"> <img src="img/remobe-btn.png" alt=""/></a>

                       </div>

               @endforeach

               @else

               <div class="hmt-shopping">
                   <p>Cart is empty.</p>
               </div>

               @endif


                       <div class="two-btn-block">
                         <a href="{{ url('/') }}" class="btn-custom cont-shop">Continue shopping</a>
                         @if(count($productData)>0)
                          @if(!empty($logInedUser))
                         <a href="{{ url('/checkout') }}" class="btn-custom">Proceed to Checkout</a>
                          @else
                        <a href="{{ url('/login') }}" class="btn-custom">Proceed to Checkout</a>
                          @endif
                         @endif
                       </div>
                     </div>
                   </div>
                   <div class="col-md-4">
                        @if(count($productData)>0)
                     <div class="cart-dtl-box shad confirm-pay">
                       <h3>Cart <strong>Details</strong></h3>
                       <ul class="total-block">
                         <li><p>Total Quantity</p> <strong>{{ count($productData) }}</strong></li>
                         <li><strong>Total Payable</strong> <strong class="tit-bx">${{ $total }}</strong></li>
                       </ul>
                     </div>
                     @endif
                     <div class="cart-dtl-box shad safe-block text-center">
                       <img src="{{ asset('img/safe.png') }}" alt="">
                       <p>Safe and Secure Payments. Easy returns. 100% Authentic products.</p>
                     </div>
                   </div>

                 </div>
              </div>
            </div>
          </div>

          <div class="modal" id="myModal">
                <div class="modal-dialog">
                  <div class="modal-content">




                    <!-- Modal body -->
                    <div class="modal-body">
                     Are you sure you want to remove this item?
                     <input type="hidden" class="removeitemid">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">

                      <a href="javascript:void(0)" class="btn btn-success" onClick="RemoveitemFromCart()">Yes</a>
                      <a href="javascript:void(0)" class="btn btn-danger" onClick="closePopup()">No</a>
                    </div>

                  </div>
                </div>
              </div>

@include('includes.footer')
@endsection


<script>

  function Removeitempopup($id){
  $(".removeitemid").val($id);
  $("#myModal").show();
  }

  function closePopup()
  {
    $("#myModal").hide();
  }

  function RemoveitemFromCart()
  {
     var itemid =  $(".removeitemid").val();

    window.location.href = "{{ URL::to('RemoveItemFromCart/') }}"+'/'+itemid;


  }


</script>

