{{ Form::open(['url' => 'returnrequest','method'=>'post','id'=>'retunrfrm','name'=>'retunrfrm']) }}
@foreach($orderData as $order)
        <div class="form-group">
            <label class="control-label" for="company">Select item</label>
            <div class="">



                    <div class="multiselect">
                            <div class="selectBox" onclick="showCheckboxes()">
                              <select id="selectval">
                                <option>Select item</option>
                              </select>
                              <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes" class="chkbox-block">
                                    @foreach($order->OrderDetailsData as $value)
                                        
                                   
                                        @if(!empty($returData))
                                            @if(in_array($value->id,unserialize($returData->orderdetail_id)))

                                            <label for="{{ $value->product->id }}">
                                                    <input type="checkbox" id="{{ $value->product->id }}" value="{{ $value->id }}" name="orderdetail_id[]" checked/>{{ $value->product->item_title }}
                                                </label>


                                            @else

                                                <label for="{{ $value->product->id }}">
                                                    <input type="checkbox" id="{{ $value->product->id }}" value="{{ $value->id }}" name="orderdetail_id[]" />{{ $value->product->item_title }}
                                                </label>
  
                                            @endif
                                        @else

                                        <label for="{{ $value->product->id }}">
                                                <input type="checkbox" id="{{ $value->product->id }}" value="{{ $value->id }}" name="orderdetail_id[]" />{{ $value->product->item_title }}
                                            </label>


                                        @endif 
                                    
                            @endforeach

                            </div>
                          </div>
                        <div class="showerrormessage"></div>



            </div>
        </div>

        <div class="form-group">
                <label class="control-label" for="company">Reason of Return</label>
                <div class="">
                   @if(!empty($returData))

                        {!! Form::textarea('return_reason',$returData->return_reason,['class'=>'form-control', 'rows' => 2, 'cols' => 40,'id'=>'returnordetxt']) !!}
                  @else

                  {!! Form::textarea('return_reason',null,['class'=>'form-control', 'rows' => 2, 'cols' => 40,'id'=>'returnordetxt']) !!}

                  @endif
                </div>
                <div class="showerrormessagetxt"></div>


        </div>

   <input type="hidden" name="order_id" value="{{ $order->id }}" class="orderid"/>
   <input type="hidden" name="user_id" value="{{ $logInedUser->id }}" class="orderid"/>

        @endforeach


<div class="row">
<div class="col-12 return-pop-btns btn-inline text-right">
  <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg returnloader" style="display:none;">
  <input class="btn btn-primary" type="submit" value="Submit" id="btnSubmit">
  <a href="javascript:void(0)" class="btn btn-danger" onclick="CloseEmailPopup()" tabindex="1">Close</a>
</div>
</div>



</form>


<style>
        .multiselect {
            width: 200px;
          }

          .selectBox {
            position: relative;
          }

          .selectBox select {
            width: 100%;
            font-weight: bold;
          }

          .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
          }

          #checkboxes {
            display: none;
            border: 1px #dadada solid;
          }

          #checkboxes label {
            display: block;
          }
          .error{color:red}

          #checkboxes label:hover {
            background-color: #1e90ff;
          }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    
          
        var expanded = false;

        function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
            if($('[name="orderdetail_id[]"]:checked').length>0){

                $("#selectval").html("<option>Item Selected</option>");

              }else{
                $("#selectval").html("<option>Please select item</option>");
              }
        } else {
            checkboxes.style.display = "none";
            if($('[name="orderdetail_id[]"]:checked').length>0){

                $("#selectval").html("<option>Item Selected</option>");

              }else{
                $("#selectval").html("<option>Please select item</option>");
              }
            expanded = false;
        }
        }




        $(retunrfrm).validate({
        rules: {

                return_reason : { required: true},

                },
               messages :{
                  "return_reason" : { required : 'This field is required.'},

                  },
              submitHandler: function(retunrfrm) {
                  if($('[name="orderdetail_id[]"]:checked').length>0){
                      
                       var txt = $('#returnordetxt').val();
                    var len =txt.trim().length;
                    if (len < 1)
                    {
                      $(".showerrormessagetxt").show();
                    $(".showerrormessagetxt").html("<p style='color:red'>Please Enter reason value</p>");
                    setTimeout(function(){ $(".showerrormessagetxt").hide() }, 5000);
                    return false;   
                    
                    }else{

                    $(".showloaderimg").show();
                    $("#btnSubmit").attr("disabled", true);
                    $("#retunrfrm").submit();

                   }
                      
                   
                  }else{
                    $(".showerrormessage").show();
                    $(".showerrormessage").html("<p style='color:red'>Please select item for return</p>");
                    setTimeout(function(){ $(".showerrormessage").hide() }, 5000);
                    return false;
                  }

              },
             invalidHandler: function(retunrfrm, validator) {

             },

       });
       




</script>
