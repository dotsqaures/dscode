<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\UserManager\Entities\User;
use Modules\ProductManager\Entities\Product;
use Modules\CategoriesManager\Entities\Categories;
use Modules\ProductManager\Entities\ProductImage;
use Modules\ProductManager\Http\Requests\ProductRequest;
use Illuminate\Pagination\Factory;
use Modules\DeviceManager\Entities\Device;
use Modules\ProductManager\Entities\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Mail;
use Illuminate\Pagination\Paginator;
use Modules\ModelManager\Entities\Devicemodel;
use Illuminate\Database\Query\Builder;
use Modules\ProductOffersManager\Entities\ProductOffers;
use Modules\ProductManager\Entities\Order;
use Modules\ProductManager\Entities\Cart;

use Modules\ProductManager\Entities\Ratting;
use Modules\ProductManager\Entities\OrderDetail;
use Modules\ProductManager\Entities\ReturnOrder;

class OfferController extends Controller
{



 public function getallheaders() {
    if (!is_array($_SERVER)) {
        return array();
    }
    $headers = array();
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}


public function myPlacedOffer()
{
    $logInedUser = Auth::user();

    $offerdata = ProductOffers::where('user_id',$logInedUser->id)->with('product')->orderBy('id','desc')->get()->unique('product_id')->values();

   if(count($offerdata)>0)
    {
       return response([
            'message'   => trans('Placed offer Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $offerdata,
         ]);
         
          /*$data =   json_encode([
                        'message'   => 'Placed offer Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdata,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Placed offer Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }

}


public function placedOfferDetail(Request $request)
{
    $logInedUser= Auth::user();

    if (empty($request->product_id)) {

        return response([
            'message'   => trans('Product id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
        $productid = $request->product_id;
        $offerdata = ProductOffers::where([['user_id',$logInedUser->id],['product_id',$productid]])->orderBy('id','ASC')->with('user')->with('product.user')->get();

        if(count($offerdata)>0)
            {
               return response([
                    'message'   => trans('Placed offer Listings.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $offerdata,
                ]);
                
                /*$data =   json_encode([
                        'message'   => 'Placed offer Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdata,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

            }else
            {

                return response([
                    'message'   => trans('Placed offer Listings not found.'),
                    'status'   => false,
                    'code' => 400,

                ]);

            }
    }
}


public function myReceivedOffer()
{
    $logInedUser = Auth::user();

    $offerdata = ProductOffers::whereHas('product',function($query) use($logInedUser) {
        return $query->where('products.user_id', $logInedUser->id);
    })->with([
        'user',
        'product.user',
    ])->orderBy('id','DESC')->get()->unique(['product_id'])->values();

   if(count($offerdata)>0)
    {
        return response([
            'message'   => trans('Received offer Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $offerdata,
         ]);
         
         /*$data =   json_encode([
                        'message'   => 'Received offer Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdata,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Received offer Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }

}



public function myReceivedOfferlist(Request $request)
{
    $logInedUser= Auth::user();

    if (empty($request->product_id)) {

        return response([
            'message'   => trans('Product id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
        $productid = $request->product_id;
        $offerdata = ProductOffers::where([['product_id',$productid]])->orderBy('id','DESC')->with('user')->with('product.user')->get()->unique(['user_id'])->values();

        if(count($offerdata)>0)
            {
                return response([
                    'message'   => trans('Received offer Listings.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $offerdata,
                ]);
                
                 /*$data =   json_encode([
                        'message'   => 'Received offer Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdata,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

            }else
            {

                return response([
                    'message'   => trans('Received offer Listings not found.'),
                    'status'   => false,
                    'code' => 400,

                ]);

            }
    }
}


public function receivedOfferDetail(Request $request)
{
    $logInedUser= Auth::user();

    if (empty($request->product_id) || empty($request->buyer_id)) {

        return response([
            'message'   => trans('Product id and buyer  id both is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
        $productid = $request->product_id;
        $userid = $request->buyer_id;
        $offerdata = ProductOffers::where([['user_id',$userid],['product_id',$productid]])->orderBy('id','ASC')->with('user')->with('product.user')->get();

        if(count($offerdata)>0)
            {
                return response([
                    'message'   => trans('Received offer detail Listings.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $offerdata,
                ]);
                
                 /*$data =   json_encode([
                        'message'   => 'Received offer detail Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdata,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

            }else
            {

                return response([
                    'message'   => trans('Received offer detail Listings not found.'),
                    'status'   => false,
                    'code' => 400,

                ]);

            }
    }

}

public function buyerOfferondetailpage(Request $request)
{
    $logInedUser= Auth::user();

    if(empty($request->buyer_offer_price) || empty($request->product_id) || empty($request->user_id) || empty($request->sender_id) || empty($request->receiver_id) || empty($request->message)) {

        return response([
            'message'   => trans('Product id and Offer price both is required'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {

        $IsSoldproduct = Product::where('id',$request->product_id)->first();
        if($IsSoldproduct->is_sold == 0){

        $checkcounteroffer = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->sender_id]])->count();

        if($checkcounteroffer == 1){

            return response([
                'message'   => trans("Please wait for seller's response before making another offer."),
                'status'   => false,
                'code' => 400,

            ]);
         }
         else if($checkcounteroffer > 2){
              return response([
                    'message'   => trans('Offer can not placed because your counter offer has been finished.'),
                    'status'   => false,
                    'code' => 400,

                ]);

        }else{

        $OfferAcceptCancel = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id]])->orderBy('id','DESC')->first();

        if(isset($OfferAcceptCancel->status) && $OfferAcceptCancel->status == 1){

           return response([
                    'message'   => trans('Offer can not placed because offer is accepted.'),
                    'status'   => false,
                    'code' => 400,

                ]);
        }elseif(isset($OfferAcceptCancel->status) && $OfferAcceptCancel->status == 2)
        {

           return response([
                    'message'   => trans('Offer can not placed because offer is cancelled.'),
                    'status'   => false,
                    'code' => 400,

                ]);
        }else{

           if(!empty($OfferAcceptCancel->no_of_counter))
           {
              $nofocounter = $OfferAcceptCancel->no_of_counter + 1;
           }else{
               $nofocounter = 1;
           }


        $array = collect($request)->except(['_token'])->all();
        $message = $request->message;
        $array['offer_date'] = date('Y-m-d H:i:s');
        $array['no_of_counter'] = $nofocounter;
        $array['buyer_offer_counter'] = $nofocounter;
        $array['seller_offer_counter'] = 0;
        $offerData = ProductOffers::create($array);
        $offerdatamail = ProductOffers::where('id',$offerData->id)->with('user')->with('product.user')->get();
        Product::SendOfferMailTocustomer($offerdatamail,$message);
        Product::SendOfferMailToseller($offerdatamail,$message);

        $sellerdata = User::where('id',$request->receiver_id)->first();

        $device_id = $sellerdata->device_id;
        $devicetype = $sellerdata->device_type;
        $message = 'You have received a new offer on your listed item and buyer offer price is '.$request->buyer_offer_price;
        $type = 'Hello, you have received a new offer on your listed item.';
        $sellername = $sellerdata->first_name;
        $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);

        return response([
                    'message'   => trans('Your offer has been submitted to the seller for approval.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $offerdatamail,
                ]);
                
                 /*$data =   json_encode([
                        'message'   => 'Your offer has been submitted to the seller for approval',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdatamail,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
    }



    }

    }else{

          return response([
                    'message'   => trans('Offer can not placed because this product already sold.'),
                    'status'   => false,
                    'code' => 400,

                ]);
     }

    }



}


public function buyerOfferCounter(Request $request)
{
    $logInedUser= Auth::user();

    if(empty($request->buyer_offer_price) || empty($request->product_id) || empty($request->user_id) || empty($request->sender_id) || empty($request->receiver_id) || empty($request->message)) {

        return response([
            'message'   => trans('Product id and Offer price both is required'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {

        $IsSoldproduct = Product::where('id',$request->product_id)->first();
        if($IsSoldproduct->is_sold == 0){

        $checkcounteroffer = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->sender_id]])->count();

        if($checkcounteroffer == 1){

            $checkmsg = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id]])->get();
            $OfferAcceptCancel = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id]])->orderBy('id','DESC')->first();       
            if(count($checkmsg) == $checkcounteroffer){
                        return response([
                            'message'   => trans('Please wait for seller response for further offer.'),
                            'status'   => false,
                            'code' => 400,

                        ]);
                    }else{

                        if(!empty($OfferAcceptCancel->no_of_counter))
                        {
                      $nofocounter = $OfferAcceptCancel->no_of_counter + 1;
                        }else{
                       $nofocounter = 1;
                       }

                 $CheckSellerCounter = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->receiver_id],['receiver_id',$request->sender_id]])->orderBy('id','DESC')->first();      

                $array = collect($request)->except(['_token'])->all();
                $message = $request->message;
                $array['offer_date'] = date('Y-m-d H:i:s');
                $array['no_of_counter'] = $nofocounter;
                $array['buyer_offer_counter'] = $nofocounter;
                $array['seller_offer_counter'] = $CheckSellerCounter->seller_offer_counter;
                $offerData = ProductOffers::create($array);
                $offerdatamail = ProductOffers::where('id',$offerData->id)->with('user')->with('product.user')->get();
                Product::SendOfferMailTocustomer($offerdatamail,$message);
                Product::SendOfferMailToseller($offerdatamail,$message);

                $sellerdata = User::where('id',$request->receiver_id)->first();

                $device_id = $sellerdata->device_id;
                $devicetype = $sellerdata->device_type;
                $message = 'You have received a new offer on your listed item and buyer offer price is '.$request->buyer_offer_price;
                $type = 'Hello, you have received a new offer on your listed item.';
                $sellername = $sellerdata->first_name;
                $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);

               return response([
                            'message'   => trans('Your offer has been submitted to the seller for approval.'),
                            'status'   => true,
                            'code' => 200,
                            'data' => $offerdatamail,
                        ]);
                        
                       /* $data =   json_encode([
                        'message'   => 'Your offer has been submitted to the seller for approval',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdatamail,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

                    }
         }
         else if($checkcounteroffer > 2){
              return response([
                    'message'   => trans('Offer can not placed because your counter offer has been finished.'),
                    'status'   => false,
                    'code' => 400,

                ]);

        }else{

        $OfferAcceptCancel = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id]])->orderBy('id','DESC')->first();

        if(isset($OfferAcceptCancel->status) && $OfferAcceptCancel->status == 1){

           return response([
                    'message'   => trans('Offer can not placed because offer is accepted.'),
                    'status'   => false,
                    'code' => 400,

                ]);
        }elseif(isset($OfferAcceptCancel->status) && $OfferAcceptCancel->status == 2)
        {

           return response([
                    'message'   => trans('Offer can not placed because offer is cancelled.'),
                    'status'   => false,
                    'code' => 400,

                ]);
        }else{

           if(!empty($OfferAcceptCancel->no_of_counter))
           {
              $nofocounter = $OfferAcceptCancel->no_of_counter + 1;
           }else{
               $nofocounter = 1;
           }

        $CheckSellerCounter = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->receiver_id],['receiver_id',$request->sender_id]])->orderBy('id','DESC')->first(); 
        $array = collect($request)->except(['_token'])->all();
        $message = $request->message;
        $array['offer_date'] = date('Y-m-d H:i:s');
        $array['no_of_counter'] = $nofocounter;
        $array['buyer_offer_counter'] = $nofocounter;
        $array['seller_offer_counter'] = $CheckSellerCounter->seller_offer_counter;
        $offerData = ProductOffers::create($array);
        $offerdatamail = ProductOffers::where('id',$offerData->id)->with('user')->with('product.user')->get();
        Product::SendOfferMailTocustomer($offerdatamail,$message);
        Product::SendOfferMailToseller($offerdatamail,$message);

        $sellerdata = User::where('id',$request->receiver_id)->first();

        $device_id = $sellerdata->device_id;
        $devicetype = $sellerdata->device_type;
        $message = 'You have received a new offer on your listed item and buyer offer price is '.$request->buyer_offer_price;
        $type = 'Hello, you have received a new offer on your listed item.';
        $sellername = $sellerdata->first_name;
        $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);

        return response([
                    'message'   => trans('Your offer has been submitted to the seller for approval.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $offerdatamail,
                ]);
                
               /* $data =   json_encode([
                        'message'   => 'Your offer has been submitted to the seller for approval',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdatamail,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
    }



    }

    }else{

          return response([
                    'message'   => trans('Offer can not placed because this product already sold.'),
                    'status'   => false,
                    'code' => 400,

                ]);
     }

    }



}



public function sellerOfferCounter(Request $request)
{

   $logInedUser= Auth::user();

    if(empty($request->seller_offer_price) || empty($request->product_id) || empty($request->user_id) || empty($request->sender_id) || empty($request->receiver_id) || empty($request->message)) {

        return response([
            'message'   => trans('Product id and Offer price both is required'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {

        $IsSoldproduct = Product::where('id',$request->product_id)->first();
        if($IsSoldproduct->is_sold == 0){

            if($request->receiver_id == $request->sender_id){
                $receiverid = $request->user_id;
                $OfferAcceptCancel = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$logInedUser->id],['receiver_id',$request->user_id]])->orderBy('id','DESC')->first();
            }else{
                $receiverid = $request->receiver_id;
                $OfferAcceptCancel = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->sender_id],['receiver_id',$request->receiver_id],['seller_offer_price', '!=', '']])->orderBy('id','DESC')->first();
                
                $checkprojectcounters = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$logInedUser->id],['receiver_id',$request->receiver_id]])->orderBy('id','DESC')->first();
           }
  
           
           $CheckBuyerCounter = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->receiver_id],['receiver_id',$request->sender_id]])->orderBy('id','DESC')->first();

             if(!empty($OfferAcceptCancel->no_of_counter))
                {
                    $nofocounter = $OfferAcceptCancel->no_of_counter + 1;
                }else{
                    $nofocounter = 1;
                }

                $buyeroffer = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$request->user_id]])->orderBy('id','DESC')->count();
                $checkcounteroffer = ProductOffers::where([['user_id',$request->user_id],['product_id',$request->product_id],['sender_id',$logInedUser->id]])->orderBy('id','DESC')->count();

                if($checkcounteroffer == 1 && $buyeroffer == 1){

                    return response([
                        'message'   => trans('Please wait for buyer response for further offer.'),
                        'status'   => false,
                        'code' => 400,

                    ]);
                }
                 else if($checkcounteroffer > 2){
                    return response([
                        'message'   => trans('Offer can not placed because your counter offer has been finished.'),
                        'status'   => false,
                        'code' => 400,

                    ]);

                 }else{

                $array = collect($request)->except(['_token'])->all();
                $message = $request->message;
                //$receiverid = $request->receiver_id;
                $array['offer_date'] = date('Y-m-d H:i:s');
                $array['no_of_counter'] = $nofocounter;
                
                $array['buyer_offer_counter'] = $CheckBuyerCounter->buyer_offer_counter;
                $array['seller_offer_counter'] = $nofocounter;
                
                $offerData = ProductOffers::create($array);
                $offerdatamail = ProductOffers::where('id',$offerData->id)->with('user')->with('product.user')->get();



                Product::SendcounterMail($offerdatamail,$message,$receiverid);

                $sellerdata = User::where('id',$receiverid)->first();

                $device_id = $sellerdata->device_id;
                $devicetype = $sellerdata->device_type;
                $message = 'You have received a new offer price from seller and seller offer price is '.$request->buyer_offer_price;
                $type = 'Hello, you have received a new offer price from seller.';
                $sellername = $sellerdata->first_name;
                $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);

                return response([
                    'message'   => trans('Your offer has been submitted to the buyer for approval.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $offerdatamail,
                ]);
                
               /* $data =   json_encode([
                        'message'   => 'Your offer has been submitted to the seller for approval',
                        'status'   => true,
                        'code' => 200,
                        'data' => $offerdatamail,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
            }

        }else{
              return response([
                    'message'   => trans('Offer can not placed because this product already sold.'),
                    'status'   => false,
                    'code' => 400,

                ]);
        }




    }

}


public function buyerOfferAction(Request $request)
{
     $logInedUser= Auth::user();

    if(empty($request->offer_id) || empty($request->status)) {

        return response([
            'message'   => trans('Offer id  is required'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
          $id = $request->offer_id;
          $type = $request->status;
          $CheckDataofferStatus = ProductOffers::where('id',$id)->first();
        if($CheckDataofferStatus->status == 1)
         {
          return response([
                    'message'   => trans('Offer has been accepted by seller, Payment link sent to your registered email adddress.'),
                    'status'   => false,
                    'code' => 400,

                ]);

         }elseif($CheckDataofferStatus->status == 2)
         {
           return response([
                    'message'   => trans('Offer has been rejected by seller.So you can not perfom any action.'),
                    'status'   => false,
                    'code' => 400,

                ]);


         }else{


        if($type == 1)
        {
            ProductOffers::where('id',  $id)->update([
               'status' => '1'
            ]);
            $offerdatamail = ProductOffers::where('id',$id)->with('user')->with('product.user')->get();
            $cartdata = ProductOffers::where('id',$id)->with('user')->with('product.user')->first();

            $alreadycheckCart = Cart::where([['user_id',$cartdata->user_id],['product_id',$cartdata->product_id]])->get();

            if(count($alreadycheckCart) == 0){

             $date = date('Y-m-d H:i:s');
             $values = array('user_id' => $cartdata->user_id,'product_id'=>$cartdata->product_id,'from_offer'=>'1','status'=>'1','created_at'=>$date,'updated_at'=>$date);
             $cardupdated = DB::table('carts')->insertGetId($values);

             $LastcartId = $cardupdated;
             Product::offeracceptmailbuyer($offerdatamail,$LastcartId);
             Product::offeracceptmailseller($offerdatamail,$LastcartId);
            }

            $buyerdata = User::where('id',$logInedUser->id)->first();

            $buyer_device_id = $buyerdata->device_id;
            $buyer_devicetype = $buyerdata->device_type;
            $buyer_message = 'Offer accepted successfully.Payment link sent to your email address';
            $buyer_type = 'Congratulations, offer has been accepted';
            $buyername = $buyerdata->first_name;

            $this->push_notification_to_buyer($buyer_device_id,$buyer_devicetype,$buyer_message,$buyer_type,$buyername);

           /* $sellerdata = User::where('id',$Product->user_id)->first();
            $device_id = $sellerdata->device_id;
            $devicetype = $sellerdata->device_type;
            $type = 'New order';
            $message = 'Congratulations, you have received a new order at SellBuyDevice and Order id is '.$orderId;
            $sellername = $sellerdata->first_name;
           $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);*/

            return response([
                    'message'   => trans('Offer accepted successfully.Payment link sent to your email address,please login and buy product.'),
                    'status'   => true,
                    'code' => 200,

                ]);

        }else{

            ProductOffers::where('id',  $id)->update([
               'status' => '2'
            ]);
            $offerdatamail = ProductOffers::where('id',$id)->with('user')->with('product.user')->get();
            Product::offercancelmailseller($offerdatamail);

            $buyerdata = User::where('id',$logInedUser->id)->first();

            $buyer_device_id = $buyerdata->device_id;
            $buyer_devicetype = $buyerdata->device_type;
            $buyer_message = 'Sorry, Offer rejected successfully.';
            $buyer_type = 'Sorry, offer has been rejected by you.';
            $buyername = $buyerdata->first_name;

            $this->push_notification_to_buyer($buyer_device_id,$buyer_devicetype,$buyer_message,$buyer_type,$buyername);


             return response([
                    'message'   => trans('Offer has been rejected successfully.'),
                    'status'   => true,
                    'code' => 200,

                ]);
        }
     }

    }
}


public function sellerOfferAction(Request $request){

    $logInedUser= Auth::user();

    if(empty($request->offer_id) || empty($request->status)) {

        return response([
            'message'   => trans('Offer id  is required'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
       $type = $request->status;
       $id = $request->offer_id;
        $CheckDataofferStatus = ProductOffers::where('id',$id)->first();
        if($CheckDataofferStatus->status == 1)
         {
          return response([
                    'message'   => trans('Offer has been accepted by buyer, Payment link sent to buyer registered email adddress.'),
                    'status'   => false,
                    'code' => 400,

                ]);

         }elseif($CheckDataofferStatus->status == 2)
         {
             return response([
                    'message'   => trans('Offer has been rejected by buyer.So you can not perfom any action.'),
                    'status'   => false,
                    'code' => 400,

                ]);


         }else{

            if($type == 1)
            {

               ProductOffers::where('id',  $id)->update([
                   'status' => '1'
                ]);
                $offerdatamail = ProductOffers::where('id',$id)->with('user')->with('product.user')->get();
                $cartdata = ProductOffers::where('id',$id)->with('user')->with('product.user')->first();


               $alreadycheckCart = Cart::where([['user_id',$cartdata->user_id],['product_id',$cartdata->product_id]])->get();

               if(count($alreadycheckCart) == 0){

                $date = date('Y-m-d H:i:s');
                $values = array('user_id' => $cartdata->user_id,'product_id'=>$cartdata->product_id,'from_offer'=>'1','status'=>'1','created_at'=>$date,'updated_at'=>$date);
                $cardupdated = DB::table('carts')->insertGetId($values);

                $LastcartId = $cardupdated;

                Product::offeracceptmail($offerdatamail,$LastcartId);

               }

               return response([
                    'message'   => trans('Offer accepted successfully. Please wait for buyer response.'),
                    'status'   => true,
                    'code' => 200,

                ]);


            }else{

                ProductOffers::where('id',  $id)->update([
                   'status' => '2'
                ]);
                $offerdatamail = ProductOffers::where('id',$id)->with('user')->with('product.user')->get();
                Product::offercancelmail($offerdatamail);

               return response([
                    'message'   => trans('Offer has been rejected successfully.'),
                    'status'   => true,
                    'code' => 200,

                ]);
            }
     }
    }
}


public function myrevenue(Request $request){

    $logInedUser= Auth::user();


    if(empty($request->start_date) && (empty($request->end_date))){
        $senddate = date('Y-m-d H:i:s');
        $startdate = date('Y-m-d H:i:s', strtotime('-7 days', strtotime($senddate)));
        $monthdate = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($senddate)));



            $receivedpayment = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
                return $query->where([['order_details.seller_id', $logInedUser->id],['is_transfer',1]]);
            })->with([
                'OrderReturnData',
                'OrderDetailsData',
                'OrderDetailsData.product',
            ])->where([['is_return',0],['is_transfertoseller',1]])->whereDate('order_date','>=',$monthdate.' 00:00:00')->whereDate('order_date','<=',$senddate.' 23:59:59')->get();


            if(count($receivedpayment)>0){
                $total = 0;
                foreach($receivedpayment as $val){
                  $total += $val->product->selling_price + $val->product->shipping_charge;

                }

                $stripeComssion = 2.9 * $total / 100;
                $totalRevenue = $total - $stripeComssion;
              }else{
                  $totalRevenue = 0;
              }

              $send = array();
              $send['id'] = '1';
              $send['startdate'] = $senddate;
              $send['enddate'] = $monthdate;
              $send['revenue'] = $totalRevenue;

              return response([
                'message'   => trans('Total Revenue. '),
                'status'   => true,
                'code' => 200,
                'data' => array($send),
            ]);
            
              /*$data =   json_encode([
                        'message'   => 'Total Revenue',
                        'status'   => true,
                        'code' => 200,
                        'data' => $send,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/


    }else{

            $senddate = date("Y-m-d", strtotime($request->start_date) );
            $monthdate = date("Y-m-d", strtotime($request->end_date) );


            $orderData = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
                return $query->where([['order_details.seller_id', $logInedUser->id]]);
            })->with([
                'OrderReturnData',
                'OrderDetailsData',
                'OrderDetailsData.product',
            ])->where([['is_return',0],['is_transfertoseller',1]])->whereDate('order_date','>=',$senddate.' 00:00:00')->whereDate('order_date','<=',$monthdate.' 23:59:59')->get();

            $send = array();
            $send['id'] = '1';
            $send['startdata'] = $senddate;
            $send['end'] = $monthdate;
            $send['revenue'] = $totalRevenue;

            return response([
              'message'   => trans('Total Revenue '),
              'status'   => true,
              'code' => 200,
              'data' => $send,
          ]);
          
          /*$data =   json_encode([
                        'message'   => 'Total Revenue',
                        'status'   => true,
                        'code' => 200,
                        'data' => $send,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }

}



function push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername){

    $url = 'https://fcm.googleapis.com/fcm/send';

    $key = 'AIzaSyAfiGrcZpV4GyWCeI8j4C8Tccf4ta58aaU';
    $headers = array('Authorization: key=' . $key, 'Content-Type: application/json');
    $user = auth()->guard('api')->user();

    $finalmsg["body"] = $message;

    $finalmsg["title"] = "SellBuyDevice";
    $finalmsg["message"] = $message;
    $finalmsg["type"] = $type;
    $finalmsg["login_user_name"] = $sellername;

    $finalmsg["unique_key"] = mt_rand(10000, 99999);
    $finalmsg["priority"] = 'high';
    $finalmsg["sound"] = 'default';

    if($devicetype =='IOS' || $devicetype =='iOS') {


        $fields = array(
            'to' => $device_id,
            'data' => $finalmsg,
            'notification' => $finalmsg,
            'priority' => 'high' // new fcm
        );
    } else {

        $fields = array(
            'to' => $device_id,
            'data' => $finalmsg,
            //  'notification' => $finalmsg,
            'priority' => 'high' // new fcm
        );
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);


    curl_close($ch);

    return true;
}



function push_notification_to_buyer($buyer_device_id,$buyer_devicetype,$buyer_message,$buyer_type,$buyername){

    $url = 'https://fcm.googleapis.com/fcm/send';

    $key = 'AIzaSyAfiGrcZpV4GyWCeI8j4C8Tccf4ta58aaU';
    $headers = array('Authorization: key=' . $key, 'Content-Type: application/json');
    $user = auth()->guard('api')->user();

    $finalmsg["body"] = $buyer_message;

    $finalmsg["title"] = "SellBuyDevice";
    $finalmsg["message"] = $buyer_message;
    $finalmsg["type"] = $buyer_type;
    $finalmsg["login_user_name"] = $buyername;

    $finalmsg["unique_key"] = mt_rand(10000, 99999);
    $finalmsg["priority"] = 'high';
    $finalmsg["sound"] = 'default';

    if($buyer_devicetype =='IOS' || $buyer_devicetype =='iOS') {


        $fields = array(
            'to' => $buyer_device_id,
            'data' => $finalmsg,
            'notification' => $finalmsg,
            'priority' => 'high' // new fcm
        );
    } else {

        $fields = array(
            'to' => $buyer_device_id,
            'data' => $finalmsg,
            //  'notification' => $finalmsg,
            'priority' => 'high' // new fcm
        );
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);


    curl_close($ch);
    //print_r($ch); die;
    return true;
}



}
