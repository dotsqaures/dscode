<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
Use Storage;
use Modules\UserManager\Entities\User;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\CarriersManager\Entities\Carriers;
use Modules\HeadlineOnesManager\Entities\HeadlineOnes;
use Modules\HeadlineTwosManager\Entities\HeadlineTwos;
use Modules\HeadlineThreesManager\Entities\HeadlineThrees;
use Modules\StoragesManager\Entities\Storages;
use Modules\ColorsManager\Entities\Colors;
use Modules\ModelManager\Entities\Devicemodel;
use Modules\DeviceManager\Entities\Device;




class Product extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['custom_product_id','item_title','location','phone_purchase_date','is_bill_avaialble',
    'phone_condition','item_video','item_description','selling_price','is_price_negotiable',
    'user_id','category_id','status','star_ratting','device_type','device_model','product_slug',
    'shipping_charge','admin_charge','final_price','imei_number_photo',
    'google_id_photo','imei_code','is_feature','is_sold','product_tag_one','product_tag_two','product_tag_three',
    'carrier_id','colour','storage','lowest_price','broken_device_id','termcondition','mainphoto',
    'frontphoto','backphoto','leftphoto','rightphoto','topphoto','bottomphoto','scratchphoto','allaccessories','serial_number','offer_price','is_return'];

    public function sluggable() {
        return [
            'dbfield' => 'product_slug',
            'source' => 'item_title',
            'table' => 'product',
        ];
    }


    public function setProductSlugAttribute($value){
         return $this->attributes['product_slug'] = strtolower(str_replace(" ", "-",$value));
    }




    public function setBrokenDeviceIdAttribute($value){
        settype($value, 'array');
        $this->attributes['broken_device_id'] = serialize($value);

   }

    public function category() {
        return $this->belongsTo(\Modules\CategoriesManager\Entities\Categories::class, 'category_id', 'id');
    }

    public function featureproduct() {
        return $this->hasMany(\Modules\ProductManager\Entities\ProductFeature::class, 'product_id','id');
    }

    public function user() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'user_id', 'id');
    }

    public function ProductImages() {
        return $this->hasMany(\Modules\ProductManager\Entities\ProductImage::class, 'product_id', 'id');
    }


    public function carriername() {
        return $this->belongsTo(\Modules\CarriersManager\Entities\Carriers::class, 'carrier_id', 'id');
    }

    public function storagename(){
      return $this->belongsTo(\Modules\StoragesManager\Entities\Storages::class,'storage','id');
    }

    public function devicemodel(){
        return $this->belongsTo(\Modules\ModelManager\Entities\Devicemodel::class,'device_model','id');
      }

      public function device(){
        return $this->belongsTo(\Modules\DeviceManager\Entities\Device::class,'device_type','device_name');
      }

      public function colour(){
        return $this->belongsTo(\Modules\ColorsManager\Entities\Colors::class,'colour','color_name');
      }


    public function HeadlineOne() {
        return $this->belongsTo(\Modules\HeadlineOnesManager\Entities\HeadlineOnes::class, 'product_tag_one', 'id');
    }

    public function HeadlineTwo() {
        return $this->belongsTo(\Modules\HeadlineTwosManager\Entities\HeadlineTwos::class, 'product_tag_two', 'id');
    }

    public function HeadlineThree() {
        return $this->belongsTo(\Modules\HeadlineThreesManager\Entities\HeadlineThrees::class, 'product_tag_three', 'id');
    }


    public function colorname()
    {
        return $this->belongsTo(\Modules\ColorsManager\Entities\Colors::class, 'colour', 'color_name');
    }


    public function chats() {
        return $this->hasMany(\Modules\ProductManager\Entities\Chat::class, 'product_id', 'id');
    }

    public function scopeStatus($query, $status = null)
    {
        if ($status === '0' || $status == 1 || $status == 2) {
            $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */


    /**
     * Scope a query to only include filtered users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('item_title', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('item_description', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('phone_condition', 'LIKE', '%' . $keyword . '%');
            });
        }
        return $query;
    }

    public function scopeCategoryWise($query, $category_id)
    {

        if (!empty($category_id)) {
            $rootIds = \Modules\CategoriesManager\Entities\Categories::where('id','=',$category_id)->pluck('id')->toArray();
            $rootIds[] = $category_id;
            $query->whereIn('category_id', $rootIds);
        }
        return $query;
    }


    public static function sendAcceptRejectMail($Product)
    {

           $productsData = $Product;


           if ($productsData) {

             if($productsData->status == 1)
             {
                 $actions = 'approved';

             }else{

                $actions = 'rejected';
             }
              $hook = "advert-accept-reject";

               $replacement['USER_NAME'] = $productsData->user->first_name.' '.$productsData->user->last_name;
               $replacement['ACCEPTED'] = $actions;
               $replacement['ADVER_NAME'] = $productsData->item_title;
               $data = ['template' => $hook, 'hooksVars' => $replacement];

            Mail::to($productsData->user->email)->send(new \App\Mail\ManuMailer($data));
        }
    }

    public static function SendNotificationtoSellerForImprovementInProduct($Product,$message)
    {

           $productsData = $Product;


           if ($productsData) {


              $hook = "product-improvment";

               $replacement['USER_NAME'] = $productsData->user->first_name.' '.$productsData->user->last_name;

               $replacement['PRODUCT_NAME'] = $productsData->item_title;
               $replacement['Message'] = $message;
               $data = ['template' => $hook, 'hooksVars' => $replacement];


            Mail::to($productsData->user->email)->send(new \App\Mail\ManuMailer($data));
        }
    }


    public static function SendEmailToSellerforAddnewListing($Product)
    {
        $productsData = $Product;


           if ($productsData) {

               $hook = "send-listing-email-to-seller";

               $replacement['USER_NAME'] = $productsData->user->first_name.' '.$productsData->user->last_name;
              
               $replacement['ProductTitlelink'] = url('/').'/product/'.$productsData->product_slug;
               $replacement['ProductTitle'] = $productsData->item_title;
               $data = ['template' => $hook, 'hooksVars' => $replacement];

            Mail::to($productsData->user->email)->send(new \App\Mail\ManuMailer($data));

    }
}


public static function FeatureEmailToadmin($Product){

    $productsData = $Product;


    if ($productsData) {

        $hook = "featured-product-mail";
       
        $replacement['ProductTitlelink'] = url('/').'/product/'.$productsData->product_slug;
        $replacement['ADVER_NAME'] = $productsData->item_title;
        $data = ['template' => $hook, 'hooksVars' => $replacement];

     Mail::to(config('get.ADMIN_EMAIL'))->send(new \App\Mail\ManuMailer($data));

}
}

    public static function SendEmailToAdminforAddnewListing($Product)
    {
        $productsData = $Product;


           if ($productsData) {

               $hook = "add-listing-email-to-admin";

               $replacement['username'] = $productsData->user->first_name.' '.$productsData->user->last_name;
               
               $replacement['ProductTitlelink'] = url('/').'/product/'.$productsData->product_slug;
               $replacement['producttitle'] = $productsData->item_title;
               $data = ['template' => $hook, 'hooksVars' => $replacement];

            Mail::to(config('get.ADMIN_EMAIL'))->send(new \App\Mail\ManuMailer($data));

    }
}


public static function SendShareEmailToCustomer($Product){

    $productsData = $Product;
    $emails =  explode (",", $productsData['email']);



           if ($productsData) {

               $hook = "share-email-customer";


               $replacement['LIST_URL'] = $productsData['producturl'];

               $replacement['Message'] = $productsData['message'];

               $data = ['template' => $hook, 'hooksVars' => $replacement];

               foreach($emails as $val){

               Mail::to($val)->send(new \App\Mail\ManuMailer($data));
               }

    }

}


public static function SendOrderEmailTocustomer($orderId,$logInedUser,$token)
{

    $orderData = OrderDetail::where('order_id',$orderId)->with('product')->get();
    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "customer-order-email";
    $replacement['USER_NAME'] = $logInedUser->first_name;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to($logInedUser->email)->send(new \App\Mail\ManuMailer($data));
}

public static function SendOrderEmailToSeller($orderId,$logInedUser,$token)
{
    $orderData = OrderDetail::where('order_id',$orderId)->groupBy('seller_id')->get();

    $BuyerAddress = UserAddressBook::where([['user_id',$logInedUser->id],['status','2']])->first();

    $ShippingAddress = $BuyerAddress['shiping_name'].' '.$BuyerAddress['shipping_address_one'].' '.$BuyerAddress['shipping_suburb'].' '.$BuyerAddress['shipping_postcode'].' '.$BuyerAddress['shipping_mobileno'];

    foreach($orderData as $data){


    $orderData = OrderDetail::where([['order_id',$orderId],['seller_id',$data->seller_id]])->with('product')->get();

    $tabeldata = Product::GetTabelProductData($orderData);

    $userdata = User::where('id',$data->seller_id)->first();
    $hook = "seller-order-email";
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['USER_NAME'] = $userdata['first_name'].' '.$userdata['last_name'];
    $replacement['Name'] = $logInedUser->first_name;
    $replacement['EMAIL'] = $logInedUser->email;
    $replacement['MOBILENO'] = $logInedUser->mobileno;
    $replacement['CUSTOMER_DELIVERY_ADDRESS'] = $ShippingAddress;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];

    Mail::to($userdata['email'])->send(new \App\Mail\ManuMailer($data));

    } 

}

public static function SendOrderEmailToAdmin($orderId,$logInedUser,$token)
{

    $orderData = OrderDetail::where('order_id',$orderId)->with('product')->get();
    $tabeldata = Product::GetTabelProductDataForAdmin($orderData);

    $BuyerAddress = UserAddressBook::where([['user_id',$logInedUser->id],['status','2']])->first();
    $ShippingAddress = $BuyerAddress['shiping_name'].' '.$BuyerAddress['shipping_address_one'].' '.$BuyerAddress['shipping_suburb'].' '.$BuyerAddress['shipping_postcode'].' '.$BuyerAddress['shipping_mobileno'];


    $hook = "admin-order-email";
    $replacement['LOGIN_URL'] = url('/').'/admin/login';
    $replacement['Name'] = $logInedUser->first_name;
    $replacement['EMAIL'] = $logInedUser->email;
    $replacement['MOBILENO'] = $logInedUser->mobileno;
    $replacement['CUSTOMER_DELIVERY_ADDRESS'] = $ShippingAddress;
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to(config('get.ADMIN_EMAIL'))->send(new \App\Mail\ManuMailer($data));

}







public static function GetTabelProductData($Productdata)
{

    $tabeldata = "";
    $tabeldata .= "<table width='100%' border='0' cellpadding='0' cellspacing='0' style='font-family:Arial, Helvetica, sans-serif;border: solid 1px #eaeaea;font-size:14px;'>
    <tr>

      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Product Id</th>
      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Image</th>
      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Title</th>
      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-bottom:solid 1px #dadada;'>Price</th>
    </tr>";

    $total = 0;
    foreach($Productdata as $produdcts){

         if(!empty($produdcts->product->offer_price)){
          $total += $produdcts->product->offer_price;
            }else{
             $total += $produdcts->product->final_price;
            }



   if(!empty($produdcts->product->mainphoto))
   {
      $imagevarraible = "<img src='".asset(Storage::url($produdcts->product->mainphoto))."'  style='width:40px;'/>";
   }else{
      $imagevarraible = "<img src='". asset('img/NoPhone_grande.png')."' style='width:40px;'/>";
   }

   if(!empty($produdcts->product->offer_price)){
      $price = $produdcts->product->offer_price;
   }else{
    $price = $produdcts->product->final_price;
   }

        $tabeldata .= "<tr>

        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>" .$produdcts->product->custom_product_id." </td>
        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'> $imagevarraible </td>
        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'> ".$produdcts->product->item_title." </td>
        <td style='padding:15px 20px; border-bottom:solid 1px #dadada;'>$".$price." </td>
        </tr>";

    }

  $tabeldata .= "<tr>

  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'><strong>Total $$total </strong></td>
  </tr></table>";


  return $tabeldata;

}



public static function GetTabelProductDataForAdmin($Productdata)
{
    $tabeldata = "";
    $tabeldata .= "<table width='100%' border='0' cellpadding='0' cellspacing='0' style='font-family:Arial, Helvetica, sans-serif;border: solid 1px #eaeaea;'>
    <tr>
    <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Seller Info</th>
     <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Product Id</th>
      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Image</th>
      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'>Title</th>
      <th style='text-align:left; background: #f1f1f1; padding:15px 20px; border-bottom:solid 1px #dadada;'>Price</th>
    </tr>";

    $total = 0;
    foreach($Productdata as $produdcts){

         if(!empty($produdcts->product->offer_price)){
          $total += $produdcts->product->offer_price;
            }else{
             $total += $produdcts->product->final_price;
            }

     $sellerinfo = User::where('id',$produdcts->product->user_id)->first();

     $sellerData = '';
     $sellerData .= $sellerinfo['first_name'].'<br/>';
     $sellerData .= $sellerinfo['bussiness_name'].'<br/>';
     $sellerData .= $sellerinfo['email'].'<br/>';
     $sellerData .= $sellerinfo['mobileno'];

   if(!empty($produdcts->product->mainphoto))
   {
      $imagevarraible = "<img src='".asset(Storage::url($produdcts->product->mainphoto))."' style='width:40px;'/>";
   }else{
      $imagevarraible = "<img src='". asset('img/NoPhone_grande.png')."' style='width:40px;'/>";
   }

   if(!empty($produdcts->product->offer_price)){
    $price = $produdcts->product->offer_price;
 }else{
  $price = $produdcts->product->final_price;
 }

        $tabeldata .= "<tr>
        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'> $sellerData </td>
        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'> " .$produdcts->product->custom_product_id."  </td>
        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'> $imagevarraible </td>
        <td style='padding:15px 20px; border-right:solid 1px #dadada; border-bottom:solid 1px #dadada;'> ".$produdcts->product->item_title." </td>
        <td style='padding:15px 20px; border-bottom:solid 1px #dadada;'>$ ".$price." </td>
        </tr>";

    }

  $tabeldata .= "<tr>
  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'>&nbsp;</td>
  <td style='padding:15px 20px;'><strong>Total $$total </strong></td>
  </tr></table>";


  return $tabeldata;
}


public static function SendOrderStatusEmailToAdmin($orderdata)
{
    $orderId = $orderdata->id;
    $BuyerId = $orderdata->user_id;
    $token = $orderdata->custom_order_id;

    if($orderdata->status == 2)
    {
       $status = 'Shipped';
    } elseif($orderdata->status == 3){
        $status = 'Delivered';
    }else{
      $status = 'Pending';
    }

    $userdata = User::where('id',$BuyerId)->first();
    $orderData = OrderDetail::where('order_id',$orderId)->with('product')->get();
    $tabeldata = Product::GetTabelProductDataForAdmin($orderData);

    $BuyerAddress = UserAddressBook::where([['user_id',$BuyerId],['status','2']])->first();
    $ShippingAddress = $BuyerAddress['shiping_name'].' '.$BuyerAddress['shipping_address_one'].' '.$BuyerAddress['shipping_suburb'].' '.$BuyerAddress['shipping_postcode'].' '.$BuyerAddress['shipping_mobileno'];


    $hook = "admin-order-status";
    $replacement['STATUS'] = $status;
    $replacement['LOGIN_URL'] = url('/').'/admin/login';
    $replacement['Name'] = $userdata->first_name;
    $replacement['EMAIL'] = $userdata->email;
    $replacement['MOBILENO'] = $userdata->mobileno;
    $replacement['CUSTOMER_DELIVERY_ADDRESS'] = $ShippingAddress;
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to(config('get.ADMIN_EMAIL'))->send(new \App\Mail\ManuMailer($data));

}


public static function SendOrderStatusEmailTocustomer($orderdata)
{
    $orderId = $orderdata->id;
    $BuyerId = $orderdata->user_id;
    $token = $orderdata->custom_order_id;
    $userdata = User::where('id',$BuyerId)->first();
    if($orderdata->status == 2)
    {
       $status = 'Shipped';
       $message = 'Please login and see order detail.';
    } elseif($orderdata->status == 3){
        $status = 'Delivered';
        $message = 'Please login and go to order detail and rat to this order.';
    }else{
      $status = 'Pending';
      $message = 'Please login and see order detail.';
    }
    $orderData = OrderDetail::where('order_id',$orderId)->with('product')->get();
    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "customer-order-status";
    $replacement['STATUS'] = $status;
    $replacement['USER_NAME'] = $userdata->first_name;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['ORDER_ID'] = $token;
    $replacement['MESSAGE'] = $message;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
}


public static function SendComplainAcceptRejectMailcustomer($complaindata,$message)
{
    $orderId = $complaindata->order_id;
    $BuyerId = $complaindata->user_id;
    $token = $complaindata->order->custom_order_id;
    $userdata = User::where('id',$BuyerId)->first();
    if($complaindata->status == 1)
    {
       $status = 'accepted';
    } elseif($complaindata->status == 2){
        $status = 'rejected';
    }else{
      $status = 'initiate Refund';
    }
    $orderData = OrderDetail::wherein('id',unserialize($complaindata->orderdetail_id))->with('product')->get();

    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "customer-complaint-status-email";

    $replacement['COMPLAINID'] = $complaindata->complaint_id;
    $replacement['STATUS'] = $status;
    $replacement['MESSAGE'] = $message;
    $replacement['USER_NAME'] = $userdata->first_name;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
}


public static function SendComplainAcceptRejectMailseller($complaindata,$message)
{
    $orderId = $complaindata->order_id;
    $BuyerId = $complaindata->user_id;
    $token = $complaindata->order->custom_order_id;
    $userdata = User::where('id',$BuyerId)->first();

    $BuyerAddress = UserAddressBook::where([['user_id',$BuyerId],['status','2']])->first();
    $ShippingAddress = $BuyerAddress['shiping_name'].' '.$BuyerAddress['shipping_address_one'].' '.$BuyerAddress['shipping_suburb'].' '.$BuyerAddress['shipping_postcode'].' '.$BuyerAddress['shipping_mobileno'];


    if($complaindata->status == 1)
    {
       $status = 'accepted';
    } elseif($complaindata->status == 2){
        $status = 'rejected';
    }else{
      $status = 'initiate refund';
    }

    $getsellerdata = OrderDetail::where('order_id',$orderId)->groupBy('seller_id')->get();




  foreach($getsellerdata as $complaindataval){

    $orderData = OrderDetail::where('seller_id',$complaindataval->seller_id)->wherein('id',unserialize($complaindata->orderdetail_id))->with('product.user')->get();

    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "seller-complain-status-email";

    $sellerdata = User::where('id',$complaindataval->seller_id)->first();
    $replacement['USER_NAME'] = $complaindataval->product->user->first_name;
    $replacement['COMPLAINID'] = $complaindata->complaint_id;
    $replacement['STATUS'] = $status;
    $replacement['MESSAGE'] = $message;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['Name'] = $userdata->first_name;
    $replacement['EMAIL'] = $userdata->email;
    $replacement['MOBILENO'] = $userdata->mobileno;
    $replacement['CUSTOMER_DELIVERY_ADDRESS'] = $ShippingAddress;
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];

    Mail::to($sellerdata['email'])->send(new \App\Mail\ManuMailer($data));
  }
}



public static function SendComplainRaisedMailTocustomer($complaindata,$message)
{
    $orderId = $complaindata->order_id;
    $BuyerId = $complaindata->user_id;
    $token = $complaindata->order->custom_order_id;
    $userdata = User::where('id',$BuyerId)->first();

    $orderData = OrderDetail::wherein('id',unserialize($complaindata->orderdetail_id))->with('product')->get();

    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "customer-return-order-email";

    $replacement['COMPLAINID'] = $complaindata->complaint_id;

    $replacement['MESSAGE'] = $message;
    $replacement['USER_NAME'] = $userdata->first_name;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
}


public static function SendComplainRaisedMailToseller($complaindata,$message)
{
    $orderId = $complaindata->order_id;
    $BuyerId = $complaindata->user_id;
    $token = $complaindata->order->custom_order_id;
    $userdata = User::where('id',$BuyerId)->first();

    $BuyerAddress = UserAddressBook::where([['user_id',$BuyerId],['status','2']])->first();
    $ShippingAddress = $BuyerAddress['shiping_name'].' '.$BuyerAddress['shipping_address_one'].' '.$BuyerAddress['shipping_suburb'].' '.$BuyerAddress['shipping_postcode'].' '.$BuyerAddress['shipping_mobileno'];

   $getsellerdata = OrderDetail::where('order_id',$orderId)->groupBy('seller_id')->get();

   foreach($getsellerdata as $complaindataval){

    $orderData = OrderDetail::wherein('id',unserialize($complaindata->orderdetail_id))->with('product')->get();

    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "seller-return-order-email";

    $sellerdata = User::where('id',$complaindataval->seller_id)->first();
    $replacement['USER_NAME'] = $complaindataval->product->user->first_name;
    $replacement['COMPLAINID'] = $complaindata->complaint_id;
    $replacement['MESSAGE'] = $message;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['Name'] = $userdata->first_name;
    $replacement['EMAIL'] = $userdata->email;
    $replacement['MOBILENO'] = $userdata->mobileno;
    $replacement['CUSTOMER_DELIVERY_ADDRESS'] = $ShippingAddress;
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];

    Mail::to($sellerdata['email'])->send(new \App\Mail\ManuMailer($data));
  }
}


public static function SendComplainRaisedMailToadmin($complaindata,$message)
{
    $orderId = $complaindata->order_id;
    $BuyerId = $complaindata->user_id;
    $token = $complaindata->order->custom_order_id;
    $userdata = User::where('id',$BuyerId)->first();

    $BuyerAddress = UserAddressBook::where([['user_id',$BuyerId],['status','2']])->first();
    $ShippingAddress = $BuyerAddress['shiping_name'].' '.$BuyerAddress['shipping_address_one'].' '.$BuyerAddress['shipping_suburb'].' '.$BuyerAddress['shipping_postcode'].' '.$BuyerAddress['shipping_mobileno'];

    $orderData = OrderDetail::wherein('id',unserialize($complaindata->orderdetail_id))->with('product')->get();

    $tabeldata = Product::GetTabelProductData($orderData);

    $hook = "admin-return-order-email";


    $replacement['USER_NAME'] = $userdata->first_name;
    $replacement['COMPLAINID'] = $complaindata->complaint_id;
    $replacement['MESSAGE'] = $message;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['Name'] = $userdata->first_name;
    $replacement['EMAIL'] = $userdata->email;
    $replacement['MOBILENO'] = $userdata->mobileno;
    $replacement['CUSTOMER_DELIVERY_ADDRESS'] = $ShippingAddress;
    $replacement['ORDER_ID'] = $token;
    $replacement['TABEL'] = $tabeldata;
    $data = ['template' => $hook, 'hooksVars' => $replacement];

    Mail::to(config('get.ADMIN_EMAIL'))->send(new \App\Mail\ManuMailer($data));

}


public static function SendOfferMailTocustomer($offerdatamail,$message)
{

    foreach($offerdatamail as $val){

    $tabeldata = Product::GetTabelProductData($offerdatamail);

    $hook = "customer-make-offere-email";
    $replacement['MESSAGE'] = $message;
    $replacement['PRICE'] = '$'.$val->buyer_offer_price;
    $replacement['USER_NAME'] = $val->user->first_name;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['TABEL'] = $tabeldata;

    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to($val->user->email)->send(new \App\Mail\ManuMailer($data));
    }
}


public static function SendOfferMailToseller($offerdatamail,$message)
{

    foreach($offerdatamail as $val){

    $tabeldata = Product::GetTabelProductData($offerdatamail);

    $hook = "seller-make-offer-email";
    $replacement['USER_NAME'] = $val->product->user->first_name;
    $replacement['MESSAGE'] = $message;
    $replacement['LOGIN_URL'] = url('/').'/login';
    $replacement['PRICE'] = '$'.$val->buyer_offer_price;
    $replacement['Name'] = $val->user->first_name;
    $replacement['EMAIL'] = $val->user->email;
    $replacement['MOBILENO'] = $val->user->mobileno;
    $replacement['TABEL'] = $tabeldata;

    $data = ['template' => $hook, 'hooksVars' => $replacement];
    Mail::to($val->product->user->email)->send(new \App\Mail\ManuMailer($data));
    }
}


public static function SendcounterMail($offerdatamail,$message,$receiverid)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
            $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$receiverid)->first();
        $hook = "counter-offer-email";
        $replacement['USER_NAME'] = $userdata->first_name;
        $replacement['SUBJECT'] = 'Counter offer added.Please login and check';
        $replacement['COUNTERMESSAGE'] = 'Counter offer added.please login and check';
        $replacement['MESSAGE'] = $message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        }
}


public static function offeracceptmail($offerdatamail,$LastcartId)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
            $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$val->user_id)->first();
        $hook = "offer-accept-mail";
        $replacement['USER_NAME'] = $userdata->first_name;
        $replacement['SUBJECT'] = 'Offer has been accepted by seller';
        $replacement['COUNTERMESSAGE'] = 'Congratulations, Offer accepted by seller please login and click on below payment link for make payment.';
        $replacement['payment_link'] = url('/').'/paymentlink/'.$LastcartId;
        $replacement['MESSAGE'] = $val->message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        }
}

public static function adminofferacceptmail($offerdatamail,$LastcartId)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
           $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$val->user_id)->first();
        $hook = "admin-offer-accept-mail";
        $replacement['BUYER_NAME'] = $userdata->first_name;
        $replacement['BUYER_EMAIL'] = $userdata->email;
        $replacement['SUBJECT'] = 'Offer has been accepted';
        $replacement['COUNTERMESSAGE'] = 'Congratulations, Offer has been accepted and payment link sent to buyer email address.';
        $replacement['payment_link'] = url('/').'/paymentlink/'.$LastcartId;
        $replacement['MESSAGE'] = $val->message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        //Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        Mail::to(config('get.ADMIN_EMAIL'))->send(new \App\Mail\ManuMailer($data));
        }
}

public static function offercancelmail($offerdatamail)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
            $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$val->user_id)->first();
        $hook = "offer-cancel-email";
        $replacement['USER_NAME'] = $userdata->first_name;
        $replacement['SUBJECT'] = 'Offer has been cancelled by seller';
        $replacement['COUNTERMESSAGE'] = 'Offer has been cancelled by seller.Please try with other project';

        $replacement['MESSAGE'] = $val->message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        }
}

public static function offeracceptmailbuyer($offerdatamail,$LastcartId)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
            $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$val->user_id)->first();
        $hook = "offer-accept-mail";
        $replacement['USER_NAME'] = $userdata->first_name;
        $replacement['SUBJECT'] = 'Offer has been accepted.';
        $replacement['COUNTERMESSAGE'] = 'Congratulations, Offer accepted please login and click on below payment link for make payment.';
        $replacement['payment_link'] = url('/').'/paymentlink/'.$LastcartId;
        $replacement['MESSAGE'] = $val->message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        }

}
public static function offeracceptmailseller($offerdatamail,$LastcartId)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
            $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$val->product->user_id)->first();
        $hook = "offer-accept-mail";
        $replacement['USER_NAME'] = $userdata->first_name;
        $replacement['SUBJECT'] = 'Offer has been accepted by buyer';
        $replacement['COUNTERMESSAGE'] = 'Congratulations, Offer accepted by buyer and below payment link send to buyer.';
        $replacement['payment_link'] = url('/').'/paymentlink/'.$LastcartId;
        $replacement['MESSAGE'] = $val->message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        }
}

public static function offercancelmailseller($offerdatamail)
{
    foreach($offerdatamail as $val){

        if(!empty($val->buyer_offer_price))
        {
          $price = $val->buyer_offer_price;
        }else{
            $price = $val->seller_offer_price;
        }

        $tabeldata = Product::GetTabelProductData($offerdatamail);
        $userdata = User::where('id',$val->product->user_id)->first();
        $hook = "offer-cancel-email";
        $replacement['USER_NAME'] = $userdata->first_name;
        $replacement['SUBJECT'] = 'Offer has been cancelled by buyer';
        $replacement['COUNTERMESSAGE'] = 'Offer has been cancelled by buyer.';

        $replacement['MESSAGE'] = $val->message;
        $replacement['LOGIN_URL'] = url('/').'/login';
        $replacement['PRICE'] = '$'.$price;

        $replacement['TABEL'] = $tabeldata;

        $data = ['template' => $hook, 'hooksVars' => $replacement];
        Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));
        }
}






}
