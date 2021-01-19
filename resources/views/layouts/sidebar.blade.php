@php
$currentUrl = Route::currentRouteName();
@endphp



<div class="login-user-block">
        <div class="log-usre-img">
            @if(!empty($logInedUser->profle_photo))
            <img src="{{ asset(Storage::url($logInedUser->profle_photo)) }}" alt="">
            @else
            <img src="{{ asset('img/user-img.png') }}" alt="">
            @endif

        </div>
        <span>{{ ucfirst($logInedUser->first_name).' '.ucfirst($logInedUser->last_name) }}</span>
      </div>
       <ul class="sidebar-link">
            <li class="{{ $currentUrl == 'user-dashboard' ? 'active' : '' }}"><a href="{{ url('/user-dashboard')}}"><i><img src="{{ asset('img/dashboard-1.svg')}}" alt=""></i>Dashboard</a></li>
            <li class="{{ $currentUrl == 'add_product' ? 'active' : '' }}"><a href="{{ url('/addProduct')}}"><i><img src="{{ asset('img/add-1.svg')}}" alt=""></i>Add a Listing</a></li>
            <li class="{{ $currentUrl == 'dashboard' ? 'active' : '' }}"><a href="{{ url('/dashboard')}}"><i><img src="{{ asset('img/list-1.svg')}}" alt=""></i>My Listings</a></li>


            <li class="{{ $currentUrl == 'add-payment-detail' ? 'active' : '' }}"><a href="{{ url('/add-payment-detail')}}"><i><img src="{{ asset('img/payment.svg')}}" alt=""></i>Payment Details</a></li>



        <li class="{{ $currentUrl == 'my_interest' ? 'active' : '' }}"><a href="{{ url('/myInterest')}}"><i><img src="{{ asset('img/view.svg')}}" alt=""></i>Watch List</a></li>
        <li><a data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic"><i><img src="{{ asset('img/Purchase.svg')}}" alt=""></i>My Purchases</a></li>
        <div class="collapse sub-menu-block" id="ui-basic">
        <ul>
                <li class="{{ $currentUrl == 'my_order' ? 'active' : '' }}"><a href="{{ url('/myOrder')}}"><i><img src="{{ asset('img/purchase-order.svg')}}" alt=""></i>My Purchasing Orders</a></li>
                <li class="{{ $currentUrl == 'my_selling_order' ? 'active' : '' }}"><a href="{{ url('/mySellingOrder')}}"><i><img src="{{ asset('img/selling.svg')}}" alt=""></i>My Selling Orders</a></li>
        </ul>
        </div>


        <li><a data-toggle="collapse" href="#ui-basic-offers" aria-expanded="false" aria-controls="ui-basic"><i><img src="{{ asset('img/offer.svg')}}" alt=""></i>My Offers</a></li>
        <div class="collapse sub-menu-block" id="ui-basic-offers">
        <ul>
                <li class="{{ $currentUrl == 'my_sent_offer' ? 'active' : '' }}"><a href="{{ url('/mySentOffer')}}"><i class="mr-0"><img src="{{ asset('img/discount.svg')}}" alt=""></i> Offers Placed</a></li>
                <li class="{{ $currentUrl == 'my_received_offer' ? 'active' : '' }}"><a href="{{ url('/myReceivedOffer')}}"><i><img src="{{ asset('img/order-1.svg')}}" alt=""></i>Offers Received</a></li>
        </ul>
        </div>
        <li class="{{ $currentUrl == 'my-revenue' ? 'active' : '' }}"><a href="{{ url('/my-revenue')}}"><i><img src="{{ asset('img/revenue-1.svg')}}" alt=""></i>My Revenue</a></li>

        <li class="{{ $currentUrl == 'profile' ? 'active' : '' }}"><a href="{{ url('/profile')}}"><i><img src="{{ asset('img/information-2.svg')}}" alt=""></i>My Details</a></li>
        <li class="{{ $currentUrl == 'change-password' ? 'active' : '' }}"><a href="{{ url('/change-password')}}"><i><img src="{{ asset('img/lock-1.svg')}}" alt=""></i>Change Password</a></li>
        <li class="{{ $currentUrl == 'recently-views' ? 'active' : '' }}"><a href="{{ url('/recently-views')}}"><i><img src="{{ asset('img/sid-view.svg')}}" alt=""></i>Recently Viewed</a></li>
        <li><a href="{{ asset('/logout')}}"><i><img src="{{ asset('img/logout-1.svg')}}" alt=""></i>Logout</a></li>
       </ul>





    <div class="modal hide fade" id="modalRegister">
        <div class="modal-dialog  modal-dialog-centered">
          <div class="modal-content">

            <!-- Modal Header -->


            <!-- Modal body -->
            <div class="modal-body">
            <h3 class="poupheading">Please Select your Preference</h3>
      <div class= "rad-group">

      <div class="popup-col">
      <div class="radio-custom">
      <input type="radio" id="rdb1" name="role_id" value="1">
      <label for="rdb1">I am a Seller <span class="breaktxt"></span></label>
      </div>
      </div>
      <div class="popup-col">
      <div class="radio-custom">
      <input type="radio" id="rdb2" name="role_id" value="2">
      <label for="rdb2">I am a Buyer <span class="breaktxt"></span></label>
      </div>
      </div>

      <div class="or-popup">OR</div>
      </div>
            </div>



          </div>
        </div>
      </div>



      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <script>
      $(".showsubmenuorder").on('click',function(){

        $(".showmenuorder").toggle();


     })



        $("input[name='role_id']").change(function(){


            var roleid = $(this).val();



              $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{url('addrole')}}'+'/'+roleid,
                            type: 'GET',
                            dataType: 'JSON',
                            data: {

                                "role_id": roleid // method and token not needed in data
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function (xhr) {

                            },

                            success: function (json) {

                                if (json.status === true) {

                                    if(roleid == 1){
                                   window.location.reload();
                                    }else{
                                        window.location.href = '{{url('profile')}}';
                                    }

                                } else {

                                }

                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });



        });

</script>
