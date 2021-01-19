<form  method="POST" id="addressfrm" name="addressfrm">
        <div class="cart-dtl-box shad">
          <h3>Shipping <strong>Address</strong></h3>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
               <input name="shiping_name" type="text" class="form-control shiping_name" placeholder="First Name" value="{{ $useraddress->shiping_name}}">
               </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
           <input name="shiping_last_name"  type="text" class="form-control shiping_last_name" placeholder="Last Name" value="{{$useraddress->shiping_last_name}}"></div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                       <input name="shiping_Unit_number" type="text" class="form-control shiping_Unit_number" placeholder="Unit No." value="{{$useraddress->shiping_Unit_number}}">
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                       <input name="shiping_Street_number" type="text" class="form-control shiping_Street_number" placeholder="Street No." value="{{$useraddress->shiping_Street_number}}">
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
               <input name="shipping_address_one" type="text" class="form-control shippingAddress3" placeholder="Street Name" value="{{$useraddress->shipping_address_one}}">
               </div>
           </div>
           <div class="col-md-12">
               <div class="form-group">
               <input name="shipping_address_two" type="text" class="form-control shippingAddress4" placeholder="Street Name2 (Optional)" value="{{$useraddress->shipping_address_two}}">
               </div>
           </div>
           <div class="col-md-4">
               <div class="form-group">
               <input name="shipping_suburb" type="text" class="form-control shipping_suburb" placeholder="suburb" value="{{$useraddress->shipping_suburb}}">
               </div>
           </div>
           <div class="col-md-4">
               <div class="form-group">
               <select class="form-control" name="shipping_state" id="selectstateedit" >
                   <option value="">Please select state</option>

                   <option value="NSW" {{ ($useraddress->shipping_state == 'NSW') ? 'selected' : '' }} >New South Wales</option>
                   <option value="QLD" {{ ($useraddress->shipping_state == 'QLD') ? 'selected' : '' }}>Queensland</option>
                   <option value="SA" {{ ($useraddress->shipping_state == 'SA') ? 'selected' : '' }}>South Australia</option>
                   <option value="TAS" {{ ($useraddress->shipping_state == 'TAS') ? 'selected' : '' }}>Tasmania</option>
                   <option value="VIC" {{ ($useraddress->shipping_state == 'VIC') ? 'selected' : '' }}>Victoria</option>
                   <option value="WA" {{ ($useraddress->shipping_state == 'WA') ? 'selected' : '' }}>Western Australia</option>

               </select>
               </div>
           </div>
           <div class="col-md-4">
               <div class="form-group">
               <input name="shipping_postcode" type="number" class="form-control shipping_postcode" placeholder="Post Code" value="{{$useraddress->shipping_postcode}}">
               </div>
           </div>


           <div class="col-md-6">
                <div class="form-group">

                        <div class="phone-no-outer">
                         <span class="phone-no">+61</span>
                         <input name="shipping_mobileno" type="text" class="form-control shipping_mobileno1" placeholder="Mobile Number" value="{{$useraddress->shipping_mobileno}}">
                        </div>
                </div>
        </div>


          </div>
        </div>
        <div class="cart-dtl-box shad">
          <h3>Billing <strong>Address</strong></h3>
          <span class="check-typ-dp"><input type="checkbox" name="sameaddress" onclick="set_checked_edit()" checked />Please check If billing address is same as shipping address.</span>
          <div class="row">

            <div class="col-md-6">
                <div class="form-group">
            <input name="billing_name" type="text" class="form-control" placeholder="First Name" value="{{$useraddress->billing_name}}"></div>
            </div>

            <div class="col-md-6">
                   <div class="form-group">
              <input name="billing_last_name"  type="text" class="form-control" placeholder="Last Name" value="{{$useraddress->billing_last_name}}"></div>
               </div>


               <div class="col-md-3">
               <div class="form-group">
                       <input name="billing_Unit_number" type="text" class="form-control" placeholder="Unit No." value="{{$useraddress->billing_Unit_number}}">
               </div>
             </div>
                 <div class="col-md-3">
                  <div class="form-group">
                 <input name="billing_Street_number" type="text" class="form-control" placeholder="Street No." value="{{$useraddress->billing_Street_number}}">
                 </div>
               </div>
                   <div class="col-md-6">
                       <div class="form-group">
                       <input name="billing_address_one" type="text" class="form-control billingAddress1" placeholder="Street Name" value="{{$useraddress->billing_address_one}}">
                       </div>
                   </div>


                   <div class="col-md-12">
                           <div class="form-group">
                           <input name="billing_address_two" type="text" class="form-control billingAddress2" placeholder="Street Name2 (Optional)" value="{{$useraddress->billing_address_two}}">
                           </div>
                       </div>
                   <div class="col-md-4">
                       <div class="form-group">
                       <input name="billing_suburb" type="text" class="form-control" placeholder="suburb" value="{{$useraddress->billing_suburb}}">
                       </div>
                   </div>


                   <div class="col-md-4 showselectval">
                           <div class="form-group">
                           <select class="form-control" name="billing_state" id="selectbillingstateedit">
                               <option value="">Please select state</option>
                               <option value="NSW" {{ ($useraddress->shipping_state == 'NSW') ? 'selected' : '' }} >New South Wales</option>
                   <option value="QLD" {{ ($useraddress->shipping_state == 'QLD') ? 'selected' : '' }}>Queensland</option>
                   <option value="SA" {{ ($useraddress->shipping_state == 'SA') ? 'selected' : '' }}>South Australia</option>
                   <option value="TAS" {{ ($useraddress->shipping_state == 'TAS') ? 'selected' : '' }}>Tasmania</option>
                   <option value="VIC" {{ ($useraddress->shipping_state == 'VIC') ? 'selected' : '' }}>Victoria</option>
                   <option value="WA" {{ ($useraddress->shipping_state == 'WA') ? 'selected' : '' }}>Western Australia</option>


                           </select>
                           </div>
                       </div>

                       <div class="col-md-4 hideselectval" style="display:none;">
                           <div class="form-group">
                           <select class="form-control" name="billing_state" id="selectbillingstate1">
                               <option value="">Please select state</option>
                               <option value="NSW">New South Wales</option>
                               <option value="QLD">Queensland</option>
                               <option value="SA">South Australia</option>
                               <option value="TAS">Tasmania</option>
                               <option value="VIC">Victoria</option>
                               <option value="WA">Western Australia</option>

                           </select>
                           </div>
                       </div>



               <div class="col-md-4">
                           <div class="form-group">
                           <input name="billing_postcode" type="number" class="form-control" placeholder="Post Code" value="{{$useraddress->billing_postcode}}">
                           </div>
                       </div>



                       <div class="col-md-6">
                            <div class="form-group">

                                    <div class="phone-no-outer">
                                     <span class="phone-no">+61</span>
                                     <input name="billing_mobileno" type="text" class="form-control billingMobile" placeholder="Mobile Number" value="{{$useraddress->billing_mobileno}}">
                                    </div>
                            </div>
                    </div>




    <input name="status" type="hidden" class="form-control" placeholder="Name" value="2">
    <input name="id" type="hidden" class="form-control" placeholder="Name" value="{{$useraddress->id}}">
          </div>

        </div>
        <div class="returnmessagenew"></div>
        <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg" style="display:none;">
        <input class="btn-custom" type="submit" value="Submit" style="width:100%" >
       </form>




