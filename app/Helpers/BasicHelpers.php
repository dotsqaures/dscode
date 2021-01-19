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


    /* get product type */
    








  
  

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
