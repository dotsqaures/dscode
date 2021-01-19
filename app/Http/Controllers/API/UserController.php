<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\UserManager\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Mail, Hash;
use Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use function GuzzleHttp\json_decode;
use Modules\UserManager\Http\Requests\UsersRequest;
use Modules\UserManager\Http\Requests\UserseditRequest;
use Modules\UserManager\Http\Requests\UsersupdatestripeRequest;
use Modules\StampsManager\Entities\Stamps;
use Modules\StampsManager\Entities\RedemStamp;
use Modules\ProductManager\Entities\Order;
use Twilio\Rest\Client;
use Session;
use Modules\ProductManager\Entities\Product;
use Modules\ProductManager\Entities\Chat;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\RestaurentsManager\Entities\Restaurents;
use Modules\RestaurentsManager\Entities\RestaurentTimes;
use Exception;


class UserController extends Controller
{
    public $successStatus = 200;
    use SendsPasswordResetEmails;



    protected function broker()
    {
        return Password::broker('users');
    }



    public function sendotp(Request $request){

        if(!empty($request->email) && $request->email != 'null'){
           session_start();
           $otpnumber = mt_rand(1000,9999);
           $_SESSION["otpnumber"] = $otpnumber;



            $response = User::Sendotptoemail($otpnumber,$request->email);

             return response([
                        'message'   => 'OTP Sent Successful',
                        'status'   => 200,

                        'data' =>$otpnumber,
                        ]);

        }else{

            return response([
                'message'   => trans('Email address is required.'),
                'status'   => 400,


            ]);
        }

    }

    public function verifyotp(Request $request){
        if(!empty($request->otp) && $request->otp != 'null'){

            session_start();

            $oldotp = $_SESSION["otpnumber"];

            if($oldotp == $request->otp){
                session_unset();
                 return response([
                        'message'   => 'OTP verified',
                        'status'   => 200,


                        ]);
            }else{
                 return response([
                        'message'   => 'OTP Wrong',
                        'status'   => 400,


                        ]);

            }



        }else{

            return response([
                'message'   => trans('OTP is required.'),
                'status'   => false,
                'code' => 400,

            ]);
        }
    }



    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
  /*  public function login(Request $request)
    {
        //echo Hash::check('Test@123', '$2y$10$EBkHFvyeSv.OPCe/KLRofOgjGjNSUtQjlB0/GFLtArX19A2hoQcnC'); die;

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if ($user->status == 1 && $user->is_verified == 1) {

                if(!empty($user->profle_photo)){
                $user->profle_photo = asset(Storage::url($user->profle_photo));
                }

                $data_output = array();
                $data_output = json_decode($user, true);
                $data_output['access_token'] =  $user->createToken('MyApp')->accessToken;

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['device_type' => $request['device_type'], 'device_id' => $request['device_id'],'access_token'=>$data_output['access_token']]);


                return response([
                        'message'   => 'Login Successful',
                        'status'   => true,
                        'code' => 200,
                        'data' => $data_output,
                        ]);

              // return $respone = response($data);


              /* $data =   json_encode([
                        'message'   => 'Login Successful',
                        'status'   => true,
                        'code' => 200,
                        'data' => $data_output,
                        ],JSON_NUMERIC_CHECK);

               return $respone = response($data);



            } elseif($user->is_verified == 0) {
                $data_output = array();
                return response([
                    'message'   => trans('Your account is not verified yet. Please verify your account.'),
                    'status'   => false,
                    'code' => 400,
                    'data' => (object) $data_output,
                ]);
            }elseif($user->status == 0) {
                $data_output = array();
                return response([
                    'message'   => trans('Your account is inactive. Please contact to sell buy device team.'),
                    'status'   => false,
                    'code' => 400,
                    'data' => (object) $data_output,
                ]);
            }
        } else {
            $data_output = array();
            return response([
                'message'   => trans('Incorrect email or password.'),
                'status'   => false,
                'code' => 400,
                'data' => (object) $data_output
            ]);
            //return response()->json(['error'=>'Unauthorised'], 401);
        }
    }*/


    public function login(Request $request){


         if(!empty($request->email) && $request->email != 'null'){

        $email = $request->email;
        $facebookid = $request->facebook_id;
        $authuser = User::where([['email',$email]])->select('id','first_name','email','facebook_id','created_at','updated_at','fcm','stripe_account_id')->first();

        if(!empty($authuser)){

             Auth::login($authuser,true);

                $data_output = array();
                $data_output = json_decode($authuser, true);
                $data_output['access_token'] =  $authuser->createToken('MyApp')->accessToken;


                if(empty($authuser->stripe_account_id)){
                    $customercard = User::CreateCustomerOnStripe($request->all());

                    DB::table('users')
                    ->where('id', $authuser->id)
                    ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token'],'stripe_account_id'=>$customercard]);


                }else{

                DB::table('users')
                    ->where('id', $authuser->id)
                    ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token']]);
                }

                //return response()->json(['success' => $success], $this-> successStatus);

               return response([
                    'message'   => trans('Login Successfully.'),
                    //'status'   => true,
                    'status' => 200,
                    'data' => $data_output,
                ]);





       }else{

           $customercard = User::CreateCustomerOnStripe($request->all());


                      $authuser = User::create([
                         'first_name' => $request->user_name,
                         'email' => $email,
                         'fcm' => $request->fcm,
                         'is_verified' => 1,
                         'status' => '1',
                         'role_id' => '1',

                        // 'access_token' => $user->token,
                         'facebook_id' => $request->facebook_id,
                         'provider' => 'facebook',
                         'stripe_account_id' => $customercard,

                         ]);


                         Auth::login($authuser,true);

                         $data_output = array();
                         $data_output = json_decode($authuser, true);
                         $data_output['access_token'] =  $authuser->createToken('MyApp')->accessToken;

                         DB::table('users')
                             ->where('id', $authuser->id)
                             ->update(['access_token'=>$data_output['access_token']]);



                         $date = date('Y-m-d H:i:s');

                   $values = array('user_id'=>$authuser->id, 'transcation_id'=>'FirstFreeCard','charge_id'=>'15','total_amount'=>'150','status'=>'2','created_at'=>$date,'updated_at'=>$date);
                   $orderId = DB::table('orders')->insertGetId($values);



                         return response([
                             'message'   => trans('Login Successful.'),
                             //'status'   => true,
                             'status' => 200,
                             'data' => $data_output,
                         ]);

       }

    }else{

       return response([
                'message'   => 'Email is required.',
               // 'status'   => false,
                'status' => 200,
           'data'=>$request->all(),
            ]);
    }


    }

    /*public function login(Request $request){




        $email = $request->email;
        $facebookid = $request->facebook_id;
        $authuser = User::where([['facebook_id',$facebookid],['email',$email]])->select('id','first_name','email','facebook_id','created_at','updated_at','fcm','stripe_account_id')->first();

        if(!empty($authuser)){

             Auth::login($authuser,true);

                $data_output = array();
                $data_output = json_decode($authuser, true);
                $data_output['access_token'] =  $authuser->createToken('MyApp')->accessToken;


                if(empty($authuser->stripe_account_id)){
                    $customercard = User::CreateCustomerOnStripe($request->all());

                    DB::table('users')
                    ->where('id', $authuser->id)
                    ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token'],'stripe_account_id'=>$customercard]);


                }else{

                DB::table('users')
                    ->where('id', $authuser->id)
                    ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token']]);
                }

                //return response()->json(['success' => $success], $this-> successStatus);

               return response([
                    'message'   => trans('Login Successfully.'),
                    //'status'   => true,
                    'status' => 200,
                    'data' => $data_output,
                ]);





       }else{
           $validator = Validator::make($request->all(), [

            'email' => 'email|unique:users',

        ]
    );

        if($validator->fails()) {

            return response([
                'message'   => 'Email already exist, Please try with other email.',
               // 'status'   => false,
                'status' => 400,
            ]);


        }

                    if(!empty($email)){

                 $customercard = User::CreateCustomerOnStripe($request->all());


                      $authuser = User::create([
                         'first_name' => $request->user_name,
                         'email' => $email,
                         'fcm' => $request->fcm,
                         'is_verified' => 1,
                         'status' => '1',
                         'role_id' => '1',

                        // 'access_token' => $user->token,
                         'facebook_id' => $request->facebook_id,
                         'provider' => 'facebook',
                         'stripe_account_id' => $customercard,

                         ]);


                         Auth::login($authuser,true);

                         $data_output = array();
                         $data_output = json_decode($authuser, true);
                         $data_output['access_token'] =  $authuser->createToken('MyApp')->accessToken;

                         DB::table('users')
                             ->where('id', $authuser->id)
                             ->update(['access_token'=>$data_output['access_token']]);



                         $date = date('Y-m-d H:i:s');

                   $values = array('user_id'=>$authuser->id, 'transcation_id'=>'FirstFreeCard','charge_id'=>'15','total_amount'=>'150','status'=>'2','created_at'=>$date,'updated_at'=>$date);
                   $orderId = DB::table('orders')->insertGetId($values);



                         return response([
                             'message'   => trans('Login Successful.'),
                             //'status'   => true,
                             'status' => 200,
                             'data' => $data_output,
                         ]);
                    }else{


                             $check = User::where([['facebook_id',$facebookid]])->select('id','first_name','email','facebook_id','created_at','updated_at','fcm','stripe_account_id')->first();

                             if(empty($check)){

                         return response([
                                  'message'   => trans('Email is required.'),
                                  'flag'   => 0,
                                  'status' => 200,
                                  'data' => $request->all(),
                              ]);
                             }else{

                                 Auth::login($check,true);
                                  $data_output = array();
                              $data_output = json_decode($check, true);
                              $data_output['access_token'] =  $check->createToken('MyApp')->accessToken;

                                  DB::table('users')
                                  ->where('id', $check->id)
                                  ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token']]);


                              //return response()->json(['success' => $success], $this-> successStatus);

                             return response([
                                  'message'   => trans('Login Successfully.'),
                                  //'status'   => true,
                                  'status' => 200,
                                  'data' => $data_output,
                              ]);

                             }
                     }
       }




    }*/

    public function logindemo(Request $request){


         if(!empty($request->email) && $request->email != 'null'){

        $email = $request->email;
        $facebookid = $request->facebook_id;
        $authuser = User::where([['email',$email]])->select('id','first_name','email','facebook_id','created_at','updated_at','fcm','stripe_account_id')->first();

        if(!empty($authuser)){

             Auth::login($authuser,true);

                $data_output = array();
                $data_output = json_decode($authuser, true);
                $data_output['access_token'] =  $authuser->createToken('MyApp')->accessToken;


                if(empty($authuser->stripe_account_id)){
                    $customercard = User::CreateCustomerOnStripedemo($request->all());

                    DB::table('users')
                    ->where('id', $authuser->id)
                    ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token'],'stripe_account_id'=>$customercard]);


                }else{

                DB::table('users')
                    ->where('id', $authuser->id)
                    ->update([ 'facebook_id' => $request->facebook_id,'fcm' => $request->fcm,'access_token'=>$data_output['access_token']]);
                }

                //return response()->json(['success' => $success], $this-> successStatus);

               return response([
                    'message'   => trans('Login Successfully.'),
                    //'status'   => true,
                    'status' => 200,
                    'data' => $data_output,
                ]);





       }else{

           $customercard = User::CreateCustomerOnStripedemo($request->all());


                      $authuser = User::create([
                         'first_name' => $request->user_name,
                         'email' => $email,
                         'fcm' => $request->fcm,
                         'is_verified' => 1,
                         'status' => '1',
                         'role_id' => '1',

                        // 'access_token' => $user->token,
                         'facebook_id' => $request->facebook_id,
                         'provider' => 'facebook',
                         'stripe_account_id' => $customercard,

                         ]);


                         Auth::login($authuser,true);

                         $data_output = array();
                         $data_output = json_decode($authuser, true);
                         $data_output['access_token'] =  $authuser->createToken('MyApp')->accessToken;

                         DB::table('users')
                             ->where('id', $authuser->id)
                             ->update(['access_token'=>$data_output['access_token']]);



                         $date = date('Y-m-d H:i:s');

                   $values = array('user_id'=>$authuser->id, 'transcation_id'=>'FirstFreeCard','charge_id'=>'15','total_amount'=>'150','status'=>'2','created_at'=>$date,'updated_at'=>$date);
                   $orderId = DB::table('orders')->insertGetId($values);



                         return response([
                             'message'   => trans('Login Successful.'),
                             //'status'   => true,
                             'status' => 200,
                             'data' => $data_output,
                         ]);

       }

    }else{

       return response([
                'message'   => 'Email is required.',
               // 'status'   => false,
                'status' => 200,
           'data'=>$request->all(),
            ]);
    }


    }


    public function logout(Request $request){

        if (empty($request->user_id)) {

            return response([
                'message'   => trans('user id is required.'),
                //'status'   => false,
                'status' => 400,
            ]);
        }
        else {

            return response([
                'message'   => trans('You have logout Successful.'),
                //'status'   => true,
                'status' => 200,

            ]);
        }


    }





  public function get_card(Request $request){
    if(!empty($request->user_id)){

      $userdata = User::where('id',$request->user_id)->first();

      $customercard = User::getcustomercard($userdata->stripe_account_id);


      if(!empty($customercard['data']['data']))
        {

            return response([
                'message'   => trans('Card detail.'),
                //'status'   => true,
                'status' => 200,
                'data' => $customercard['data']['data'],

            ]);

        }else{
            return response([
                'message'   => trans('Card detail.'),
                //'status'   => true,
                'status' => 200,
                'data' => [],

            ]);
        }




    } else{

        return response([
            'message'   => trans('User id required'),
             //'message'   => trans('Ingen stamkort fundet'),
            //'status'   => true,
            'status' => 400,



        ]);
    }
  }




    public function stamp_list(Request $request){

        $stamplist = Stamps::where([['status',1],['is_deleted',0],['is_free',0]])->orderby('created_at','DESC')->paginate(20);


        $productarray  = array();

        foreach($stamplist as $pro){
            $send = array();

            $send['id'] = $pro->id;
            $send['title'] = $pro->title;
            $send['short_description'] = $pro->short_description;
            $send['description'] = $pro->description;
            $send['stemp_no'] = $pro->stemp_no;
            $send['stemp_valid'] = $pro->stemp_valid;

            $send['normal_price'] = $pro->normal_price;
            $send['descoun_price'] = $pro->descoun_price;
            $send['saving_price'] = $pro->saving_price;
            $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
            $send['status'] = $pro->status;
            $send['created_at'] = $pro->created_at;
            $send['updated_at'] = $pro->updated_at;

            array_push($productarray,$send);
        }


        $total = count($productarray);

        $perPage = 9;

        $currentPage = 1;

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($productarray, $total, $perPage, $currentPage);


        return response([
            'message'   => trans('success.'),
            //'status'   => true,
            'status' => 200,
            'data' => $paginator

        ]);

    }


 public function stamp_detail(Request $request){



    $stampData = Stamps::where('id',$request->id)->get();

    $productarray  = array();

    if(empty($request->user_id)){

    foreach($stampData as $pro){
        $send = array();

        $shows ='';
if($pro->stemp_valid  ==  '1 Months') {
     $shows = "30 dage fra købsdato";
    } elseif($pro->stemp_valid  ==  '2 Months'){
     $shows = "2 måneder fra købsdato";
    }
    elseif($pro->stemp_valid  ==  '3 Months'){
     $shows = "3 måneder fra købsdato";
    }
    elseif($pro->stemp_valid  ==  '6 Months'){
     $shows = "6 måneder fra købsdato";
    }elseif($pro->stemp_valid  ==  '12 Months'){
     $shows = "1 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '24 Months'){
     $shows = "2 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '36 Months'){
     $shows = "3 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '48 Months'){
     $shows = "4 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '60 Months'){
     $shows = "5 år fra købsdato";
    }

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['expire_day'] = '';
        $send['total_redem'] = '';
        $send['order_id'] = (int)0;
        $send['stamp_expire_day'] = $shows;


        array_push($productarray,$send);
    }

}else{

    $orderid = Order::where([['id',$request->order_id]])->first();

    $totalRedem = RedemStamp::where('order_id',$orderid->id)->count();


    foreach($stampData as $pro){
        $send = array();

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['total_redem'] = $totalRedem;
        $send['order_id'] = (int)$orderid->id;

   /* $sdate = date('Y-m-d',strtotime($pro->created_at));
    $edate = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime($orderid->created_at)));




           $date1 = strtotime($sdate);
$date2 = strtotime($edate);
$months = 0;

while (($date1 = strtotime('+1 MONTH', $date1)) <= $date2)
    $months++;

1 month: 30 dage fra købsdato
2 months: 2 måneder fra købsdato
3 months: 3 måneder fra købsdato
6 months: 6 måneder fra købsdato
12 months: 1 år fra købsdato
24: 2 år fra købsdato
36: 3 år fra købsdato
48: 4 år fra købsdato
60: 5 år fra købsdato*/
$shows ='';
if($pro->stemp_valid  ==  '1 Months') {
     $shows = "30 dage fra købsdato";
    } elseif($pro->stemp_valid  ==  '2 Months'){
     $shows = "2 måneder fra købsdato";
    }
    elseif($pro->stemp_valid  ==  '3 Months'){
     $shows = "3 måneder fra købsdato";
    }
    elseif($pro->stemp_valid  ==  '6 Months'){
     $shows = "6 måneder fra købsdato";
    }elseif($pro->stemp_valid  ==  '12 Months'){
     $shows = "1 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '24 Months'){
     $shows = "2 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '36 Months'){
     $shows = "3 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '48 Months'){
     $shows = "4 år fra købsdato";
    }elseif($pro->stemp_valid  ==  '60 Months'){
     $shows = "5 år fra købsdato";
    }

        $send['expire_day'] = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime($orderid->created_at)));
        $send['stamp_expire_day'] = $shows;

        array_push($productarray,$send);
    }

}

    return response([
        'message'   => trans('Stamp List.'),
        //'status'   => true,
        'status' => 200,
        'data' => $productarray

    ]);

 }

 public function ephemeralkeys(Request $request){

    $date = date('Y-m-d H:i:s');
    $logInedUser= Auth::user();

    $userdata = User::where('id','=',$request->user_id)->first();

    try {

        \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
       // \Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');


        $key = \Stripe\EphemeralKey::create(
            ['customer' => $userdata->stripe_account_id],
            ['stripe_version' => '2020-03-02']
          );

          return response([
            'message'   => trans('Client secret key.'),
            //'status'   => true,
            'status' => 200,
            'data' => $key


        ]);

      } catch(\Stripe\Exception\InvalidRequestException $e) {


        return response([
            'message'   => $e->getError()->message,
            'status'   => 400,
           // 'code' => 200,
        ]);
      }



 }

 public function ephemeralkeysdemo(Request $request){

    $date = date('Y-m-d H:i:s');
    $logInedUser= Auth::user();

    $userdata = User::where('id','=',$request->user_id)->first();

    try {

        \Stripe\Stripe::setApiKey('sk_test_51GprTaJ6sT2LBGdySqiYTJbpZnAsKqKqSELfFyl01z8AC4x9WowhbgahM2YJDk9pdv7BQIGlwzuCVJPmKVv79j6i00eHv5jpEk');

        $key = \Stripe\EphemeralKey::create(
            ['customer' => $userdata->stripe_account_id],
            ['stripe_version' => '2020-03-02']
          );

          return response([
            'message'   => trans('Client secret key.'),
            //'status'   => true,
            'status' => 200,
            'data' => $key


        ]);

      } catch(\Stripe\Exception\InvalidRequestException $e) {


        return response([
            'message'   => $e->getError()->message,
            'status'   => 400,
           // 'code' => 200,
        ]);
      }



 }

 public function apple_paydemo(Request $request){

    $date = date('Y-m-d H:i:s');
    $logInedUser= Auth::user();

    try {

        \Stripe\Stripe::setApiKey('sk_test_51GprTaJ6sT2LBGdySqiYTJbpZnAsKqKqSELfFyl01z8AC4x9WowhbgahM2YJDk9pdv7BQIGlwzuCVJPmKVv79j6i00eHv5jpEk');

        $amount = $request->amount * 100;
        $userdata = User::where('id','=',$request->user_id)->first();

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'DKK',
            'customer'=>$userdata->stripe_account_id

          ]);
          $client_secret = $intent->client_secret;

          return response([
            'message'   => trans('Client secret key.'),
            //'status'   => true,
            'status' => 200,
            'data' => $client_secret


        ]);

      } catch(\Stripe\Exception\InvalidRequestException $e) {


        return response([
            'message'   => $e->getError()->message,
            'status'   => 400,
           // 'code' => 200,
        ]);
      }



 }
 
 public function add_card(Request $request)
	{
        $userdata = User::where('id','=',$request->user_id)->first();	
        \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
            
           

            

			try{
				
			 $stripetoken =  \Stripe\Token::create([
                'card' => [
                  'number' => $request->card_number,
                  'exp_month' => $request->exp_month,
                  'exp_year' => $request->exp_year,
                  'cvc' => $request->cvc,
                ],
              ]);
			  
			  $updatecard = \Stripe\Customer::createSource(
				$userdata->stripe_account_id,
			   ['source' => $stripetoken->id]
			  );
			  
			  return response([
				'message'   => trans('Card Added Successfully.'),
				//'status'   => true,
				'status' => 200,
				



			]);
			
			}catch(\Stripe\Error\Card $e){
				
				return response([
				'message'   => 'card decline from stripe',
				//'status'   => true,
				'status' => 400,
				



			]);
			}

		   

	}
	
public function delete_card(Request $request){
	   $userdata = User::where('id','=',$request->user_id)->first();	
      \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
	  
	  try{
	   \Stripe\Customer::deleteSource(
		  $userdata->stripe_account_id,
		  $request->card_id,
		  []
		);
		
		return response([
				'message'   => 'card deleted',
				//'status'   => true,
				'status' => 200,
				]);
		
		
	  }catch(Exception $e){
		return response([
				'message'   => 'Card is not exist, please try again',
				//'status'   => true,
				'status' => 400,
				]);
		
		  
	  }
		
			
}	
	
 
  public function get_card_list(Request $request){
	
    $userdata = User::where('id','=',$request->user_id)->first();	
     \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
	 
	
    $cardlist = \Stripe\Customer::allSources(
		  $userdata->stripe_account_id,
		  ['object' => 'card', 'limit' => 5]
		);	 
	
	 if(count($cardlist) > 0){
		  return response([
				'message'   => trans('Data Redem Successfully.'),
				//'status'   => true,
				'status' => 200,
				'data'=>   $cardlist,



			]);
	 }else{
		
		 return response([
				'message'   => trans('Not Found.'),
				//'status'   => true,
				'status' => 400,



			]);
	
	 }
	 
	 
 }


 public function apple_pay(Request $request){

    $date = date('Y-m-d H:i:s');
    $logInedUser= Auth::user();

    try {

        \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
       // \Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');


        $amount = $request->amount * 100;
        $userdata = User::where('id','=',$request->user_id)->first();

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'DKK',
            'customer'=>$userdata->stripe_account_id

          ]);
          $client_secret = $intent->client_secret;

          return response([
            'message'   => trans('Client secret key.'),
            //'status'   => true,
            'status' => 200,
            'data' => $client_secret


        ]);

      } catch(\Stripe\Exception\InvalidRequestException $e) {


        return response([
            'message'   => $e->getError()->message,
            'status'   => 400,
           // 'code' => 200,
        ]);
      }



 }


 /*
 *
 * pk_live_DR7GMpdo9ofHa19Tf5NIVFAJ00BwOvzVPz

sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm


pk_test_XavjwgF1BFYuvU632gwGg1m400p3ubcESz

sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB
 *
 */


 public function pay_stripe(Request $request){
    $date = date('Y-m-d H:i:s');
    $logInedUser= Auth::user();

    if(empty($request->card_id)){
        $buyerdata = User::where('id',$request->user_id)->first();

        try {

           \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
            // \Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');


            $stripetoken =  \Stripe\Token::create([
               'card' => [
                 'number' => $request->card_number,
                 'exp_month' => $request->exp_month,
                 'exp_year' => $request->exp_year,
                 'cvc' => $request->cvc,
               ],
             ]);

             $savedata = User::addcardDetail($buyerdata,$request->all());

          } catch(\Stripe\Exception\CardException $e) {


            return response([
                'message'   => $e->getError()->message,
                'status'   => 400,
               // 'code' => 200,
            ]);
          }



          $token = $stripetoken->id;
          $amount = $request->total_amount * 100;



         // $charge = \Stripe\Charge::create(['amount' => $amount, 'currency' => 'DKK', 'source' => $token]);
          $productarray  = array();
          $status = 'succeeded';
          if($status == 'succeeded'){

    /*$values = array('user_id'=>$request->user_id, 'transcation_id'=>$charge->balance_transaction,'charge_id'=>$request->stamp_id,'total_amount'=>$request->total_amount,'status'=>'2','created_at'=>$date,'updated_at'=>$date);
    $orderId = DB::table('orders')->insertGetId($values);

    $stampData = Stamps::where('id',$request->stamp_id)->get();

    $productarray  = array();

    foreach($stampData as $pro){
        $send = array();

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['expire_day'] = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime("NOW")));
        $send['order_id'] = (int)$orderId;
        $send['stamp_expire_day'] = '';



        array_push($productarray,$send);
    }

    $buyerdata = User::where('id',$request->user_id)->first();

    $devceid = $buyerdata->fcm;

     $message = 'Sådan! Dit køb blev gennemført! Vi takker 🙏';
     $messagetyep = 'Congratulations, Payment successfully done';
     $buyername = $buyerdata->first_name;

     $this->push_notification_to_buyer($devceid,$message,$messagetyep,$buyername);*/

            return response([
                'message'   => trans('Card save successfully..'),
                //'status'   => true,
                'status' => 200,
                'data' => $productarray


            ]);

            }else{

                return response([
                    'message'   => trans('Payment not done.'),
                    //'status'   => true,
                    'status' => 400,
                   // 'data' => $productarray


                ]);

            }

    }else{

       \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
        //\Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');


        $amount = $request->total_amount * 100;

        $buyerdata = User::where('id',$request->user_id)->first();




        try{


			$charge = \Stripe\PaymentIntent::retrieve($request->card_id);



       /* $charge =  \Stripe\Charge::create(array(
            "amount" =>  $amount,
            "currency" => "DKK",
            "customer" => $buyerdata->stripe_account_id,
            "source" => $request->card_id
          ));*/

        }catch(\Stripe\Exception\CardException $e) {


            return response([
                'message'   => $e->getError()->message,
                'status'   => 400,
               // 'code' => 200,
            ]);
          }



     $values = array('user_id'=>$request->user_id, 'transcation_id'=>$charge->id,'charge_id'=>$request->stamp_id,'total_amount'=>$request->total_amount,'status'=>'2','created_at'=>$date,'updated_at'=>$date);
     $orderId = DB::table('orders')->insertGetId($values);



        $stampData = Stamps::where('id',$request->stamp_id)->get();

    $productarray  = array();

    foreach($stampData as $pro){
        $send = array();

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['expire_day'] = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime("NOW")));
        $send['order_id'] = (int)$orderId;
        $send['stamp_expire_day'] = '';



        array_push($productarray,$send);
    }



    $buyerdata = User::where('id',$request->user_id)->first();

   $devceid = $buyerdata->fcm;

    $message = 'Sådan! Dit køb blev gennemført! Vi takker 🙏';
    $messagetyep = 'Congratulations, Payment successfully done';
    $buyername = $buyerdata->first_name;

    $this->push_notification_to_buyer($devceid,$message,$messagetyep,$buyername);

   // Order::SendEmaltoCutomerWhenpurchaseStamp($buyerdata,$request->transaction_id,$send['title']);

    return response([
        'message'   => trans('Payment successfully done.'),
        //'status'   => true,
        'status' => 200,
        'data' => $productarray


    ]);

    }

 }




 public function mobile_pay(Request $request)
 {

    $date = date('Y-m-d H:i:s');
    $logInedUser= Auth::user();

    if(empty($request->transaction_id)){

    $values = array('user_id'=>$request->user_id,'charge_id'=>$request->stamp_id,'total_amount'=>$request->total_amount,'status'=>'1','created_at'=>$date,'updated_at'=>$date);
    $orderId = DB::table('orders')->insertGetId($values);

    $stampData = Stamps::where('id',$request->stamp_id)->get();

    $productarray  = array();

    foreach($stampData as $pro){
        $send = array();

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['expire_day'] = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime("NOW")));
        $send['order_id'] = (int)$orderId;
        $send['stamp_expire_day'] = '';



        array_push($productarray,$send);
    }


    return response([
        'message'   => trans('Payment successfully done.'),
        //'status'   => true,
        'status' => 200,
        'data' => $productarray


    ]);

    }else{

        DB::table('orders')->where('id', $request->order_id)->update(['transcation_id'=>$request->transaction_id,'status'=>2]);
        $stampData = Stamps::where('id',$request->stamp_id)->get();

    $productarray  = array();

    foreach($stampData as $pro){
        $send = array();

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['expire_day'] = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime("NOW")));
        $send['order_id'] = (int)$request->order_id;
        $send['stamp_expire_day'] = '';



        array_push($productarray,$send);
    }



    $buyerdata = User::where('id',$request->user_id)->first();

   $devceid = $buyerdata->fcm;

    $message = 'Sådan! Dit køb blev gennemført! Vi takker 🙏';
    $messagetyep = 'Congratulations, Payment successfully done';
    $buyername = $buyerdata->first_name;

    $this->push_notification_to_buyer($devceid,$message,$messagetyep,$buyername);

    //Order::SendEmaltoCutomerWhenpurchaseStamp($buyerdata,$request->transaction_id,$send['title']);

    return response([
        'message'   => trans('Payment successfully done.'),
        //'status'   => true,
        'status' => 200,
        'data' => $productarray


    ]);

    }


 }

 public function mystamp_list(Request $request){


   $stampData =  Order::where([['user_id',$request->user_id],['transcation_id','!=','']])->orderBy('created_at','DESC')->get();

 if(count($stampData)>0){

    $productarray  = array();

    foreach($stampData as $stamp){
//$stamp->charge_id;
    $stamplist = Stamps::where('id',$stamp->charge_id)->get();
if(count($stamplist)>0){
    $totalRedem = RedemStamp::where('order_id',$stamp->id)->count();

 foreach($stamplist as $pro){
     if($totalRedem != $pro->stemp_no){
            $send = array();

            $send['id'] = $pro->id;
            $send['title'] = $pro->title;
            $send['short_description'] = $pro->short_description;
            $send['description'] = $pro->description;
            $send['stemp_no'] = $pro->stemp_no;
            $send['stemp_valid'] = $pro->stemp_valid;

            $send['normal_price'] = $pro->normal_price;
            $send['descoun_price'] = $pro->descoun_price;
            $send['saving_price'] = $pro->saving_price;
            $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
            $send['status'] = $pro->status;
            $send['created_at'] = $pro->created_at;
            $send['updated_at'] = $pro->updated_at;
            $send['total_redem'] = $totalRedem;
            $send['order_id'] = (int)$stamp->id;
			$send['order_date'] = $stamp->created_at;

            array_push($productarray,$send);
     }

        }


    }




    }


        $total = count($productarray);

        $perPage = 20;

        $currentPage = 1;

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($productarray, $total, $perPage, $currentPage);


        return response([
            'message'   => trans('success.'),
            //'status'   => true,
            'status' => 200,
            'data' => $paginator

        ]);


 }else{

    return response([
        'message'   => trans('Ingen stamkort fundet'),
        //'status'   => true,
        'status' => 400,



    ]);


 }

 }
 
public function mystamppurchase_list(Request $request){


   $stampData =  Order::where([['user_id',$request->user_id],['transcation_id','!=','']])->orderBy('created_at','DESC')->get();

 if(count($stampData)>0){

    $productarray  = array();

    foreach($stampData as $stamp){
//$stamp->charge_id;
    $stamplist = Stamps::where('id',$stamp->charge_id)->get();
if(count($stamplist)>0){
    $totalRedem = RedemStamp::where('order_id',$stamp->id)->count();

 foreach($stamplist as $pro){
     
            $send = array();

            $send['id'] = $pro->id;
            $send['title'] = $pro->title;
            $send['short_description'] = $pro->short_description;
            $send['description'] = $pro->description;
            $send['stemp_no'] = $pro->stemp_no;
            $send['stemp_valid'] = $pro->stemp_valid;

            $send['normal_price'] = $pro->normal_price;
            $send['descoun_price'] = $pro->descoun_price;
            $send['saving_price'] = $pro->saving_price;
            $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
            $send['status'] = $pro->status;
            $send['created_at'] = $pro->created_at;
            $send['updated_at'] = $pro->updated_at;
            $send['total_redem'] = $totalRedem;
            $send['order_id'] = (int)$stamp->id;
			$send['order_date'] = $stamp->created_at;

            array_push($productarray,$send);
     

        }


    }




    }


        $total = count($productarray);

        $perPage = 30;

        $currentPage = 1;

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($productarray, $total, $perPage, $currentPage);


        return response([
            'message'   => trans('success.'),
            //'status'   => true,
            'status' => 200,
            'data' => $paginator

        ]);


 }else{

    return response([
        'message'   => trans('Ingen stamkort fundet'),
        //'status'   => true,
        'status' => 400,



    ]);


 }

 }
 
  
 
 
 
 public function get_redeem_stamp_list(Request $request){
	
    $stampData = RedemStamp::where([['user_id',$request->user_id]])->orderBy('created_at','DESC')->with('user','stamp')->paginate(100);	
	 
	 if(count($stampData) > 0){
		  return response([
				'message'   => trans('Data Redem Successfully.'),
				//'status'   => true,
				'status' => 200,
				'data'=>   $stampData,



			]);
	 }else{
		
		 return response([
				'message'   => trans('Not Found.'),
				//'status'   => true,
				'status' => 400,



			]);
	
	 }
	 
	 
 }
 


 public function redeem_stamp(Request $request){


   $input = $request->all();


   $CheckEmpCOde = User::where('employee_code','LIKE', '%' . $request->redeem_code . '%')->count();

   if($CheckEmpCOde == 0){

       return response([
            'message'   => trans('Ugyldig kode. Forsøg igen'),
            //'status'   => true,
            'status' => 400,




        ]);

   }else{

    $user = RedemStamp::create($input);

   $stampData = Stamps::where('id',$request->stamp_id)->get();

    $productarray  = array();

    foreach($stampData as $pro){
        $send = array();

        $send['id'] = $pro->id;
        $send['title'] = $pro->title;
        $send['short_description'] = $pro->short_description;
        $send['description'] = $pro->description;
        $send['stemp_no'] = $pro->stemp_no;
        $send['stemp_valid'] = $pro->stemp_valid;

        $send['normal_price'] = $pro->normal_price;
        $send['descoun_price'] = $pro->descoun_price;
        $send['saving_price'] = $pro->saving_price;
        $send['stamp_picture'] = asset(Storage::url($pro->stamp_picture));
        $send['status'] = $pro->status;
        $send['created_at'] = $pro->created_at;
        $send['updated_at'] = $pro->updated_at;
        $send['expire_day'] = date('Y-m-d', strtotime("+".$pro->stemp_valid, strtotime("NOW")));
        $send['order_id'] = (int)$request->order_id;



        array_push($productarray,$send);
    }


    $buyerdata = User::where('id',$request->user_id)->first();

    $devceid = $buyerdata->fcm;

    $message = 'Sådan! Du har indløst et stempel! Vi takker 😄';
    $messagetyep = 'Congratulations, Stamp Redeem successfully';
    $buyername = $buyerdata->first_name;

    $this->push_notification_to_buyer($devceid,$message,$messagetyep,$buyername);


         return response([
            'message'   => trans('Data Redem Successfully.'),
            //'status'   => true,
            'status' => 200,
             'data'=>   $productarray,



        ]);
   }
 }


 public function restaurantlist(Request $request){
 
   //$restuarentData =  Restaurents::with('restaurantTime')->where('status',1)->get();
   $latitude = $request->Latitude;
   $longitude = $request->Longitude;
   
   $restuarentData = Restaurents::select(DB::raw('*, ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( lat ) ) ) ) AS distance'))
    //->having('distance', '<', 10000000000000)
    ->orderBy('distance')
    ->with('restaurantTime')->get();
   
  
   
    

    return response([
        'message'   => trans('Restaurant Data.'),
        //'status'   => true,
        'status' => 200,
         'data'=>   $restuarentData,



    ]);

 }


 function push_notification_to_buyer($devceid,$message,$messagetyep,$username)
 {

     $url = 'https://fcm.googleapis.com/fcm/send';

     $key = 'AAAAvgd7OIk:APA91bG-zNk9Py_HfVc-86WZLlpZqAPMK8EhAPZVkcZyAxiOepAyeXpWLvo7rxnAaGok6srysJ5mMQFLgWOUjUwv_SqtJyNEx31BHv2EM9Yb0MroVPisAO5Z9-wHKqpVthv3JSfSO0IR';
     $headers = array('Authorization: key=' . $key, 'Content-Type: application/json');
     $user = auth()->guard('api')->user();

     $finalmsg["body"] = $message;

     $finalmsg["title"] = "Mad & Kaffe";
     $finalmsg["message"] = $message;
     $finalmsg["type"] = $messagetyep;
     $finalmsg["login_user_name"] = $username;

     $finalmsg["unique_key"] = mt_rand(10000, 99999);
     $finalmsg["priority"] = 'high';
     $finalmsg["sound"] = 'default';

        $fields = array(
             'to' => $devceid,
             'data' => $finalmsg,
             'notification' => $finalmsg,
             'priority' => 'high' // new fcm
         );


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









}
