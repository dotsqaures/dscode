<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Auth;
class BasicHelpers
{

    /**
     * getStingWithEmoji
     * @return String
     */




    public static function GetparentCategory($id)
    {
        $subMenu = DB::table('categories')->where([['id',$id],['status','1']])->first();
        if($subMenu)
        {
            return $subMenu->title;
        }else{
            return '';
        }


    }


    public static function SubMenuNav($device_id)
    {
        $subMenu = DB::table('devicemodels')->where([['device_id',$device_id],['status','1']])->get();

       return $subMenu;
    }








    public static function CountUnreadMessageforSeller($productid,$receiverid,$senderid)
    {

        $totalUnreadMessage = DB::table('chats')->where([['sender_id','=',$senderid],['receiver_id','=',$receiverid],['product_id','=',$productid],['status','=',0]])->get();

        return count($totalUnreadMessage);
    }



    public static function UserInfo($userid)
    {

        $info = DB::table('users')->where('id',$userid)->first();

        return $info;
    }

    public static function Restaurentname($userid)
    {

        $info = DB::table('users')->where('employee_code',$userid)->first();
          return $info;
    }




    public static function stempinfor($id)
    {

        $info = DB::table('stamps')->where('id',$id)->first();

        return $info;
    }

    public static function orderredem($id,$orderid)
    {

        $info = DB::table('redem_stamps')->where('order_id',$orderid)->get();

        return $info;
    }

    public static function RedemStampTotal($orderid){
        $info = DB::table('redem_stamps')->where('order_id',$orderid)->get();

        return $info;
    }




    public static function ProductInfo($orderDetailArray)
    {
        $itemdata = DB::table('order_details')->whereIn('id',$orderDetailArray)->get();

        foreach($itemdata as $val)
        {
            $productdata[] = DB::table('products')->where('id',$val->product_id)->get();
        }



        return $productdata;

    }


    public static function offervalue($productid,$userid){

      $offerprice =   DB::table('product_offers')->where([
          ['user_id', $userid],
          ['status' , 1],
          ['product_id' , $productid]
           ])->first();

      if($offerprice){
        if(!empty($offerprice->buyer_offer_price))
        {
           $price = $offerprice->buyer_offer_price;
        }else{
          $price = $offerprice->seller_offer_price;
        }
        return $price;
      }
     return "";

    }


    /*public static function isFavourite($supplierId){
        $user=Auth::user();
        $issubscribed=DB::table('favourites')->where(['user_id'=>$user->id,'supplier_id'=>$supplierId])->exists();
        return $issubscribed;
    }*/

}
