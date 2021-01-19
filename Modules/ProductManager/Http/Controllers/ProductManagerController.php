<?php

namespace Modules\ProductManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\UserManager\Entities\User;
use App\Repositories\Frontend\Pages\PagesRepository;
use Modules\SettingManager\Entities\Setting;
use Modules\SettingManager\Http\Requests\LogoRequest;
use Modules\SettingManager\Http\Requests\GeneralRequest;
use Modules\ProductManager\Entities\Product;
use Modules\ProductManager\Entities\RecentlyView;
use Illuminate\Support\Facades\DB;
use Modules\ProductManager\Http\Requests\ProductRequest;
use Modules\ProductManager\Http\Requests\Productstep2Request;
use Modules\CategoriesManager\Entities\Categories;
use Modules\DeviceManager\Entities\Device;
use Modules\ColorsManager\Entities\Colors;
use Modules\StoragesManager\Entities\Storages;
use Modules\BrokenDevicesManager\Entities\BrokenDevices;
use Modules\CarriersManager\Entities\Carriers;
use Modules\ProductManager\Entities\Chat;
use Modules\ProductManager\Entities\ProductImage;
use Illuminate\Support\Facades\Auth;
use Modules\ModelManager\Entities\Devicemodel;
use Modules\ShippingChargesManager\Entities\ShippingChagres;
use Modules\HeadlineOnesManager\Entities\HeadlineOnes;
use Modules\HeadlineTwosManager\Entities\HeadlineTwos;
use Modules\HeadlineThreesManager\Entities\HeadlineThrees;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\ProductManager\Entities\Cart;
use Modules\ProductManager\Entities\Order;
use Modules\ProductManager\Entities\OrderDetail;
use Modules\ProductManager\Entities\ReturnOrder;
use Modules\ProductManager\Entities\Ratting;
use Session;
use Validator;

class ProductManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */




    public function productDetail($id)
    {

        $logInedUser=\Auth::user();

        $Product = Product::where('product_slug' ,'=', $id)->with('ProductImages')->with('category')->first();

        if(!empty($Product)){
        $testyourdevices = BrokenDevices::where('status','1')->get();

        if(!empty($logInedUser->id) && $logInedUser->id == $Product->user_id){

        }elseif($Product->status == 1){

        }else{
            return redirect()->to('/');
        }



        if(!empty($logInedUser->id)){
        $sender_id = $logInedUser->id;
        $product_id = $Product->id;
        $receiver_id = $Product->user_id;

        $checkwishlist = Chat::where([['sender_id', '=',$logInedUser->id],['product_id','=',$product_id],['receiver_id','=',$receiver_id]])->get();
        $RecenlyView= new RecentlyView();
        $recentlyViewd = RecentlyView::where([['user_id' ,'=', $logInedUser->id],['product_id','=', $Product->id]])->count();


        if($recentlyViewd < 1){
           if($logInedUser->id != $Product->user_id){
                $RecenlyView->user_id= $logInedUser->id;
                $RecenlyView->product_id= $Product->id;
                $RecenlyView->status= 1;
                $RecenlyView->save();
           }
        }

        $cartdata = Cart::where([['user_id',$logInedUser->id],['from_offer',0]])->get();
                if(!empty($cartdata))
                {
                    $ProductArray = array();
                    foreach($cartdata as $cart){
                    array_push($ProductArray,$cart->product_id);
                     }

                     $hasproduct = $ProductArray;

                }else{

                    $hasproduct = array();
                }

        }else{
          $checkwishlist = [];

          $checksession = Session::has('cart');
         if($checksession)
         {
            $hasproduct = Session::get('cart');

        }else{
            $hasproduct = array();
        }

        }

        $colors = Colors::where('status','1')->get();
        $storages = Storages::where('status','1')->get();
        $carriers = Carriers::where('status','1')->get();



        return view('productmanager::detail',compact('hasproduct','colors','storages','carriers','Product','logInedUser','checkwishlist','testyourdevices'));
        }else{
            return redirect()->to('/');
        }
    }



    function recentlyViews(){

        $logInedUser=\Auth::user();

        $recenltyviews = RecentlyView::where([['user_id' ,'=', $logInedUser->id]])->with('product')->with('user')->take(9)->paginate();

        return view('productmanager::recently-views',compact('recenltyviews','logInedUser'));


    }



    public function others()
    {

        $others = DB::table('devices')->where('status','1')->skip(7)->take(30)->get()->toArray();
        return view('productmanager::others',compact('others'));
    }



    public function index()
    {
        return view('productmanager::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */

    public function addProduct()
    {   $logInedUser=\Auth::user();

        //$response = User::RetriveAccountOnStripe($logInedUser);



//        if(empty($response['data']['business_type']))
        if(empty($logInedUser->paypal_email))
        {
            //return redirect()->route('accountupdate');
           // return view('productmanager::accountupdate',compact('logInedUser'));
           return redirect('/accountupdate');
        }else{

        $categories = Categories::where('status','1')->orderBy('title', 'asc')->pluck('title', 'id', 'status');
        $categories->prepend('Select Brand', "");

        $Devices = Device::where('status','1')->orderBy('device_name', 'asc')->pluck('device_name', 'device_name', 'status');
        $Devices->prepend('Select Device', "");


        $Carriers = Carriers::where('status','1')->orderBy('carrier_name', 'asc')->pluck('carrier_name', 'id', 'status');
        $Carriers->prepend('Select Carrier', "");

        $DevicesModel = Devicemodel::where('status','1')->orderBy('model_name', 'asc')->get();


        $brokendevices = BrokenDevices::where('status','1')->orderBy('id', 'asc')->get();

        $colors =  Colors::where('status','1')->orderBy('id', 'asc')->pluck('color_name', 'color_name', 'status');
        $colors->prepend('Select Colour', "");

        $storage = Storages::where('status','1')->orderBy('id', 'asc')->pluck('storage_name', 'storage_name', 'status');
        $storage->prepend('Select Storage', "");

        $headlines1 = HeadlineOnes::where('status','1')->get();
        $headlines2 = HeadlineTwos::where('status','1')->get();
        $headlines3 = HeadlineThrees::where('status','1')->get();
        }

        return view('productmanager::addProduct',compact('categories','Devices','Carriers','logInedUser','DevicesModel','brokendevices','colors','storage','headlines1','headlines2','headlines3'));
    }


    public function accountupdate()
    {
        $logInedUser=\Auth::user();
        $response = User::RetriveAccountOnStripe($logInedUser);
         if(empty($response['data']['business_name']))
        {

          return view('productmanager::accountupdate',compact('logInedUser'));
        }else{

        return redirect('/addProduct');
        }

    }

     /**
     *
     * @param Request $request
     */
    public function addPaypalDetails(Request $request){
        try{
          $logInedUser=\Auth::user();
          $logInedUser->paypal_email = $request->paypal_email;
          if($logInedUser->save()){
              return redirect('/addProduct');
          } else {
              return redirect()->back();
          }
        } catch (\Exception $ex) {
             return redirect()->back();
        }
    }

    public function myInterest()
    {   $logInedUser=\Auth::user();


      $Product = Chat::where('sender_id', '=',$logInedUser->id)->groupBy('product_id')->with('productsdata')->take(9)->paginate();


        return view('productmanager::myInterest',compact('Product','logInedUser'));
    }



    public function mymessage($id)
    {

        $logInedUser=\Auth::user();

        $Product = Chat::where([['receiver_id', '=',$logInedUser->id],['product_id','=',$id],['status','!=','2']])->groupBy('sender_id')->with('userdatasender')->take(9)->paginate();



        return view('productmanager::mymessage',compact('Product', 'logInedUser'));


    }


    public function create()
    {
        return view('productmanager::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */



    public function addnewProduct(Request $request)
    {



        $logInedUser=\Auth::user();


        $array = collect($request)->except(['_token','product_image'])->all();


        try{


          $array['product_slug'] = $array['item_title'];

          if(!empty($request->has('imei_code')) && $request['imei_code'] != '') {
            $code = $request['imei_code'];
          }else{
            $code = $request['serial_number'];
          }

           $array['custom_product_id'] = $code;

            $insertproduct = Product::create($array);

            $PorductId = $insertproduct->id;




        }
        catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }

        //return view('productmanager::step2');
        return redirect('/step2/'.$PorductId);

       /* return redirect()->route('dashboard')->with('success', 'Product added successfully.
        Please wait while we review your listing.');*/

    }


    public function step2($Productid)
    {
        $logInedUser=\Auth::user();
        $products = Product::find($Productid);
        return view('productmanager::step2',compact('logInedUser','Productid','products'));
    }


    public function addstep2(Productstep2Request $request)
    {


        $logInedUser=\Auth::user();

        $array = collect($request)->except(['_token','product_image'])->all();
        $products = Product::find($request->productid);

        try{

            foreach($request->all() as $key => $value) {

                  if($request->file($key)){

                        $file     = $request->file($key);
                        $filename = $file->getClientOriginalName();

                        $path = $request->file($key)->storeAs(
                            'public/ProductImages', $filename
                            );
                        $array[$key] = $path;

                        DB::table('products')
                        ->where('id', $request->productid)
                        ->update([$key => $path]);

                    }

          }


          Product::SendEmailToSellerforAddnewListing($products);
          Product::SendEmailToAdminforAddnewListing($products);



        }
        catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }



       return redirect()->route('dashboard')->with('success', 'Your listing has been successfully submitted. Please wait while we review your listing.');
    }


    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('productmanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function editProduct($id)
    {   $logInedUser=\Auth::user();
        $products = Product::where([['id' ,'=', $id],['user_id','=',$logInedUser->id]])->with('ProductImages')->first();

        if(!empty($products)){
        $devicedata = Device::where('device_name' ,'=', $products->device_type)->first();

        $categories = Categories::where([['status','1'],['device_id',$devicedata->id]])->orderBy('title', 'asc')->pluck('title', 'id', 'status');
        $categories->prepend('Select Brand', "");


        $Devices = Device::where('status','1')->orderBy('device_name', 'asc')->pluck('device_name', 'device_name', 'status');
        $Devices->prepend('Select Device', "");

        $Carriers = Carriers::where('status','1')->orderBy('carrier_name', 'asc')->pluck('carrier_name', 'id', 'status');
        $Carriers->prepend('Select Carrier', "");


         $DevicesModel = Devicemodel::where([['status','1'],['category_id',$products->category_id]])->orderBy('model_name', 'asc')->get();

        /*if(!empty($products->broken_device_id)){
        $brokendevices = BrokenDevices::where('status','1')->whereIn('id', unserialize($products->broken_device_id))->get();
         }else{
           $brokendevices = [];
         }*/

         $brokendevices = BrokenDevices::where([['status','1'],['device_id',$devicedata->id]])->get();

        $colors =  Colors::where([['status','1'],['color_name',$products->colour]])->orderBy('id', 'asc')->pluck('color_name', 'color_name', 'status');
        $colors->prepend('Select Colour', "");

        $storage = Storages::where([['status','1'],['id',$products->storage]])->orderBy('id', 'asc')->pluck('storage_name', 'id', 'status');
        $storage->prepend('Select Storage', "");

        $headlines1 = HeadlineOnes::where('status','1')->get();
        $headlines2 = HeadlineTwos::where('status','1')->get();
        $headlines3 = HeadlineThrees::where('status','1')->get();

        return view('productmanager::addProduct',compact('products','categories','Devices','Carriers','logInedUser','DevicesModel','brokendevices','colors','storage','headlines1','headlines2','headlines3'));
        }else{
          return redirect()->to('/');
        }

         }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function editnewProduct(ProductRequest $request, $id)
    {

        $array = collect($request)->except(['_token'])->all();
        try{
            $products = Product::find($id);

           $array['product_slug'] = $array['item_title'];
           if(!empty($request->has('imei_code')) && $request['imei_code'] != '') {
            $code = $request['imei_code'];
          }else{
            $code = $request['serial_number'];
          }

           if(!empty($request->has('broken_device_id'))) {
            $array['broken_device_id'] = $request['broken_device_id'];
          }else{
            $array['broken_device_id'] = [];
          }

           $array['custom_product_id'] = $code;

            $products->fill($array);

            $insertproduct =  $products->save();


          }
          catch (\Illuminate\Database\QueryException $e) {
              return back()->withError($e->getMessage())->withInput();
          }

          return redirect('/step2/'.$id);
        //return redirect()->route('dashboard')->with('success', 'Product has been edit Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }


    public function deleteproduct($id)
    {

        DB::beginTransaction();
        $products = Product::where('id', '=', $id)->first();

            try{
                Order::where('product_id', $id)->delete();
                OrderDetail::where('product_id', $id)->delete();
                RecentlyView::where('product_id', $id)->delete();
                $products->delete();
                DB::commit();
                return redirect()->route('dashboard')->with('success', 'Product has been deleted Successfully!.');
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                return redirect()->route('dashboard')->with('success', 'Please try again.');
            }
            return $responce;

    }

    public function deleteimage($id)
    {


        DB::beginTransaction();
        $productimage = ProductImage::where('device_name', '=', $id)->first();

            try{
                $productimage->delete();
                DB::commit();
                $responce =  ['status' => true,'message' => 'This Product Image has been deleted Successfully!'];
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $responce =  ['status' => false,'message' => $e->getMessage()];
            }
            return $responce;
    }




 public function selectmenufacturer($id)
 {
    DB::beginTransaction();
    $device = Device::where('device_name', '=', $id)->first();

    $model = Categories::where([['device_id', '=', $device->id],['status','1']])->get();

     $response = '';
     $response .= '<select class="form-control" name="category_id">
     <option value="">Select Brand</option>';

    if(count($model)>0)
    {
          foreach($model as $val){
          $response .= '<option value='.$val["id"].'>'.$val["title"].'</option>';
          }


    }else{
        $response .= '<option value="">No Record found.</option>';
    }

     $response .= '</select>';

    echo $response; die;

 }


 public function selectbrokendevice($id)
 {
    DB::beginTransaction();
    $device = Device::where('device_name', '=', $id)->first();

   $model = BrokenDevices::where([['status','1'],['device_id',$device->id]])->get();



     $response = '';
     $status = '';
     $response .= '<ul class="chk-custom d-flex flex-wrap justify-content-between  flex-wrap chk-box-list">';

    if(count($model)>0)
    {
        $status = true;
          foreach($model as $val){
          $response .= "<li>
          <div class='chk'>
                  <input type='checkbox' id='$val->id' value='$val->id' name='broken_device_id[]'>
                  <label for='$val->id'></label>
          </div>
          <p>$val->broken_title</p>
          </li>";
          }


    }else{
        $status = false;
        $response .= '<li>
        <div class="chk">
                <input type="checkbox" id="" value="" name="broken_device_id[]">
                <label for=""></label>
        </div>
        <p>No any point listed.</p>
        </li>';
    }

     $response .= '</ul>';

     return $response  =  ['status' => $status,'message' => $response];



 }


 public function selectmodel($id)
 {


     DB::beginTransaction();


     $model = Devicemodel::where([['category_id', '=', $id],['status','1']])->get();

      $response = '';
      $response .= '<select class="form-control devieModel" name="device_model" onchange="getColourStorage(this)">
      <option value="">Select Model</option>';

     if(count($model)>0)
     {
           foreach($model as $val){
           $response .= '<option value='.$val["id"].'>'.$val["model_name"].'</option>';
           }


     }else{
         $response .= '<option value="">No Record found.</option>';
     }

      $response .= '</select>';

     echo $response; die;
}


 public function selectcolor($id)
    {


        DB::beginTransaction();

        $device = Devicemodel::where('id', '=', $id)->first();

        $model = Colors::where('status','1')->whereIn('id', unserialize($device->color_id))->get();

         $response = '';
         $response .= '<select class="form-control" name="colour">
         <option value="">Select Colour</option>';

        if(count($model)>0)
        {
              foreach($model as $val){
              $response .= '<option value='.$val["color_name"].'>'.$val["color_name"].'</option>';
              }



        }else{

            $response .= '<option value="">No Record found.</option>';
        }

         $response .= '</select>';

        echo $response; die;
 }


 public function selectstorage($id)
    {


        DB::beginTransaction();

        $device = Devicemodel::where('id', '=', $id)->first();

        $model = Storages::where('status','1')->whereIn('id',  unserialize($device->storage_id))->get();

         $response = '';
         $response .= '<select class="form-control" name="storage">
         <option value="">Select Storage</option>';

        if(count($model)>0)
        {
              foreach($model as $val){
              $response .= '<option value='.$val["id"].'>'.$val["storage_name"].'</option>';
              }


        }else{

            $response .= '<option value="">No Record found.</option>';
        }

         $response .= '</select>';

        echo $response; die;
 }

    public function totalsellingprice($price)
    {
        $charges = ShippingChagres::where('status', '=', 1)->get();
        $adminchareg = '10';
       foreach($charges as $val){

        $pricerange = explode('-',$val['sold_price']);

       $min = $pricerange[0];
       $max = $pricerange[1];

      if(($min <= $price) && ($max == 'above')){

        return $response  =  ['status' => true,'shippingCharge' => $val['charge_fee'],'SellingCharge' => $val['admin_charges']];


      } elseif(($min <= $price) && ($price <= $max)){

            $totalprice = $price + $adminchareg + $val['charge_fee'];

            return $response  =  ['status' => true,'shippingCharge' => $val['charge_fee'],'SellingCharge' => $val['admin_charges']];


        } elseif(($price <= $max) && ($max == 'above')){

            return $response  =  ['status' => true,'shippingCharge' => $val['charge_fee'],'SellingCharge' => $val['admin_charges']];

         }


       }

     }

     public function checkimeinumber($id)
     {
        $products = Product::where('imei_code' ,'=', $id)->get();

        if(isset($products)){
        if(count($products)>0){

            return $response  =  ['status' => false,'message' => 'IMEI Number already exist. Please try with other.'];


          }else{

                return $response  =  ['status' => true,'message' => 'IMEI Number not exist. Please try with other.'];

             }
        }else{

                return $response  =  ['status' => true,'message' => 'IMEI Number not exist. Please try with other.'];

             }
         }

      public function checkserialnumber($id)
      {
        $products = Product::where('serial_number' ,'=', $id)->get();

        if(isset($products)){
        if(count($products)>0){

            return $response  =  ['status' => false,'message' => 'Serial Number already exist. Please try with other.'];


          }else{

                return $response  =  ['status' => true,'message' => 'Serial Number not exist. Please try with other.'];

             }
         }else{

                return $response  =  ['status' => true,'message' => 'IMEI Number not exist. Please try with other.'];

             }

      }


    public function message($id)
    {

        $logInedUser=\Auth::user();
        $products = Product::where('id' ,'=', $id)->with('ProductImages')->first();
        $productId = $id;
        $senderid = $products->user_id;


        Chat::where('sender_id', $senderid)->where('receiver_id', auth()->id())->where('product_id',$productId)->update(['status' => 1]);

                        $totalMessage = Chat::where(function($q) use ($senderid,$id) {
                            $q->where('sender_id', auth()->id());
                            $q->where('receiver_id', $senderid);
							$q->where('product_id', '=', $id);
                        })->orWhere(function($q) use ($senderid,$id) {
                            $q->where('sender_id', $senderid);
                            $q->where('receiver_id',  auth()->id());
							$q->where('product_id', '=', $id);
                        })->get();


        return view('productmanager::message',compact('products','productId','logInedUser','totalMessage','senderid'));


    }


    public function sellermessage($id,$senderid)
    {

        $logInedUser=\Auth::user();
        $products = Product::where('id' ,'=', $id)->with('ProductImages')->first();
        $productId = $id;

        Chat::where('sender_id', $senderid)->where('receiver_id', auth()->id())->where('product_id',$productId)->update(['status' => 1]);


        $totalMessage = Chat::where(function($q) use ($senderid,$id) {
            $q->where('sender_id', auth()->id());
            $q->where('receiver_id', $senderid);
            $q->where('product_id', '=', $id);
        })->orWhere(function($q) use ($senderid,$id) {
            $q->where('sender_id', $senderid);
            $q->where('receiver_id',  auth()->id());
            $q->where('product_id', '=', $id);
        })->get();

                //echo "<pre>";
              // print_r($totalMessage); die;



        return view('productmanager::message',compact('products','productId','logInedUser','totalMessage','senderid'));


    }





    public function addnewmessage(Request $request)
    {
        $logInedUser=\Auth::user();

        $insertMessage = chat::create($request->all());

        $productId = $request->product_id;
        $products = Product::where('id' ,'=', $productId)->with('ProductImages')->first();

        return redirect()->back();
   }


   public function addtowishlist(Request $request)
    {
        $logInedUser=\Auth::user();

        $insertMessage = chat::create($request->all());


        return redirect('myInterest')->with('success', 'Product has been added to wishlist.');
   }



   public function getdevices($id)
    {


        DB::beginTransaction();


        $Devices = Device::where('category_id', '=', $id)->orderBy('device_name', 'asc')->pluck('device_name', 'device_name', 'status');
        $Devices->prepend('Select Device type', "");

       try{

         $returnHTML = view('productmanager::devicelist',compact('Devices'));
          $responce = response()->json( array('success' => true, 'html'=>$returnHTML) );

               // $responce =  ['status' => true,'message' => 'This Product Image has been deleted Successfully!'];
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $responce =  ['status' => false,'message' => $e->getMessage()];
            }
            return $responce;
    }


    public function addimagesintoDatabase($request)
    {
       dd($request->all());


    }


  public function addtocartproduct($id) {

    $checksession = Session::has('cart');

    $logInedUser=\Auth::user();

    if(!empty($logInedUser))
    {
        $checkproductincart = Cart::where([['user_id',$logInedUser->id],['product_id',$id]])->get();
        if(count($checkproductincart)>0)
        {

        }else {
        $date = date('Y-m-d H:i:s');
        $values = array('user_id' => $logInedUser->id,'product_id'=>$id,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
        $cardupdated = DB::table('carts')->insert($values);
        }

    }else {

           if($checksession)
            {

                $Productold = Session::get('cart');
                if (in_array($id, $Productold)){


                }else{

                    $ProductArray = Session::get('cart');
                    array_push($ProductArray,$id);
                    Session::put('cart', $ProductArray);

                }


            }else{

                $ProductArray = array();
                array_push($ProductArray,$id);
                Session::put('cart', $ProductArray);

            }
 }

    return $response  =  ['status' => true,'message' => 'Product added in cart.'];

  }


  public function DirectCartPage($id) {

    $checksession = Session::has('cart');

    $logInedUser=\Auth::user();

    if(!empty($logInedUser))
    {
        $checkproductincart = Cart::where([['user_id',$logInedUser->id],['product_id',$id]])->get();

       if(count($checkproductincart)>0)
       {

       }else {
        $date = date('Y-m-d H:i:s');
        $values = array('user_id' => $logInedUser->id,'product_id'=>$id,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
        $cardupdated = DB::table('carts')->insert($values);
       }

    }else {

        if($checksession)
            {

                $Productold = Session::get('cart');
                if (in_array($id, $Productold)){


                }else{

                    $ProductArray = Session::get('cart');
                    array_push($ProductArray,$id);
                    Session::put('cart', $ProductArray);

                }


            }else{

                $ProductArray = array();
                array_push($ProductArray,$id);
                Session::put('cart', $ProductArray);

            }
    }

    return $response  =  ['status' => true,'message' => 'Product added in cart.'];

  }


public function cart()
{
    $logInedUser=\Auth::user();

    if(!empty($logInedUser)){

        $cartdata = DB::table('carts')->where([['user_id',$logInedUser->id],['from_offer',0]])->get();


        if(!empty($cartdata))
        {   $ProductArray = array();
            foreach($cartdata as $cart){
            array_push($ProductArray,$cart->product_id);
             }
        }else{
            $ProductArray = array();
        }

        $productData = Product::whereIn('id' , $ProductArray)->get();


    }else{

    $checksession = Session::has('cart');

    Session::put('currentroute', 'cart');

   if($checksession)
    {

        $cartproduct = Session::get('cart');


        $productData = Product::whereIn('id' , $cartproduct)->get();


    }else{

        $productData = array();

    }
}

    return view('productmanager::cart',compact('productData','logInedUser'));

}


public function RemoveItemFromCart($id)
{

    $logInedUser=\Auth::user();
    if(!empty($logInedUser))
    {
        DB::table('carts')->where([['product_id',$id],['user_id',$logInedUser->id]])->delete();

     }
    else{
        $cartproduct = Session::get('cart');
        $key = array_search($id, $cartproduct);
        unset($cartproduct[$key]);


        Session::put('cart', $cartproduct);
        $productData = Product::whereIn('id' , $cartproduct)->get();
    }
   // return $response  =  ['status' => true,'message' => 'Item Removed.'];

   return back()->withSuccess('Item has been removed successfully.')->withInput();
   //return view('productmanager::cart',compact('productData'));

}

public function checkout()
{
    $logInedUser=\Auth::user();

    if(!empty($logInedUser)){

       $userAddress = UserAddressBook::where('user_id',$logInedUser->id)->orderBy('status', 'DESC')->get();

        if(!empty($userAddress)){
            $userAddress = $userAddress;
         }else{
            $userAddress = array();
         }

            $checksession = Session::has('cart');
            if($checksession)
            {   $cartproduct = Session::get('cart');

                $productData = Product::where('is_sold','0')->where(function ($query) use($cartproduct) {
                    $query->whereIn('id' , $cartproduct);
                })->get();

                if(count($productData)>0)
                {}else{
                    Session::forget('cart');
                    Cart::whereIn('product_id', $cartproduct)->delete();
                    return redirect('cart')->with('success', 'Item has sold out.');
                    //return view('productmanager::cart',compact('productData','logInedUser'));
                }

                foreach($cartproduct as $val)
                {
                    $productdata = Product::where('user_id',$logInedUser->id)->pluck('id')->toArray();

                    if (in_array($val, $productdata))
                    {
                        Session::forget('cart');
                        $productData = [];
                        return view('productmanager::cart',compact('productData','logInedUser'));
                    }else{

                    $alreadyInCart = DB::table('carts')->where([['user_id',$logInedUser->id],['product_id',$val]])->get();
                    if(count($alreadyInCart)== 0)
                    {
                    $date = date('Y-m-d H:i:s');
                    $values = array('user_id' => $logInedUser->id,'product_id'=>$val,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
                    $cardupdated = DB::table('carts')->insert($values);
                    }
                  }
                }



            }else{
                $productData = array();
            }

          $cartdata = DB::table('carts')->where('user_id',$logInedUser->id)->get();


            if(!empty($cartdata))
            {   $ProductArray = array();
                foreach($cartdata as $cart){
                array_push($ProductArray,$cart->product_id);
                }
            }else{
                $ProductArray = array();
            }

           //$productData = Product::whereIn('id' , $ProductArray)->get();
           $productData = Product::where('is_sold','0')->where(function ($query) use($ProductArray) {
            $query->whereIn('id' , $ProductArray);
          })->get();


           if(count($productData)>0)
                {}else{

                    Session::forget('cart');
                    Cart::whereIn('product_id', $ProductArray)->delete();
                    return redirect('cart')->with('success', 'Item has sold out.');
                    //return view('productmanager::cart',compact('productData','logInedUser'));
                }



    }else {

            $checksession = Session::has('cart');
            if($checksession)
            {   $cartproduct = Session::get('cart');

                foreach($cartproduct as $val)
                {
                    $alreadyInCart = DB::table('carts')->where([['user_id',$logInedUser->id],['product_id',$val]])->get();
                    if(count($alreadyInCart)== 0){
                    $date = date('Y-m-d H:i:s');
                    $values = array('user_id' => $logInedUser->id,'product_id'=>$val,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
                    $cardupdated = DB::table('carts')->insert($values);
                }
                }

                $productData = Product::whereIn('id' , $cartproduct)->get();
                if(count($productData)>0)
                {}else{
                    return view('productmanager::cart',compact('productData','logInedUser'));
                }
            }else{
                $productData = array();
            }
   }
    return view('productmanager::checkout',compact('productData','logInedUser','userAddress'));
}


public function paymentlink($cartid)
{
    $logInedUser=\Auth::user();

    if(!empty($logInedUser)){

       $userAddress = UserAddressBook::where('user_id',$logInedUser->id)->orderBy('status', 'DESC')->get();

        if(!empty($userAddress)){
            $userAddress = $userAddress;
         }else{
            $userAddress = array();
         }

            $checksession = Session::has('cart');
            if($checksession)
            {   $cartproduct = Session::get('cart');

                $productData = Product::where('is_sold','0')->where(function ($query) use($cartproduct) {
                    $query->whereIn('id' , $cartproduct);
                })->get();

                if(count($productData)>0)
                {}else{
                    Session::forget('cart');
                    Cart::whereIn('product_id', $cartproduct)->delete();
                    return redirect('cart')->with('success', 'Item has sold out.');
                    //return view('productmanager::cart',compact('productData','logInedUser'));
                }

                foreach($cartproduct as $val)
                {
                    $productdata = Product::where('user_id',$logInedUser->id)->pluck('id')->toArray();

                    if (in_array($val, $productdata))
                    {
                        Session::forget('cart');
                        $productData = [];
                        return view('productmanager::cart',compact('productData','logInedUser'));
                    }else{

                    $alreadyInCart = DB::table('carts')->where([['user_id',$logInedUser->id],['product_id',$val]])->get();
                    if(count($alreadyInCart)== 0)
                    {
                    $date = date('Y-m-d H:i:s');
                    $values = array('user_id' => $logInedUser->id,'product_id'=>$val,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
                    $cardupdated = DB::table('carts')->insert($values);
                    }
                  }
                }



            }else{
                $productData = array();
            }

           $cartdata = DB::table('carts')->where([['user_id',$logInedUser->id],['id',$cartid]])->get();


            if(!empty($cartdata))
            {   $ProductArray = array();
                foreach($cartdata as $cart){
                array_push($ProductArray,$cart->product_id);
                }
            }else{
                $ProductArray = array();
            }

           //$productData = Product::whereIn('id' , $ProductArray)->get();
           $productData = Product::where('is_sold','0')->where(function ($query) use($ProductArray) {
            $query->whereIn('id' , $ProductArray);
          })->get();


           if(count($productData)>0)
                {}else{

                    Session::forget('cart');
                    Cart::whereIn('product_id', $ProductArray)->delete();
                    return redirect('cart')->with('success', 'Item has sold out.');
                    //return view('productmanager::cart',compact('productData','logInedUser'));
                }



    }else {

            $checksession = Session::has('cart');
            if($checksession)
            {   $cartproduct = Session::get('cart');

                foreach($cartproduct as $val)
                {
                    $alreadyInCart = DB::table('carts')->where([['user_id',$logInedUser->id],['product_id',$val]])->get();
                    if(count($alreadyInCart)== 0){
                    $date = date('Y-m-d H:i:s');
                    $values = array('user_id' => $logInedUser->id,'product_id'=>$val,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
                    $cardupdated = DB::table('carts')->insert($values);
                }
                }

                $productData = Product::whereIn('id' , $cartproduct)->get();
                if(count($productData)>0)
                {}else{
                    return view('productmanager::cart',compact('productData','logInedUser'));
                }
            }else{
                $productData = array();
            }
   }
    return view('productmanager::paymentlink',compact('productData','logInedUser','userAddress'));
}


/*public function saveorder(Request $request)
{

    $logInedUser=\Auth::user();
    $cartdata = DB::table('carts')->where('user_id',$logInedUser->id)->get();

    foreach($cartdata as $cart)
    {
        $Product = Product::where([['id',$cart->product_id],['is_sold',0]])->get();

           if(count($Product)>0)
            {}else{
                    Session::forget('cart');
                    Cart::where('product_id', $cart->product_id)->delete();
                    $responce =  ['status' => false,'message' => 'Item has sold out.'];
                    //return view('productmanager::cart',compact('productData','logInedUser'));
                }
    }



   if(count($cartdata)>0){

    if(isset($request->addressid))
    {
        UserAddressBook::where('id',  $request->addressid)->update([
            'status' => '1'
         ]);
         UserAddressBook::where('id', $request->addressid)->update([
            'status' => '2'
         ]);
    }else{
        UserAddressBook::where('user_id', $logInedUser->id)->update([
            'status' => '1'
         ]);
       $SaveAddress = UserAddressBook::create($request->all());
    }


    $token = $request->stripeToken;
    $amount = $request->amount * 100;
    $buyerId = $request->user_id;

    \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));
    $charge = \Stripe\Charge::create(['amount' => $amount, 'currency' => 'aud', 'source' => $token]);

    if($charge->status == 'succeeded'){

     $date = date('Y-m-d H:i:s');

    $length = 10;
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLM0123456789";
    $codeAlphabet.= "0123456789NOPQRSTUVWXYZ";
    $max = strlen($codeAlphabet); // edited
    for ($i=0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max-1)];
    }

     $values = array('custom_order_id'=>$token,'user_id' => $buyerId,'total_amount'=> $request->amount,'transcation_id'=>$charge->balance_transaction,'charge_id'=>$charge->id,'status'=>'1','created_at'=>$date,'updated_at'=>$date,'order_date'=>$date);
     $orderId = DB::table('orders')->insertGetId($values);

     $cartdata = DB::table('carts')->where('user_id',$logInedUser->id)->get();

     foreach($cartdata as $cart)
     {
         $Product = Product::where('id' ,'=', $cart->product_id)->first();

        $date = date('Y-m-d H:i:s');
        $values = array('order_id' => $orderId,'seller_id'=>$Product->user_id,'product_id'=> $cart->product_id,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
        $orderRecord = DB::table('order_details')->insert($values);

        DB::table('products')->where('id', $cart->product_id)->update(['is_sold' => 1]);

       DB::table('carts')->where([['user_id', $logInedUser->id],['product_id',$cart->product_id]])->delete();

     }

     if($request->offer == 1)
     {   $charges = ShippingChagres::where('status', '=', 1)->orderBy('id','DESC')->get();
        $price = round($request->amount);

        foreach($charges as $val){
        $pricerange = explode('-',$val['sold_price']);
        $min = $pricerange[0];
        $max = $pricerange[1];
        if(($min <= $price) && ($max == 'above')){
        $shippingCharge = $val['admin_charges'];
        } elseif(($min <= $price) && ($price <= $max)){
         $shippingCharge = $val['admin_charges'];
        } elseif(($price <= $max) && ($max == 'above')){
         $shippingCharge = $val['admin_charges'];
        }
       }

        foreach($cartdata as $cart)
        {

          DB::table('products')->where('id', $cart->product_id)->update([
             'offer_price' => $request->amount,
             'admin_charge'=>$shippingCharge
             ]);

         }
     }

     Product::SendOrderEmailTocustomer($orderId,$logInedUser,$token);
     Product::SendOrderEmailToSeller($orderId,$logInedUser,$token);
     Product::SendOrderEmailToAdmin($orderId,$logInedUser,$token);



     $checksession = Session::has('cart');
     if($checksession)
     {
        Session::forget('cart');
     }

     $responce =  ['status' => true,'orderid'=>$token,'message' => 'Payment Successfully done'];
    }
    else{
        $responce =  ['status' => false,'message' => 'Payment not done, please try again'];
     }
     return $responce;

    }else{
        $responce =  ['status' => false,'message' => 'Your cart is empty.Please add product in cart'];
    }
    return $responce;

}*/


public function saveorder(Request $request)
{

    $logInedUser=\Auth::user();
    $cartdata = DB::table('carts')->where('user_id',$logInedUser->id)->get();

    foreach($cartdata as $cart)
    {
        $Product = Product::where([['id',$cart->product_id],['is_sold',0]])->get();

           if(count($Product)>0)
            {}else{
                    Session::forget('cart');
                    Cart::where('product_id', $cart->product_id)->delete();
                    $responce =  ['status' => false,'message' => 'Item has sold out.'];
                    //return view('productmanager::cart',compact('productData','logInedUser'));
                }
    }



   if(count($cartdata)>0){

    if(isset($request->addressid))
    {
        UserAddressBook::where('user_id',  $logInedUser->id)->update([
            'status' => '1'
         ]);
         UserAddressBook::where('id', $request->addressid)->update([
            'status' => '2'
         ]);
    }else{
        UserAddressBook::where('user_id', $logInedUser->id)->update([
            'status' => '1'
         ]);
       $SaveAddress = UserAddressBook::create($request->all());
    }





     $amount = $request->amount * 100;
     $buyerId = $request->user_id;

     $date = date('Y-m-d H:i:s');

    $length = 10;
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLM0123456789";
    $codeAlphabet.= "0123456789NOPQRSTUVWXYZ";
    $max = strlen($codeAlphabet); // edited
    for ($i=0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max-1)];
    }
    foreach($cartdata as $cart)
    {
        $cart->product_id;
    }



    $array = array();
    $array['product_id'] = $cart->product_id;

    $validator = Validator::make($array, [
       'product_id' => 'unique:orders,product_id',
    ]);



    if($validator->fails()) {
        Cart::where('product_id', $cart->product_id)->delete();
        return $responce =  ['status' => false,'message' => 'Sorry , you are late item sod.'];

    }

    $values = array('custom_order_id'=>$token,'user_id' => $buyerId, 'product_id'=>$cart->product_id,'total_amount'=> $request->amount,'status'=>'1','created_at'=>$date,'updated_at'=>$date,'order_date'=>$date);
    $orderId = DB::table('orders')->insertGetId($values);


    $stripetoken = $request->stripeToken;

    \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));
    $charge = \Stripe\Charge::create(['amount' => $amount, 'currency' => 'aud', 'source' => $stripetoken]);

     if($charge->status == 'succeeded'){

        DB::table('orders')->where('id', $orderId)->update([
            'transcation_id' => $charge->balance_transaction,
            'charge_id'=>$charge->id
            ]);

     $cartdata = DB::table('carts')->where('user_id',$logInedUser->id)->get();

     foreach($cartdata as $cart)
     {
         $Product = Product::where('id' ,'=', $cart->product_id)->first();

        $date = date('Y-m-d H:i:s');
        $values = array('order_id' => $orderId,'seller_id'=>$Product->user_id,'product_id'=> $cart->product_id,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
        $orderRecord = DB::table('order_details')->insert($values);

        DB::table('products')->where('id', $cart->product_id)->update(['is_sold' => 1]);

       DB::table('carts')->where([['product_id',$cart->product_id]])->delete();

     }

     if($request->offer == 1)
     {   $charges = ShippingChagres::where('status', '=', 1)->orderBy('id','DESC')->get();
        $price = round($request->amount);

        foreach($charges as $val){
        $pricerange = explode('-',$val['sold_price']);
        $min = $pricerange[0];
        $max = $pricerange[1];
        if(($min <= $price) && ($max == 'above')){
        $shippingCharge = $val['admin_charges'];
        } elseif(($min <= $price) && ($price <= $max)){
         $shippingCharge = $val['admin_charges'];
        } elseif(($price <= $max) && ($max == 'above')){
         $shippingCharge = $val['admin_charges'];
        }
       }

        foreach($cartdata as $cart)
        {

          DB::table('products')->where('id', $cart->product_id)->update([
             'offer_price' => $request->amount,
             'admin_charge'=>$shippingCharge
             ]);

         }
     }

     Product::SendOrderEmailTocustomer($orderId,$logInedUser,$token);
     Product::SendOrderEmailToSeller($orderId,$logInedUser,$token);
     Product::SendOrderEmailToAdmin($orderId,$logInedUser,$token);



     $checksession = Session::has('cart');
     if($checksession)
     {
        Session::forget('cart');
     }

     $responce =  ['status' => true,'orderid'=>$token,'message' => 'Payment Successfully done'];
    }
    else{
        $responce =  ['status' => false,'message' => 'Payment not done, please try again'];
     }
     return $responce;

    }else{
        $responce =  ['status' => false,'message' => 'Your cart is empty.Please add product in cart'];
    }
    return $responce;

}

public function saveaddress(Request $request)
{

    $userdata = UserAddressBook::find($request->id);
    $userdata->fill($request->all());
    $insertaddress =  $userdata->save();
    $responce =  ['status' => true,'message' => 'Address has been updated succesfully.'];
    return $responce;

}


public function editaddress(Request $request){

    $useraddress = UserAddressBook::where('id',$request->id)->first();
    return view('productmanager::editaddress',compact('useraddress'));

}

public function thankyou($orderid)
{
    if(!empty($orderid)){
    $logInedUser=\Auth::user();
    return view('productmanager::thankyou',compact('logInedUser','orderid'));
    }else{
        return redirect()->to('/');
    }
}

public function shareurl(Request $request)
{
    Product::SendShareEmailToCustomer($request->all());

    return redirect()->back();

}


public function myOrder()
{
    $logInedUser=\Auth::user();
    $orderData = Order::where('user_id',$logInedUser->id)->orderBy('id','DESC')->with('OrderReturnData')->with('OrderDetailsData.product')->get();
    $Address = UserAddressBook::where([['user_id',$logInedUser->id],['status','2']])->first();

    return view('productmanager::myOrder',compact('logInedUser','orderData','Address'));

}

public function mySellingOrder()
{
    $logInedUser=\Auth::user();

    $orderData = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
        return $query->where('order_details.seller_id', $logInedUser->id);
    })->with([
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
    ])->orderBy('id','DESC')->get();

   return view('productmanager::mySellingOrder',compact('logInedUser','orderData'));

}


public function orderDetail($orderid)
{
    $logInedUser=\Auth::user();
    $orderData = Order::where([['id',$orderid],['user_id',$logInedUser->id]])->with('OrderReturnData')->with('OrderDetailsData.product')->with('rattingdata')->get();

    return view('productmanager::orderDetail',compact('logInedUser','orderData'));
}

public function SellerOrderDetail($orderid){

    $logInedUser=\Auth::user();
    //$orderData = Order::where('id',$orderid)->with('OrderReturnData')->with('OrderDetailsData.product')->get();

    $orderData = Order::where('id',$orderid)->whereHas('OrderDetailsData',function($query) use($logInedUser) {
        return $query->where('order_details.seller_id', $logInedUser->id);
    })->with([
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
        'rattingdata'
    ])->orderBy('id','DESC')->get();


    return view('productmanager::orderDetail',compact('logInedUser','orderData'));
}


public function updateorderstatus(Request $request)
{
    $date = date('Y-m-d H:i:s');
    Order::where('id', $request->order_id)->update([
           'status' => $request->status,
           'order_status_date' =>$date,
           'tracking_number'=>$request->trackingnumber
    ]);

     $orderData = Order::where('id', $request->order_id)->first();

     Product::SendOrderStatusEmailTocustomer($orderData);
     Product::SendOrderStatusEmailToAdmin($orderData);
     return redirect()->back();
}


public function returnorder(Request $request)
{
    $logInedUser=\Auth::user();
    $returData = ReturnOrder::where([['user_id',$logInedUser->id],['order_id',$request->id]])->first();

    $orderData = Order::where('id',$request->id)->with('OrderDetailsData.product')->get();
    return view('productmanager::returnorder',compact('orderData','returData','logInedUser'));

}

public function returnrequest(Request $request)
{
    $array = $request->all();
    $message = $request->return_reason;

   $checkorder = ReturnOrder::where([['order_id',$request->order_id],['status',0]])->first();

   $length = 8;
   $token = "";
   $codeAlphabet = "ABCDEFGHIJKLM0123456789";
    $codeAlphabet.= "0123456789NOPQRSTUVWXYZ";
   $max = strlen($codeAlphabet); // edited
   for ($i=0; $i < $length; $i++) {
   $token .= $codeAlphabet[random_int(0, $max-1)];
   }
if(!empty($request->orderdetail_id)){
   if(!empty($checkorder))
   {
     $array['return_order_date'] = date('Y-m-d H:i:s');
     $retunrdata = ReturnOrder::find($checkorder->id);

     $retunrdata->fill($array);
     $retunrdata->save();

   }else{
     $array['complaint_id'] = $token;
     $array['return_order_date'] = date('Y-m-d H:i:s');
     $RetunrData = ReturnOrder::create($array);
     $id = $RetunrData->id;
     $ReturnOrderData = ReturnOrder::where('id', $id)->with('order.user')->first();


     Product::SendComplainRaisedMailTocustomer($ReturnOrderData,$message);
     Product::SendComplainRaisedMailToseller($ReturnOrderData,$message);
     Product::SendComplainRaisedMailToadmin($ReturnOrderData,$message);

   }
    return back()->withSuccess('Return request successfully raised. Our staff will contact you shortly.')->withInput();
}else{
    return back()->withError('Return request not raised. Please try again.')->withInput();
}
//return redirect()->back();
}


public function myRevenue(Request $request){

    $logInedUser= \Auth::user();
    $method = $request->method();

    if($method == 'GET'){
    $senddate = date('Y-m-d H:i:s');
    $startdate = date('Y-m-d H:i:s', strtotime('-7 days', strtotime($senddate)));
    $monthdate = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($senddate)));

    //$monthlyorderData =  Order::where('is_return',0)->whereDate('order_date','>=',$monthdate.' 00:00:00')->whereDate('order_date','<=',$senddate)->with('OrderDetailsData.product.user')->get();

    $orderData = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
        return $query->where([['order_details.seller_id', $logInedUser->id],['is_transfer',1]]);
    })->with([
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
    ])->where([['is_return',0],['is_transfertoseller',1]])->whereDate('order_date','>=',$monthdate.' 00:00:00')->whereDate('order_date','<=',$senddate.' 23:59:59')->get();

    return view('productmanager::my-revenue',compact('orderData','logInedUser','senddate','monthdate'));

    }else{

    $senddate = date("Y-m-d", strtotime($request->start_date) );
    $monthdate = date("Y-m-d", strtotime($request->end_date) );


    //$monthlyorderData =  Order::where('is_return',0)->whereDate('order_date','>=',$monthdate.' 00:00:00')->whereDate('order_date','<=',$senddate)->with('OrderDetailsData.product.user')->get();

    $orderData = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
        return $query->where([['order_details.seller_id', $logInedUser->id]]);
    })->with([
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
    ])->where([['is_return',0],['is_transfertoseller',1]])->whereDate('order_date','>=',$senddate.' 00:00:00')->whereDate('order_date','<=',$monthdate.' 23:59:59')->get();

    return view('productmanager::my-revenue',compact('orderData','logInedUser','senddate','monthdate'));

    }

}


public function ratting(Request $request){

    $logInedUser= \Auth::user();
    $array = $request->all();

    $array['buyer_id'] = $logInedUser->id;
    $array['created_at'] = date('Y-m-d H:i:s');
    $Ratting = Ratting::create($array);

    DB::table('orders')
     ->where('id', $request->order_id)
     ->update(['rat' => $request->rat]);


     return back()->withSuccess('Ratting and Review submitted successfully.')->withInput();


}


}
