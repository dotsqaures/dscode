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
use Modules\ProductManager\Entities\Cart;
use Modules\ProductManager\Entities\Order;
use Modules\ProductManager\Entities\Ratting;
use Modules\ProductManager\Entities\OrderDetail;
use Modules\ProductManager\Entities\ReturnOrder;
use Modules\ShippingChargesManager\Entities\ShippingChagres;
use Modules\HeadlineOnesManager\Entities\HeadlineOnes;
use Modules\HeadlineTwosManager\Entities\HeadlineTwos;
use Modules\HeadlineThreesManager\Entities\HeadlineThrees;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\ColorsManager\Entities\Colors;
use Modules\StoragesManager\Entities\Storages;
use Modules\BrokenDevicesManager\Entities\BrokenDevices;
use Modules\CarriersManager\Entities\Carriers;
use Modules\ProductManager\Entities\RecentlyView;



class ProductController extends Controller
{

 public function Productlist(Request $request)
 {

    $products = Product::where([['status','=',1],['is_sold','=',0],['is_feature','=',1]])->categoryWise(request('category_id'))->orderBy('id', 'DESC')->with('ProductImages')->with('category')->with('user')->paginate(config('get.ADMIN_PAGE_LIMIT'));

    if(!empty($products))
    {
       return response([
            'message'   => trans('Product Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $products,
         ]);
         
         /* $data =   json_encode([
                        'message'   => 'Product Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $products,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Product Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }

 }

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

 public function ProductDetail(Request $request)
 {

    if (empty($request->product_id)) {

        return response([
            'message'   => trans('Please fill required field Product id.'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
        $id = $request->product_id;
        $Product = Product::where('id' ,'=', $id)->with('ProductImages')->with('category')->with('carriername')->with('storagename')->with('HeadlineOne')->with('HeadlineTwo')->with('HeadlineThree')->with('user')->first();
       if(isset($Product->broken_device_id)){
        $testyourdevices = BrokenDevices::whereIn('id',unserialize($Product->broken_device_id))->get();
       }else{
        $testyourdevices = [];
       }

        $send = array();

        $send['product'] = $Product;
        $send['Brokentest'] = $testyourdevices;

    if(!empty($Product))
    {
        return response([
            'message'   => trans('Product Detail.'),
            'status'   => true,
            'code' => 200,
            'data' => $send,
         ]);
         
          /* $data =   json_encode([
                        'message'   => 'Product Detail',
                        'status'   => true,
                        'code' => 200,
                        'data' => $send,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Product Detail not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }
}

 }


 public function myproductlist()
 {

    try {

        $user = Auth::user();
        $user_id = $user->id;
       // $products = Product::where('user_id', $user_id)->orderBy('id', 'DESC')->with('ProductImages')->with('user')->get();
        $products = Product::where('user_id', $user_id)->with('ProductImages')->with('category')->with('carriername')->with('storagename')->with('devicemodel')->with('device')->with('colorname')->with('HeadlineOne')->with('HeadlineTwo')->with('HeadlineThree')->with('user')->orderBy('is_feature', 'DESC')->orderBy('id','DESC')->get();
        $productarray  = array();

        foreach($products as $pro){
            $send = array();
            $totalUnreadMessage = DB::table('chats')->where([['receiver_id','=',$user_id],['product_id','=',$pro->id],['status','=',0]])->count();

            $send['id'] = $pro->id;
            $send['custom_product_id'] = $pro->custom_product_id;
            $send['category_id'] = $pro->category_id;
            $send['imei_code'] = $pro->imei_code;
            $send['serial_number'] = $pro->serial_number;
            $send['user_id'] = $pro->user_id;
            $send['device_type'] = $pro->device_type;
            $send['device_model'] = $pro->device_model;
            $send['storage'] = $pro->storage;
            $send['colour'] = $pro->colour;
            $send['item_title'] = $pro->item_title;
            $send['product_slug'] = $pro->product_slug;
            $send['location'] = $pro->location;
            $send['is_bill_avaialble'] = $pro->is_bill_avaialble;
            $send['phone_condition'] = $pro->phone_condition;
            $send['item_video'] = $pro->item_video;
            $send['item_description'] = $pro->item_description;
            $send['selling_price'] = $pro->selling_price;
            $send['shipping_charge'] = $pro->shipping_charge;
            $send['admin_charge'] = $pro->admin_charge;
            $send['final_price'] = $pro->final_price;
            $send['lowest_price'] = $pro->lowest_price;

            $send['imei_number_photo'] = $pro->imei_number_photo;
            $send['google_id_photo'] = $pro->google_id_photo;
            $send['mainphoto'] = $pro->mainphoto;
            $send['frontphoto'] = $pro->frontphoto;
            $send['backphoto'] = $pro->backphoto;

            $send['is_price_negotiable'] = $pro->is_price_negotiable;
            $send['created_at'] = date('Y-m-d',strtotime($pro->created_at));
            $send['star_ratting'] = $pro->star_ratting;
            $send['status'] = $pro->status;
            $send['is_feature'] = $pro->is_feature;
            $send['is_sold'] = $pro->is_sold;
            $send['messagecount'] = $totalUnreadMessage;
            $send['user'] = $pro->user;
            $send['category'] = $pro->category;
            $send['carriername'] = $pro->carriername;
            $send['storagename'] = $pro->storagename;
            $send['devicemodel'] = $pro->devicemodel;
            $send['device'] = $pro->device;
            $send['colorname'] = $pro->colorname;


            array_push($productarray,$send);

         }




         // The total number of items. If the `$items` has all the data, you can do something like this:
         $total = count($productarray);

         $perPage = 9;

         $currentPage = 1;

         $paginator = new \Illuminate\Pagination\LengthAwarePaginator($productarray, $total, $perPage, $currentPage);


        if(count($products)>0)
        {
           return response([
                'message'   => trans('Product list.'),
                'status'   => true,
                'code' => 200,
                'data' => $paginator,
             ]);
             
             
             /*$data =   json_encode([
                        'message'   => 'Product list',
                        'status'   => true,
                        'code' => 200,
                        'data' => $paginator,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

            return response([
                'message'   => trans('No listings found.'),
                'status'   => false,
                'code' => 400,

             ]);

        }


    }
    catch (\Exception $ex) {
        return response(array(
            'status' => false,
            'code' => 200,
            'message' => $ex->getMessage(),
                ), 201);
    }


 }




 public function searchfilterbyitem(Request $request)
 {

    $category = Categories::where('status','=',1)->orderBy('id', 'DESC')->get();
    $device = Device::where('status','=',1)->orderBy('id', 'ASC')->take(7)->get();


    $phonecondition = array("New" => 'Same as new', "Excellent"=>"Excellent", "Good"=>"Good", "Fair"=>"Fair");

    $data_output = array();
    $data_output['manufacturer'] = json_decode($category, true);
    $data_output['device'] = json_decode($device, true);
    $data_output['phonecondition'] = $phonecondition;


    if(!empty($category))
    {
        return response([
            'message'   => trans('Category listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $data_output,
         ]);
         
         /*$data =   json_encode([
                        'message'   => 'Category listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $data_output,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Category listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }

 }

 public function searchproduct(Request $request){

    if (empty($request->product_slug)) {

        return response([
            'message'   => trans('Please fill required field Product Slug.'),
            'status'   => false,
            'code' => 400,
        ]);
       } else {


            $devicetype = $request->product_slug;
            $builder = Product::query();
            $term = $request->all();
            $modeldata = Devicemodel::where('model_slug',$devicetype)->first();

            $modelnameforsearh  = $modeldata['id'];

            $builder->Where([['status', 1],['is_sold',0]]);


            if(!empty($modelnameforsearh)){

                $showcatchecked = $modelnameforsearh;
                $builder->where('device_model', $modelnameforsearh);

            }else{
                $showcatchecked = $modelnameforsearh = [];
            }

            if(!empty($term['device_name'])){
                $showdevicechecked = $term['device_name'];
                $builder->where('device_type' ,$term['device_name']);
            }else{
                $showdevicechecked = [];
            }


            if(!empty($term['storgae_id'])){
                $showstorage = $term['storgae_id'];
                $builder->whereIn('storage', $term['storgae_id']);
            }else{
                $showstorage = [];
            }


            if(!empty($term['carrier_id'])){
                $carrierids = $term['carrier_id'];
                $builder->whereIn('carrier_id', $term['carrier_id']);
            }else{
                $carrierids = [];
            }


            if(!empty($term['colors_name'])){
                $colourname = $term['colors_name'];
                $builder->whereIn('colour', $term['colors_name']);
            }else{
                $colourname = [];
            }



      if(isset($term['min-price']) || isset($term['max-price'])){
        if(($term['min-price'] > 0) && ($term['max-price']>0)){

                $builder->WhereBetween('final_price', array($term['min-price'], $term['max-price']));
                  $min = $term['min-price'];
                  $max = $term['max-price'];
                } elseif(($term['min-price'] == 0) && ($term['max-price']>0)){

                 $builder->WhereBetween('final_price', array($term['min-price'], $term['max-price']));
                      $min = $term['min-price'];
                      $max = $term['max-price'];
                } elseif(($term['min-price'] == 0) && ($term['max-price'] == 0)){

                        $builder->WhereBetween('final_price', array($term['min-price'], $term['max-price']));
                             $min = $term['min-price'];
                             $max = $term['max-price'];

                    }elseif(!empty($term['min-price'])){

                    $builder->Where('final_price', array($term['min-price']));
                    $min = $term['min-price'];
                    $max = '';

                 }else{

                    $min = '0';
                    $max = '5000';
                 }
                }else{

                    $min = '0';
                    $max = '5000';
                }


                if(!empty($term['sortByColumn'])){

                $getkey = explode("-",$term['sortByColumn']);

                $sorttby = $term['sortByColumn'];

                //$SearchProduct = $builder->orderBy('is_feature', 'DESC')->orderBy($getkey[0], $getkey[1])->paginate(9);
                $SearchProduct = $builder->orderBy('is_feature', 'DESC')->orderBy($getkey[0], $getkey[1])->with('colorname')->with('carriername')->with('storagename')->with('HeadlineOne')->with('HeadlineTwo')->with('HeadlineThree')->with('user')->paginate(9);
                }else{

                    $SearchProduct = $builder->orderBy('is_feature', 'DESC')->with('colorname')->with('carriername')->with('storagename')->with('HeadlineOne')->with('HeadlineTwo')->with('HeadlineThree')->with('user')->paginate(9);
                    $sorttby = '';

                }





            if(count($SearchProduct)>0)
         {
            return response([
                'message'   => trans('Product listings.'),
                'status'   => true,
                'code' => 200,
                'data' => $SearchProduct,
             ]);
             
             
             /*$data =   json_encode([
                        'message'   => 'Product listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $SearchProduct,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

            return response([
                'message'   => trans('No listings found.'),
                'status'   => false,
                'code' => 400,

             ]);

        }

        }


 }

 /*
 public function searchproduct(Request $request)
 {


            $builder = Product::query();
            $term = $request->all();

            if(!empty($term['productname']) && (!empty($term['cat_id']) || !empty($term['device_name']) || !empty($term['device_name']))){


               if(!empty($term['productname'])){
                   $builder->where([['item_title', 'LIKE', '%' . $term['productname'] . '%'],['status',1]]);
               }


                if(!empty($term['cat_id'])){

                $showcatchecked = $term['cat_id'];
                $builder->whereIn('category_id', $term['cat_id']);

            }else{
                $showcatchecked = $term['cat_id'] = [];
            }

            if(!empty($term['device_name'])){
                $showdevicechecked = $term['device_name'];
            $builder->whereIn('device_type' ,$term['device_name']);
            }else{
                $showdevicechecked = [];
            }


            if(!empty($term['min-price']) && !empty($term['max-price'])){

            $builder->WhereBetween('selling_price', array($term['min-price'], $term['max-price']));
            }


            if(!empty($term['phone_condition'])){
                $showphoneConditionCheck = $term['phone_condition'];
                $builder->whereIn('phone_condition' ,$term['phone_condition']);
            }else{
                $showphoneConditionCheck = [];
            }



            $builder->Where('status', 1);

            if(!empty($term['sortByColumn'])){

            $getkey = explode("-",$term['sortByColumn']);

            $SearchProduct = $builder->with('ProductImages')->orderBy($getkey[0], $getkey[1])->paginate(9);
            }else{

            $SearchProduct = $builder->with('ProductImages')->orderBy('id', 'DESC')->paginate(9);

            }


            }
             else if(!empty($term['productname']))
           {

            $showcatchecked = [];
            $showphoneConditionCheck = [];
            $showdevicechecked = [];

            $SearchProduct = Product::where([['item_title', 'LIKE', '%' . $term['productname'] . '%'],['status',1]])->with('ProductImages')->paginate(9);


           }else{


           if(!empty($term['cat_id'])){

                $showcatchecked = $term['cat_id'];

                $builder->whereIn('category_id', $term['cat_id']);
            }else{
                $showcatchecked = $term['cat_id'] = [];
            }

            if(!empty($term['device_name'])){
                $showdevicechecked = $term['device_name'];
            $builder->whereIn('device_type' ,$term['device_name']);
            }else{
                $showdevicechecked = [];
            }


            if(!empty($term['min-price']) && !empty($term['max-price'])){

            $builder->WhereBetween('selling_price', array($term['min-price'], $term['max-price']));
            }


            if(!empty($term['phone_condition'])){
                $showphoneConditionCheck = $term['phone_condition'];
                $builder->whereIn('phone_condition' ,$term['phone_condition']);
            }else{
                $showphoneConditionCheck = [];
            }

            $builder->Where('status', 1);

            if(!empty($term['sortByColumn'])){

            $getkey = explode("-",$term['sortByColumn']);

            $SearchProduct = $builder->with('ProductImages')->orderBy($getkey[0], $getkey[1])->paginate(9);
            }else{

            $SearchProduct = $builder->with('ProductImages')->orderBy('id', 'DESC')->paginate(9);

            }

        }

        if(count($SearchProduct)>0)
        {
            return response([
                'message'   => trans('Product listings'),
                'status'   => true,
                'code' => 200,
                'data' => $SearchProduct,
             ]);

        }else
        {

            return response([
                'message'   => trans('No listings found.'),
                'status'   => false,
                'code' => 400,

             ]);

        }



 }*/



 public function myInterestforbuyer()
 {

    try {

        $user = Auth::user();

        $user_id = $user->id;
        $Product = Chat::where('sender_id', '=',$user_id)->groupBy('product_id')->with('productsdata')->get();



        $productarray  = array();

        foreach($Product as $pro){


            $totalUnreadMessage = DB::table('chats')->where([['receiver_id','=',$user_id],['product_id','=',$pro->product_id],['status','=',0]])->count();



            $userddata = User::where('id','=', $pro['productsdata']['user_id'])->first();

            if(!empty($pro['productsdata']['id'])){
                $send = array();



            $send['id'] = $pro['productsdata']['id'];
            $send['custom_product_id'] = $pro['productsdata']['custom_product_id'];
            $send['category_id'] = $pro['productsdata']['category_id'];
            $send['imei_code'] = $pro['productsdata']['imei_code'];
            $send['serial_number'] = $pro['productsdata']['serial_number'];
            $send['user_id'] = $pro['productsdata']['user_id'];
            $send['device_type'] = $pro['productsdata']['device_type'];
            $send['device_model'] = $pro['productsdata']['device_model'];
            $send['storage'] = $pro['productsdata']['storage'];
            $send['colour'] = $pro['productsdata']['colour'];
            $send['item_title'] = $pro['productsdata']['item_title'];
            $send['product_slug'] = $pro->product_slug;
            $send['location'] = $pro['productsdata']['location'];
            $send['is_bill_avaialble'] = $pro['productsdata']['is_bill_avaialble'];
            $send['phone_condition'] = $pro['productsdata']['phone_condition'];

            $send['item_description'] = $pro['productsdata']['item_description'];
            $send['selling_price'] = $pro['productsdata']['selling_price'];
            $send['shipping_charge'] = $pro['productsdata']['shipping_charge'];
            $send['admin_charge'] = $pro['productsdata']['admin_charge'];
            $send['final_price'] = $pro['productsdata']['final_price'];
            $send['lowest_price'] = $pro['productsdata']['lowest_price'];

            $send['imei_number_photo'] = $pro['productsdata']['imei_number_photo'];
            $send['google_id_photo'] = $pro['productsdata']['google_id_photo'];
            $send['mainphoto'] = $pro['productsdata']['mainphoto'];
            $send['frontphoto'] = $pro['productsdata']['frontphoto'];
            $send['backphoto'] = $pro['productsdata']['backphoto'];

            $send['is_price_negotiable'] = $pro['productsdata']['is_price_negotiable'];
            $send['created_at'] = date('Y-m-d',strtotime($pro['productsdata']['created_at']));
            $send['star_ratting'] = $pro['productsdata']['star_ratting'];
            $send['status'] = $pro['productsdata']['status'];
            $send['is_feature'] = $pro['productsdata']['is_feature'];
            $send['is_sold'] = $pro['productsdata']['is_sold'];
            $send['messagecount'] = $totalUnreadMessage;
            $send['user'] = $userddata;

            $send['category'] = (object)[];
            $send['carriername'] = (object)[];
            $send['storagename'] = (object)[];
            $send['devicemodel'] = (object)[];
            $send['device'] = (object)[];
            $send['colorname'] = (object)[];

   }
            array_push($productarray,$send);

         }




         // The total number of items. If the `$items` has all the data, you can do something like this:
         $total = count($productarray);

         $perPage = 9;

         $currentPage = 1;

         $paginator = new \Illuminate\Pagination\LengthAwarePaginator($productarray, $total, $perPage, $currentPage);

    if(count($Product)>0)
        {
            return response([
                'message'   => trans('Watch list.'),
                'status'   => true,
                'code' => 200,
                'data' => $paginator,
             ]);
             
            /* $data =   json_encode([
                        'message'   => 'Watch list',
                        'status'   => true,
                        'code' => 200,
                        'data' => $paginator,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

            return response([
                'message'   => trans('Watch list not found.'),
                'status'   => false,
                'code' => 400,

             ]);

        }


    }
    catch (\Exception $ex) {
        return response(array(
            'status' => false,
            'code' => 200,
            'message' => $ex->getMessage(),
                ), 201);
    }


 }


public function sellermessageforproduct(Request $request){


    try {


        if (empty($request->product_id)) {

            return response([
                'message'   => trans('Product id is required.'),
                'status'   => false,
                'code' => 400,
            ]);
        }
        else {

            $user = Auth::user();

            $user_id = $user->id;
            $Product = Chat::where([['receiver_id', '=',$user_id],['product_id','=',$request->product_id],['status','!=','2']])->groupBy('sender_id')->with('userdatasender')->take(9)->paginate();

            
           
        if(count($Product)>0)
            {
                return response([
                    'message'   => trans('Message list.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $Product,
                ]);
                
                /* $data =   json_encode([
                        'message'   => 'Message list',
                        'status'   => true,
                        'code' => 200,
                        'data' => $Product,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

            }else
            {

                return response([
                    'message'   => trans('Message not found.'),
                    'status'   => false,
                    'code' => 400,

                ]);

            }
      }


    }
    catch (\Exception $ex) {
        return response(array(
            'status' => false,
            'code' => 200,
            'message' => $ex->getMessage(),
                ), 201);
    }

}


public function sentmessage(Request $request)
{
    try{

        if (empty($request->product_id) || empty($request->sender_id) || empty($request->receiver_id) || empty($request->message)) {

            return response([
                'message'   => trans('please fill all required field like product id, sender id, receiver id and message.'),
                'status'   => false,
                'code' => 400,
            ]);
        }
        else {

            $user = Auth::user();

            $insertMessage = chat::create($request->all());

            $receiverdata = User::find($request->receiver_id);

            $message = $request->message;
            $device_id = $receiverdata->device_id;
            $type = 'Chat Notification';
            $devicetype = $receiverdata->device_type;
            $login_user_name = $user->first_name.' '.$user->last_name;
            $sender_id = $request->sender_id;
            $receiver_id = $request->receiver_id;
            $productid = $request->product_id;

            $data_output = array();
            $data_output = $request->all();



            $this->push_notification_android($device_id, $message, $type, $devicetype , $login_user_name , $sender_id , $receiver_id,$data_output,$productid);




          return response([
                'message'   => trans('Message sent.'),
                'status'   => true,
                'code' => 200,
                'data' => $data_output,
            ]);
            
           /* $data =   json_encode([
                        'message'   => 'Message sent',
                        'status'   => true,
                        'code' => 200,
                        'data' => $data_output,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }


    }
    catch (\Exception $ex) {
        return response(array(
            'status' => false,
            'code' => 400,
            'message' => $ex->getMessage(),
                ), 201);
    }

}


public function addtowatchlist(Request $request)
{
    try{

        if (empty($request->product_id) || empty($request->sender_id) || empty($request->receiver_id) || empty($request->status)) {

            return response([
                'message'   => trans('please fill all required field like product id, sender id, receiver id.'),
                'status'   => false,
                'code' => 400,
            ]);
        }
        else {

            $user = Auth::user();

            $insertMessage = chat::create($request->all());


            $data_output = array();
            $data_output = $request->all();


            return response([
                'message'   => trans('Product added to watch list.'),
                'status'   => true,
                'code' => 200,
                'data' => $data_output,
            ]);
            
             /*$data =   json_encode([
                        'message'   => 'Product added to watch list',
                        'status'   => true,
                        'code' => 200,
                        'data' => $data_output,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }


    }
    catch (\Exception $ex) {
        return response(array(
            'status' => false,
            'code' => 400,
            'message' => $ex->getMessage(),
                ), 201);
    }

}


public function deleteproduct(Request $request)
{

    try{

        if (empty($request->product_id)) {

            return response([
                'message'   => trans('please fill all required field like product id.'),
                'status'   => false,
                'code' => 400,
            ]);
        }
        else {

            $logInedUser=\Auth::user();
            DB::beginTransaction();
            $products = Product::where('id', '=', $request->product_id)->first();
            Order::where('product_id', $request->product_id)->delete();
            OrderDetail::where('product_id', $request->product_id)->delete();
            RecentlyView::where('product_id', $request->product_id)->delete();
            $products->delete();
            DB::commit();

            $newproduct = array();

            return response([
                'message'   => trans('Product deleted.'),
                'status'   => true,
                'code' => 200,
                'data' => (object)$newproduct,
            ]);
            
            
           /* $data =   json_encode([
                        'message'   => 'Product deleted',
                        'status'   => true,
                        'code' => 200,
                        'data' => (object)$newproduct,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }

      }
      catch (\Exception $ex) {
        return response(array(
            'status' => false,
            'code' => 200,
            'message' => $ex->getMessage(),
                ), 201);
    }

}

public function allmessage(Request $request)
{ 
  try{

    if (empty($request->product_id) || empty($request->sender_id)) {

        return response([
            'message'   => trans('please fill all required field like product id, sender id.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {

        $logInedUser=\Auth::user();
        
        $products = Product::where('id' ,'=', $request->product_id)->with('ProductImages')->first();
        $id = $request->product_id;
        $senderid = $request->sender_id; 


       $messagelist = Chat::where(function($q) use ($senderid,$id) {
            $q->where('sender_id', auth()->id());
            $q->where('receiver_id', $senderid);
            $q->where('product_id', '=', $id);
            $q->where('status', '!=', 2);
        })->orWhere(function($q) use ($senderid,$id) {
            $q->where('sender_id', $senderid);
            $q->where('receiver_id',  auth()->id());
            $q->where('product_id', '=', $id);
            $q->where('status', '!=', 2);
        })->get();

        

        return response([
            'message'   => trans('Message sent.'),
            'status'   => true,
            'code' => 200,
            'data' => $messagelist,
        ]);
        
         /*$data =   json_encode([
                        'message'   => 'Message sent',
                        'status'   => true,
                        'code' => 200,
                        'data' => $messagelist,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }

  }
  catch (\Exception $ex) {
    return response(array(
        'status' => false,
        'code' => 200,
        'message' => $ex->getMessage(),
            ), 201);
}

}



 public function Categorylist(Request $request)
 {

    $category = Categories::where('status','=',1)->orderBy('id', 'DESC')->get();

    if(!empty($category))
    {
        return response([
            'message'   => trans('Category Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $category,
         ]);

    }else
    {

        return response([
            'message'   => trans('Category Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }

 }


 public function Devicelist(Request $request)
 {

    $devicelistarray = array();
    $device = Device::where('status','=',1)->orderBy('id', 'ASC')->take('7')->get();
    $others = Device::where('status','=',1)->orderBy('id', 'ASC')->skip('7')->take(20)->get();

    $devicelistarray['main']   =   $device;
    $devicelistarray['others']   =   ( object ) $others;



    if(!empty($device))
    {
       return response([
            'message'   => trans('Device Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $devicelistarray,
         ]);
         
          /*$data =   json_encode([
                        'message'   => 'Device Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $devicelistarray,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Device Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }

 }


 public function brandlist(Request $request){

    if (empty($request->device_id)) {

        return response([
            'message'   => trans('Device id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {

    $model = Categories::where([['device_id', '=', $request->device_id],['status','1']])->get();

    if(count($model)>0)
        {
        return response([
        'message'   => trans('Brand  Listings.'),
        'status'   => true,
        'code' => 200,
        'data' => $model,
        ]);
        
        /* =   json_encode([
                        'message'   => 'Brand  Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $model,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

        return response([
        'message'   => trans('Brand  Listings not found.'),
        'status'   => false,
        'code' => 400,

        ]);

        }
    }
 }


 public function modellist(Request $request){

    if (empty($request->brand_id)) {

        return response([
            'message'   => trans('Brand id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {

    $modellist = Devicemodel::where([['category_id', '=', $request->brand_id],['status','1']])->get();

    if(count($modellist)>0)
        {
        return response([
        'message'   => trans('model  Listings'),
        'status'   => true,
        'code' => 200,
        'data' => $modellist,
        ]);
        
        /*$data =   json_encode([
                        'message'   => 'model  Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $modellist,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

        return response([
        'message'   => trans('model  Listings not found.'),
        'status'   => false,
        'code' => 400,

        ]);

        }
    }
 }

 public function colorlist(Request $request){

    if (empty($request->model_id)) {

        return response([
            'message'   => trans('Model id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {

        $device = Devicemodel::where('id', '=', $request->model_id)->first();

        $colorlist = Colors::where('status','1')->whereIn('id', unserialize($device->color_id))->get();

    if(count($colorlist)>0)
        {
        return response([
        'message'   => trans('Colour  Listings.'),
        'status'   => true,
        'code' => 200,
        'data' => $colorlist,
        ]);
        
       /* $data =   json_encode([
                        'message'   => 'Colour  Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $colorlist,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

        return response([
        'message'   => trans('Colour  Listings not found.'),
        'status'   => false,
        'code' => 400,

        ]);

        }
    }

}

 public function storagelist(Request $request){

    if (empty($request->model_id)) {

        return response([
            'message'   => trans('Model id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {


        $device = Devicemodel::where('id', '=', $request->model_id)->first();

        $storagelist = Storages::where('status','1')->whereIn('id',  unserialize($device->storage_id))->get();

    if(count($storagelist)>0)
        {
       return response([
        'message'   => trans('Storage  Listings.'),
        'status'   => true,
        'code' => 200,
        'data' => $storagelist,
        ]);
        
       /* $data =   json_encode([
                        'message'   => 'Storage  Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $storagelist,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

        return response([
        'message'   => trans('Storage Listings not found.'),
        'status'   => false,
        'code' => 400,

        ]);

        }
    }
 }

public function carrierlist(){

    $carriers = Carriers::where('status','1')->get();

    if(count($carriers)>0)
        {
        return response([
        'message'   => trans('Carrier  Listings.'),
        'status'   => true,
        'code' => 200,
        'data' => $carriers,
        ]);
        
        /*$data =   json_encode([
                        'message'   => 'Carrier  Listings',
                        'status'   => true,
                        'code' => 200,
                        'data' => $carriers,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else
        {

        return response([
        'message'   => trans('Carrier Listings not found.'),
        'status'   => false,
        'code' => 400,

        ]);

        }
}


public function AddStep1(Request $request){


    $logInedUser = Auth::user();

    $response = User::RetriveAccountOnStripe($logInedUser);
   

    if(empty($response['data']['business_type']))
        {
            return response([
                'message'   => trans('Please update your bank detail.'),
                'status'   => false,
                'code' => 400,

                ]);

        }else{

    if(!empty($logInedUser)){

    $array = $request->all();

    if(empty($request['product_id'])){

    if(!empty($request->has('imei_code')) && $request['imei_code'] != '') {
            $code = $request['imei_code'];
            $products = Product::where('imei_code' ,'=', $code)->get();
            if(count($products)>0){
                return response([
                    'message'   => trans('IMEI Number already exist. Please try with other.'),
                    'status'   => false,
                    'code' => 400,

                    ]);
            }
      }else{
        $code = $request['serial_number'];
        $products = Product::where('serial_number' ,'=', $code)->get();
            if(count($products)>0){
                return response([
                    'message'   => trans('Serial Number already exist. Please try with other.'),
                    'status'   => false,
                    'code' => 400,

                    ]);
            }
      }



    $digit  = substr(str_replace(' ', '', $code), -7);
    $brandname = Categories::select('title')->where([['id', '=', $request->category_id],['status','1']])->first();
    $devicename = Devicemodel::select('model_name')->where('id', '=', $request->device_model)->first();
    if(!empty($request->storage)){
    $storagename = Storages::select('storage_name')->where('id',$request->storage)->first();
    }else{
        $storagename = '';
    }
    $carriersname = Carriers::select('carrier_name')->where('id',$request->carrier_id)->first();

    if(!empty($request->storage) && !empty($request->colour)){
    $array['item_title'] = $brandname->title.' '.$request->device_type.' '.$devicename->model_name.' '.$storagename->storage_name.' '.$request->colour.' '.$carriersname->carrier_name.' '.$digit;
    }else{
        $array['item_title'] = $brandname->title.' '.$request->device_type.' '.$devicename->model_name.' '.$request->colour.' '.$carriersname->carrier_name.' '.$digit;
    }

   if($request->storage == 0){
    $array['storage'] = '';
   }else{
    $array['storage'] = $request->storage;
   }
    $array['user_id'] = $logInedUser->id;
    $array['product_slug'] = $array['item_title'];
    $array['custom_product_id'] = $code;
    $insertproduct = Product::create($array);
    $PorductId = $insertproduct->id;

    $ProductsData = Product::where('id' ,'=', $PorductId)->first();

    $headlines1 = HeadlineOnes::where('status','1')->get();
    $headlines2 = HeadlineTwos::where('status','1')->get();
    $headlines3 = HeadlineThrees::where('status','1')->get();

    $step2data = array();

    $step2data['productdata'] = $ProductsData;
    $step2data['tagline1'] = $headlines1;
    $step2data['tagline2'] = $headlines2;
    $step2data['tagline3'] = $headlines3;


        return response([
            'message'   => trans('Added step 1 and redirect to step 2.'),
            'status'   => true,
            'code' => 200,
            'data' => $step2data,
        ]);


      /*$data =   json_encode([
                        'message'   => 'Added step 1 and redirect to step 2',
                        'status'   => true,
                        'code' => 200,
                        'data' => $step2data,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/


    }else{

        $array = $request->all();
        if(!empty($request->has('imei_code')) && $request['imei_code'] != '') {
            $code = $request['imei_code'];
            $products = Product::where([['id',$request->product_id],['imei_code', $code]])->first();

            if(isset($products)){
                if($products->imei_code == $code){

                } else{

                    $products = Product::where('imei_code' ,'=', $code)->get();
                    if(count($products)>0){
                        return response([
                            'message'   => trans('IMEI Number already exist. Please try with other.'),
                            'status'   => false,
                            'code' => 400,

                            ]);
                    }

                }
            }else{
                $products = Product::where('imei_code' ,'=', $code)->get();
                    if(count($products)>0){
                        return response([
                            'message'   => trans('IMEI Number already exist. Please try with other.'),
                            'status'   => false,
                            'code' => 400,

                            ]);
                    }
            }
      }else{
        $code = $request['serial_number'];
        $products = Product::where([['id',$request->product_id],['serial_number', $code]])->first();

        if(isset($products)){
            if($products->serial_number == $code){

            } else{

                $products = Product::where('serial_number' ,'=', $code)->get();
                if(count($products)>0){
                    return response([
                        'message'   => trans('Serial Number already exist. Please try with other.'),
                        'status'   => false,
                        'code' => 400,

                        ]);
                }

            }
        }else{
            $products = Product::where('serial_number' ,'=', $code)->get();
                if(count($products)>0){
                    return response([
                        'message'   => trans('Serial Number already exist. Please try with other.'),
                        'status'   => false,
                        'code' => 400,

                        ]);
                }
        }

      }



    $digit  = substr(str_replace(' ', '', $code), -7);
    $brandname = Categories::select('title')->where([['id', '=', $request->category_id],['status','1']])->first();
    $devicename = Devicemodel::select('model_name')->where('id', '=', $request->device_model)->first();
    if(!empty($request->storage)){
    $storagename = Storages::select('storage_name')->where('id',$request->storage)->first();
    }else{
        $storagename = '';
    }
    $carriersname = Carriers::select('carrier_name')->where('id',$request->carrier_id)->first();

    if(!empty($request->storage) && !empty($request->colour)){
    $array['item_title'] = $brandname->title.' '.$request->device_type.' '.$devicename->model_name.' '.$storagename->storage_name.' '.$request->colour.' '.$carriersname->carrier_name.' '.$digit;
    }else{
        $array['item_title'] = $brandname->title.' '.$request->device_type.' '.$devicename->model_name.' '.$request->colour.' '.$carriersname->carrier_name.' '.$digit;
    }

    $array['user_id'] = $logInedUser->id;
    $array['product_slug'] = $array['item_title'];
    $array['custom_product_id'] = $code;


    $products = Product::find($request->product_id);
    $products->fill($array);
    $insertproduct =  $products->save();


    $ProductsData = Product::where('id' ,'=', $request->product_id)->first();

    $headlines1 = HeadlineOnes::where('status','1')->get();
    $headlines2 = HeadlineTwos::where('status','1')->get();
    $headlines3 = HeadlineThrees::where('status','1')->get();

    $step2data = array();

    $step2data['productdata'] = $ProductsData;
    $step2data['tagline1'] = $headlines1;
    $step2data['tagline2'] = $headlines2;
    $step2data['tagline3'] = $headlines3;


        return response([
            'message'   => trans('Added step 1 and redirect to step 2.'),
            'status'   => true,
            'code' => 200,
            'data' => $step2data,
        ]);


         /*$data =   json_encode([
                        'message'   => 'Added step 1 and redirect to step 2',
                        'status'   => true,
                        'code' => 200,
                        'data' => $step2data,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/




    }

}else{
    return response([
        'message'   => trans('User not logged in.'),
        'status'   => false,
        'code' => 400,
        'data' => '',
    ]);
}


}


}


public function AddStep2(Request $request){
    $logInedUser = Auth::user();
    if(!empty($logInedUser)){

    $array = $request->all();
    $products = Product::find($request->product_id);
    $products->fill($array);
    $insertproduct =  $products->save();

    $ProductsData = Product::where('id' ,'=', $request->product_id)->first();
    $ShippingCharges = ShippingChagres::where('status', '=', 1)->get();

    $step3data = array();

    $step3data['ProductsData'] = $ProductsData;
    $step3data['ShippingCharges'] = $ShippingCharges;

   return response([
        'message'   => trans('Added step 2 and redirect to step 3.'),
        'status'   => true,
        'code' => 200,
        'data' => $step3data,
    ]);
    
    /*$data =   json_encode([
                        'message'   => 'Added step 2 and redirect to step 3',
                        'status'   => true,
                        'code' => 200,
                        'data' => $step3data,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else{
        return response([
            'message'   => trans('User not logged in.'),
            'status'   => false,
            'code' => 400,
        ]);
    }

}


public function AddStep3(Request $request){
    $logInedUser = Auth::user();
    if(!empty($logInedUser)){

    $array = $request->all();
    $products = Product::find($request->product_id);
    $products->fill($array);
    $insertproduct =  $products->save();

    $ProductsData = Product::where('id' ,'=', $request->product_id)->first();
    $ShippingCharges = ShippingChagres::where('status', '=', 1)->get();

    $step3data = array();

    $step3data['ProductsData'] = $ProductsData;

  return response([
        'message'   => trans('Added step 3 and redirect to step 4.'),
        'status'   => true,
        'code' => 200,
        'data' => $ProductsData,
    ]);
    
     /*$data =   json_encode([
                        'message'   => 'Added step 3 and redirect to step 4',
                        'status'   => true,
                        'code' => 200,
                        'data' => $ProductsData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else{
        return response([
            'message'   => trans('User not logged in.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
}



public function AddStep4(Request $request){
    $logInedUser = Auth::user();
    if(!empty($logInedUser)){

    $array = $request->all();


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
                    ->where('id', $request->product_id)
                    ->update([$key => $path]);

                }

      }

      $products = Product::find($request->product_id);

      $step4data = array();

     $step4data['ProductsData'] = $products;

     Product::SendEmailToSellerforAddnewListing($products);
     Product::SendEmailToAdminforAddnewListing($products);
     $ProductsData = Product::where('id' ,'=', $request->product_id)->first();

        return response([
            'message'   => trans('Your listing has been successfully submitted. Please wait while we review your listing.'),
            'status'   => true,
            'code' => 200,
            'data' => $ProductsData,
        ]);
        
        /*$data =   json_encode([
                        'message'   => 'Your listing has been successfully submitted. Please wait while we review your listing.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $ProductsData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }
    catch (\Illuminate\Database\QueryException $e) {
        return back()->withError($e->getMessage())->withInput();
    }

    }else{
        return response([
            'message'   => trans('User not logged in.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
}

public function featureData(){

  $price = config('get.feature-price');
  $duration = config('get.expire-feature-listing');

  $send = array();
  $send['price'] = $price;
  $send['duration'] = $duration;

 return response([
    'message'   => trans('Feature price and duration.'),
    'status'   => true,
    'code' => 200,
    'data' => $send,
]); 

/*$data =   json_encode([
                        'message'   => 'Feature price and duration.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $send,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/


}


public function makeitfeature(Request $request)
{
    $logInedUser = Auth::user();
    if (empty($request->product_id)) {

        return response([
            'message'   => trans('Product id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {


            try {

                \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));

                $stripetoken =  \Stripe\Token::create([
                   'card' => [
                     'number' => $request->card_number,
                     'exp_month' => $request->exp_month,
                     'exp_year' => $request->exp_year,
                     'cvc' => $request->cvc,
                   ],
                 ]);

              } catch(\Stripe\Exception\CardException $e) {


                return response([
                    'message'   => $e->getError()->message,
                    'status'   => false,
                    'code' => 200,
                ]);

              }catch(\Stripe\Exception\InvalidRequestException $e){

                return response([
                    'message'   => 'missing '.$e->getError()->param,
                    'status'   => false,
                    'code' => 200,
                ]);

              }

              $token = $stripetoken->id;
              $productID = $request->product_id;
              $price = config('get.feature-price');
              $amount = $price * 100;

             DB::table('products')
                            ->where('id', $productID)
                            ->update(['is_feature' => 1]);

            \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));
            $charge = \Stripe\Charge::create(['amount' => $amount, 'currency' => 'usd', 'source' => $token]);



            if($charge->status == 'succeeded'){

            $featuredStartDate = date('Y-m-d H:i:s');
            $featuredEndDate = date('Y-m-d H:i:s', strtotime('+14 days', strtotime($featuredStartDate)));
            $values = array('product_id' => $productID,'feature_price'=> $price,'transcation_id'=>$charge->balance_transaction,'status'=>'1','feature_start_date'=>$featuredStartDate,'feature_end_date'=>$featuredEndDate);
            DB::table('product_features')->insert($values);
            $products = Product::find($productID);
            Product::FeatureEmailToadmin($products);
            $device_id = $logInedUser->device_id;
            $devicetype = $logInedUser->device_type;
            $message = 'Your product has been set as featured.';
            $type = 'Feature Product';
            $sellername = $logInedUser->first_name;

            $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);

            return response([
                'message'   => trans('Your product has been set as featured.'),
                'status'   => true,
                'code' => 200,
                'data' => $products,
            ]);
            
           /* $data =   json_encode([
                        'message'   => 'Your product has been set as featured.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $products,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
            
            }
            else{
                return response([
                    'message'   => trans('Payment not done, please try again.'),
                    'status'   => false,
                    'code' => 400,

                ]);
            }
    }
}



 public function SubDevicelist(Request $request)
 {
    if (empty($request->slug)) {

        return response([
            'message'   => trans('Slug is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    }
    else {

        $slug = $request->slug;
        if($slug == 'Others'){

            $others = DB::table('devices')->where('status','1')->skip(7)->take(30)->get()->toArray();

            if(!empty($others)){

                foreach($others as $val){
                $modellist = Categories::whereHas('devicemodels',function($query){
                    return $query->where('status', 1);
                })->with('devicemodels')->where([['status' ,'=', 1],['device_id',$val->id]])->paginate(9);
               }

            }else{
            $modellist = [];
            }

            if(count($modellist)>0)
                    {
                        return response([
                            'message'   => trans('Brand  Listings'),
                            'status'   => true,
                            'code' => 200,
                            'data' => $modellist,
                        ]);
                        
                        /*$data =   json_encode([
                        'message'   => 'Brand  Listings.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $modellist,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

                    }else
                    {

                        return response([
                            'message'   => trans('Brand  Listings not found.'),
                            'status'   => false,
                            'code' => 400,

                        ]);

                    }


        }else{
                $devicehome = Device::where([['status' ,'=', 1],['slug',$slug]])->first();

                if(!empty($devicehome)){

                    $modellist = Categories::whereHas('devicemodels',function($query){
                        return $query->where('status', 1);
                    })->with('devicemodels')->where([['status' ,'=', 1],['device_id',$devicehome->id]])->paginate(9);


                }else{
                $modellist = [];
                }

                if(count($modellist)>0)
                    {
                       return response([
                            'message'   => trans('Brand  Listings.'),
                            'status'   => true,
                            'code' => 200,
                            'data' => $modellist,
                        ]);
                        
                         /* $data =   json_encode([
                        'message'   => 'Brand  Listings.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $modellist,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

                    }else
                    {

                        return response([
                            'message'   => trans('Brand  Listings not found.'),
                            'status'   => false,
                            'code' => 400,

                        ]);

                    }
        }


}

 }


public function myPurchaseOrder()
{
    $logInedUser= Auth::user();

    $orderarray = array();
   $orderData = Order::where('user_id',$logInedUser->id)->with([
        'UserBillingAddress'=>function($query) {
            return $query->where('user_address_books.status', 2);
        },
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
    ])->orderBy('id','DESC')->paginate(config('get.ADMIN_PAGE_LIMIT'));



    if(count($orderData)>0)
    {
        return response([
            'message'   => trans('Purchase Order Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $orderData,
         ]);
         
         
         /*$data =   json_encode([
                        'message'   => 'Purchase Order Listings.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $orderData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Purchase Order Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }


}

public function mySellingOrder()
{
    $logInedUser= Auth::user();
    $orderData = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
        return $query->where('order_details.seller_id', $logInedUser->id);
    })->with([
        'UserBillingAddress'=>function($query) {
            return $query->where('user_address_books.status', 2);
        },
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
    ])->orderBy('id','DESC')->paginate(config('get.ADMIN_PAGE_LIMIT'));


    if(count($orderData)>0)
    {
        return response([
            'message'   => trans('Selling Order Listings.'),
            'status'   => true,
            'code' => 200,
            'data' => $orderData,
         ]);
         
         
          /*$data =   json_encode([
                        'message'   => 'Selling Order Listings.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $orderData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Selling Order Listings not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }


}

public function orderDetail(Request $request)
{
    $logInedUser= Auth::user();

    if (empty($request->order_id)) {

        return response([
            'message'   => trans('Order id is required.'),
            'status'   => false,
            'code' => 400,
        ]);
    } else {
        $orderid =   $request->order_id;
        $orderData = Order::where('id',$orderid)->with([
        'UserBillingAddress'=>function($query) {
            return $query->where('user_address_books.status', 2);
        },
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
        'rattingdata',       
    ])->orderBy('id','DESC')->first();

    if(isset($orderData))
    {
        return response([
            'message'   => trans('Order Detail.'),
            'status'   => true,
            'code' => 200,
            'data' => $orderData,
         ]);
         
          /*$data =   json_encode([
                        'message'   => 'Order Detail.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $orderData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

    }else
    {

        return response([
            'message'   => trans('Order Detail not found.'),
            'status'   => false,
            'code' => 400,

         ]);

    }
  }
}


public function orderUpdate(Request $request){
    $logInedUser= Auth::user();
    if (empty($request->order_id) || empty($request->trackingnumber) || empty($request->status)) {

        return response([
            'message'   => trans('Order id, tracking number and status  is required.'),
            'status'   => false,
            'code' => 400,
        ]);

    } else {

        $date = date('Y-m-d H:i:s');
        Order::where('id', $request->order_id)->update([
           'status' => $request->status,
           'order_status_date' =>$date,
           'tracking_number'=>$request->trackingnumber
        ]);

        $orderData = Order::where('id', $request->order_id)->first();

        Product::SendOrderStatusEmailTocustomer($orderData);
        Product::SendOrderStatusEmailToAdmin($orderData);


        $buyerdata = User::where('id',$orderData->user_id)->first();

        $buyer_device_id = $buyerdata->device_id;
        $buyer_devicetype = $buyerdata->device_type;


        if($request->status == 2){
            $buyer_message = 'Congratulations, Your order has been Shipped and order id is '.$orderData->custom_order_id;
            $buyer_type = 'Congratulations, Your order has been Shipped';
        }elseif($request->status == 3){
            $buyer_message = 'Congratulations, Your order has been Delivered and order id is '.$orderData->custom_order_id;
            $buyer_type = 'Congratulations, your order has been Delivered.';
        }else{
            $buyer_message = 'Congratulations, Your order has been Pending and order id is '.$orderData->custom_order_id;
            $buyer_type = 'Congratulations, your order has been Pending.';
        }

        $buyername = $buyerdata->first_name;

        $this->push_notification_to_buyer($buyer_device_id,$buyer_devicetype,$buyer_message,$buyer_type,$buyername);




       return response([
            'message'   => trans('Order Update.'),
            'status'   => true,
            'code' => 200,
            'data' => $orderData,
         ]);

     /* $data =   json_encode([
                        'message'   => 'Order Update.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $orderData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/


    }
}


public function returnOrder(Request $request){
    $logInedUser= Auth::user();
    if (empty($request->order_id) || empty($request->user_id) || empty($request->return_reason) ) {

        return response([
            'message'   => trans('Order id, user id and reason  is required.'),
            'status'   => false,
            'code' => 400,
        ]);

    } else {

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
            $ReturnOrderData = ReturnOrder::where('id', $checkorder->id)->with('order.user')->first();
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
        return response([
            'message'   => trans('Return request successfully raised. Our staff will contact you shortly.'),
            'status'   => true,
            'code' => 200,
            'data' => $ReturnOrderData,
         ]);
         
         
           /*$data =   json_encode([
                        'message'   => 'Return request successfully raised. Our staff will contact you shortly.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $ReturnOrderData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/

        }else{

            return response([
                'message'   => trans('Return request not raised. Please try again.'),
                'status'   => false,
                'code' => 400,
            ]);
        }



    }
}

public function ratting(Request $request){

    $logInedUser= Auth::user();

    if (empty($request->rat) || empty($request->review) || empty($request->order_id)) {

        return response([
            'message'   => trans('Rat,review and order id is required.'),
            'status'   => false,
            'code' => 400,
        ]);

    } else {
        $array = $request->all();

        $array['buyer_id'] = $logInedUser->id;
        $array['created_at'] = date('Y-m-d H:i:s');
        $Ratting = Ratting::create($array);

    DB::table('orders')
     ->where('id', $request->order_id)
     ->update(['rat' => $request->rat]);

        return response([
            'message'   => trans('Ratting and Review submitted successfully.'),
            'status'   => true,
            'code' => 200,
            'data' => '',
        ]);

    }


}

public function addtocart(Request $request)
{
        $logInedUser= Auth::user();
        if (empty($request->user_id)) {

            return response([
                'message'   => trans('User id and Product id is required.'),
                'status'   => false,
                'code' => 400,
            ]);

        } else {
            $i = 1;
            $productdata = Product::where('user_id',$logInedUser->id)->pluck('id')->toArray();

                foreach($request->product_id as $val){

                    if(count($productdata)>0){

                        if (in_array($val, $productdata)){


                        }else{
                            $checkproductincart = Cart::where([['user_id',$logInedUser->id],['product_id',$val],['from_offer',0]])->get();
                            if(count($checkproductincart)>0)
                            {

                            }else {
                            $date = date('Y-m-d H:i:s');
                            $values = array('user_id' => $logInedUser->id,'product_id'=>$val,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
                            $cardupdated = DB::table('carts')->insert($values);
                            }


                        }
                }else{

                    $checkproductincart = Cart::where([['user_id',$logInedUser->id],['product_id',$val],['from_offer',0]])->get();
                    if(count($checkproductincart)>0)
                    {

                    }else {
                    $date = date('Y-m-d H:i:s');
                    $values = array('user_id' => $logInedUser->id,'product_id'=>$val,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
                    $cardupdated = DB::table('carts')->insert($values);
                    }

                }

            }


            return response([
                'message'   => trans('Product added into cart.'),
                'status'   => true,
                'code' => 200,
                'data' => '',
                ]);



          $i++; }





}


public function cart(Request $request){

        $logInedUser= Auth::user();
        if (empty($request->user_id)) {

            return response([
                'message'   => trans('User id is required'),
                'status'   => false,
                'code' => 400,
            ]);

        } else {

            $cartdata = DB::table('carts')->where([['user_id',$logInedUser->id],['from_offer',0]])->get();


            if(!empty($cartdata))
            {   $ProductArray = array();
                foreach($cartdata as $cart){
                array_push($ProductArray,$cart->product_id);
                }
            }else{
                $ProductArray = array();
            }

           //$productData = Product::where('is_sold',0)->whereIn('id' , $ProductArray)->get();
           
           
          $productData = Product::where('is_sold',  0)->where(function($query) use($ProductArray) {
                    $query->whereIn('id',$ProductArray);
                   
                })->get();

           if(count($productData)>0){
                return response([
                    'message'   => trans('User cart data.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $productData,
                ]);
                
               /* $data =   json_encode([
                        'message'   => 'User cart data.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $productData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
               
            }else{
                    return response([
                        'message'   => trans('Cart is empty.Please add product in cart.'),
                        'status'   => true,
                        'code' => 200,
                        'data' => $productData,
                    ]);
                    
                    
                   /* $data =   json_encode([
                        'message'   => 'Cart is empty.Please add product in cart.',
                        'status'   => true,
                        'code' => 200,
                        'data' => $productData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
            }


      }

}



public function removeItemFormcart(Request $request){
        $logInedUser= Auth::user();
        if (empty($request->user_id) || empty($request->product_id)) {

            return response([
                'message'   => trans('User id and Product id is required.'),
                'status'   => false,
                'code' => 400,
            ]);

        } else {
            $id = $request->product_id;
            DB::table('carts')->where([['product_id',$id],['user_id',$logInedUser->id]])->delete();

            return response([
                'message'   => trans('Item removed successfully.'),
                'status'   => true,
                'code' => 200,
                'data' => '',
            ]);

        }
}



public function checkout(Request $request){
        $logInedUser= Auth::user();


        if (empty($request->user_id)) {

            return response([
                'message'   => trans('User id is required.'),
                'status'   => false,
                'code' => 400,
            ]);

        } else {




            try {

                \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));

                $stripetoken =  \Stripe\Token::create([
                   'card' => [
                     'number' => $request->card_number,
                     'exp_month' => $request->exp_month,
                     'exp_year' => $request->exp_year,
                     'cvc' => $request->cvc,
                   ],
                 ]);

              } catch(\Stripe\Exception\CardException $e) {


                return response([
                    'message'   => $e->getError()->message,
                    'status'   => false,
                    'code' => 200,
                ]);
              }


            $cartdata = DB::table('carts')->where('user_id',$logInedUser->id)->get();

            foreach($cartdata as $cart)
            {
                $Product = Product::where([['id',$cart->product_id],['is_sold',0]])->get();

                if(count($Product)>0)
                    {}else{

                            Cart::where('product_id', $cart->product_id)->delete();


                            return response([
                                'message'   => trans('Item has sold out.'),
                                'status'   => false,
                                'code' => 200,
                            ]);
                        }
            }

            if(count($cartdata)>0){


               if(isset($request->address_id))
                {
                    UserAddressBook::where('user_id',  $logInedUser->id)->update([
                        'status' => '1'
                     ]);

                     UserAddressBook::where('id', $request->address_id)->update([
                        'status' => '2'
                     ]);

                }else{

                    UserAddressBook::where('user_id', $logInedUser->id)->update([
                        'status' => '1'
                     ]);
                   $SaveAddress = UserAddressBook::create($request->all());
                }

                $token = $stripetoken->id;
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

                    $sellerdata = User::where('id',$Product->user_id)->first();
                    $device_id = $sellerdata->device_id;
                    $devicetype = $sellerdata->device_type;
                    $type = 'New order';
                    $message = 'Congratulations, you have received a new order at SellBuyDevice and Order id is '.$orderId;
                    $sellername = $sellerdata->first_name;
                    $this->push_notification_to_seller($device_id,$devicetype,$message,$type,$sellername);

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

                 $buyerdata = User::where('id',$logInedUser->id)->first();

                 $buyer_device_id = $buyerdata->device_id;
                 $buyer_devicetype = $buyerdata->device_type;
                 $buyer_message = 'We have received your order. Thanks for shopping with us. your order id is '.$orderId;
                 $buyer_type = 'Thanks for order at SellBuyDevice';
                 $buyername = $buyerdata->first_name;

                 $this->push_notification_to_buyer($buyer_device_id,$buyer_devicetype,$buyer_message,$buyer_type,$buyername);

                 $orderData = Order::where([['id',$orderId],['user_id',$logInedUser->id]])->with('OrderReturnData')->with('OrderDetailsData.product')->first();



                return response([
                    'message'   => trans('Payment Successfully done.'),
                    'status'   => true,
                    'code' => 200,
                    'data' => $orderData,
                ]);


              /*$data =   json_encode([
                        'message'   => 'Payment Successfully done',
                        'status'   => true,
                        'code' => 200,
                        'data' => $orderData,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/



                }
                else{

                    return response([
                        'message'   => trans('Payment not done, please try again.'),
                        'status'   => false,
                        'code' => 200,
                        'data' => '',
                    ]);
                 }


                }else{

                    return response([
                        'message'   => trans('Your cart is empty.Please add product in cart.'),
                        'status'   => false,
                        'code' => 200,
                        'data' => '',
                    ]);
                }





        }
}


public function addProductInRecentView(Request $request){

        $logInedUser= Auth::user();

        if (empty($request->product_id)) {

            return response([
                'message'   => trans('Product id is required.'),
                'status'   => false,
                'code' => 400,
            ]);

        } else {



        $RecenlyView= new RecentlyView();
        $recentlyViewd = RecentlyView::where([['user_id' ,'=', $logInedUser->id],['product_id','=', $request->product_id]])->count();


                if($recentlyViewd < 1){

                        $RecenlyView->user_id= $logInedUser->id;
                        $RecenlyView->product_id= $request->product_id;
                        $RecenlyView->status= 1;
                        $RecenlyView->save();

                        return response([
                            'message'   => trans('Product added in recenlty view list.'),
                            'status'   => true,
                            'code' => 200,
                            'data' => '',
                        ]);


                }else{
                    return response([
                        'message'   => trans('product already added in recent view list.'),
                        'status'   => false,
                        'code' => 400,

                    ]);
                }

        }

}

public function recentlist(){
    $logInedUser= Auth::user();
    if (empty($logInedUser)) {

        return response([
            'message'   => trans('No authorized to access this.'),
            'status'   => false,
            'code' => 400,
        ]);

    } else {

        $recenltyviews = RecentlyView::where([['user_id' ,'=', $logInedUser->id]])->with('product')->with('user')->take(9)->paginate();
            if(count($recenltyviews)>0){
            return response([
                'message'   => trans('Recenlty view list.'),
                'status'   => true,
                'code' => 200,
                'data' => $recenltyviews,
            ]);
            
             /*$data =   json_encode([
                        'message'   => 'Recenlty view list',
                        'status'   => true,
                        'code' => 200,
                        'data' => $recenltyviews,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
        }else{
            return response([
                'message'   => trans('List not found.'),
                'status'   => false,
                'code' => 400,
            ]);
        }

    }

}

public function alldevice(){

    $alldevices = Device::where('status',1)->get();

    if(count($alldevices)>0){
       return response([
            'message'   => trans('All device list.'),
            'status'   => true,
            'code' => 200,
            'data' => $alldevices,
        ]);
       /* $data =   json_encode([
                        'message'   => 'All device list',
                        'status'   => true,
                        'code' => 200,
                        'data' => $alldevices,
                        ],JSON_NUMERIC_CHECK);
               
               return $respone = response($data);*/
    }else{
        return response([
            'message'   => trans('List not found.'),
            'status'   => false,
            'code' => 400,
        ]);
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








function push_notification_android($device_id, $message, $type = null, $devicetype=null, $login_user_name = null, $sender_id = null, $receiver_id = null,$data_output=null,$productid=null) {




    $url = 'https://fcm.googleapis.com/fcm/send';

    $key = 'AIzaSyAfiGrcZpV4GyWCeI8j4C8Tccf4ta58aaU';
    $headers = array('Authorization: key=' . $key, 'Content-Type: application/json');
    $user = auth()->guard('api')->user();

    $finalmsg["body"] = $message;
    $finalmsg['data_output'] = $data_output;
    $finalmsg["title"] = "SellBuyDevice";
    $finalmsg["message"] = $message;
    $finalmsg["type"] = $type;
    $finalmsg["login_user_name"] = $login_user_name;
    $finalmsg["sender_id"] = $sender_id;
    $finalmsg["receiver_id"] = $receiver_id;
    $finalmsg["product_id"] = $productid;
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
    //print_r($ch); die;
    return true;
}


}
