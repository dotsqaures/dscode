<?php

namespace Modules\UserManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\UserManager\Http\Requests\UsersRequest;
use Modules\UserManager\Http\Requests\UserseditRequest;
use Modules\UserManager\Http\Requests\UsersupdatestripeRequest;
use Modules\UserManager\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Modules\UserManager\Entities\User;
use Modules\ProductManager\Entities\Product;
use Modules\ProductManager\Entities\ProductFeature;
use App\UserRole;
use Session;
use Twilio\Rest\Client;
use Modules\ProductManager\Entities\Chat;
use Illuminate\Support\Facades\Storage;
use Modules\ProductManager\Entities\Cart;
use Modules\ProductManager\Entities\Order;
use Modules\ProductManager\Entities\OrderDetail;

class UserManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    protected $redirectTo   = '/user-dashboard';


   public function userDashboard()
   {

    $logInedUser=\Auth::user();
    $user=\Auth::user();

    $PurchaseOrder = Order::where('user_id',$logInedUser->id)->with('OrderDetailsData.product')->get();
   $SellOrder = OrderDetail::where('seller_id',$logInedUser->id)->groupBy('order_id')->get();

   $TotalAddedProduct = Product::where('user_id',$logInedUser->id)->get();

   $Mywatchlist = Chat::where('sender_id', '=',$logInedUser->id)->groupBy('product_id')->get();
   
   //$receivedpayment = OrderDetail::where([['seller_id',$logInedUser->id],['is_transfer',1]])->with('product')->groupBy('product_id')->get();

   $receivedpayment = Order::whereHas('OrderDetailsData',function($query) use($logInedUser) {
        return $query->where([['order_details.seller_id', $logInedUser->id],['is_transfer',1]]);
    })->with([
        'OrderReturnData',
        'OrderDetailsData',
        'OrderDetailsData.product',
    ])->where([['is_return',0],['is_transfertoseller',1]])->get();
    
    //dd($receivedpayment);

   
   return view('usermanager::Users.user-dashboard', compact('user','logInedUser','PurchaseOrder','SellOrder','TotalAddedProduct','Mywatchlist','receivedpayment'));
   }



    public function profile() {
        $logInedUser=\Auth::user();
        $user      = \Auth::guard()->user();
        if (!$user) {
            return redirect('login');
        }


        return view('usermanager::Users.profile', compact('user','logInedUser'));
    }


    public function updateProfile(UserseditRequest $request,$id) {
        $exist = User::where([['mobileno', $request->mobileno],['id',$id]])->first();

        if(!empty($exist)){

        $array = collect($request)->except('_token')->all();
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if($request->file('profle_photo')){

                $file     = $request->file('profle_photo');
                $filename = $file->getClientOriginalName();

                $path = $request->file('profle_photo')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['profle_photo'] = $path;
            }

            if($request->file('bussiness_logo')){

                $file     = $request->file('bussiness_logo');
                $filename = $file->getClientOriginalName();

                $path = $request->file('bussiness_logo')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['bussiness_logo'] = $path;
            }

            $user->fill($array);

            $user->save();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('profile')->with('success', 'Profile has been updated successfully.');
      }else{
        $existmobile = User::where('id', '!=' ,$id)->pluck('mobileno')->toArray();

                   if (in_array($request->mobileno, $existmobile))
                    {
                        return back()->withError('Mobile no  already exists. Please use another mobile no')->withInput();
                    }
                    else
                    {
                        $array = collect($request)->except('_token')->all();
        DB::beginTransaction();
        try {
            $user = User::find($id);

            if($request->file('profle_photo')){

                $file     = $request->file('profle_photo');
                $filename = $file->getClientOriginalName();

                $path = $request->file('profle_photo')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['profle_photo'] = $path;
            }

            if($request->file('bussiness_logo')){

                $file     = $request->file('bussiness_logo');
                $filename = $file->getClientOriginalName();

                $path = $request->file('bussiness_logo')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['bussiness_logo'] = $path;
            }

            $user->fill($array);

            $user->save();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('profile')->with('success', 'Profile has been updated successfully.');
                    }
      }
    }


    public function index()
    {
        return view('usermanager::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('usermanager::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('usermanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('usermanager::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function verify($token) {

        $exist = DB::table('users')->where('verification_token', $token)->first();

       if (!empty($exist)) {
           if ($exist->status == 0) {
               DB::table('users')
                       ->where('id', $exist->id)
                       ->update(['status' => 1, 'is_verified' => 1, 'verification_token' => NULL, 'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()]);
               return redirect()->route('login')->with('success', 'Your e-mail address is now verified. Please login to continue.');
           } else {
               return redirect()->route('login')->with('success', 'Your e-mail is already verified. Please login to continue.');
           }
       } else {
           return redirect()->route('login')->with('error', 'Your e-mail is already verified. Please login to continue.');
       }
   }


   public function otpverify(){


    return view('usermanager::Users.auth.otpverify');

   }

public function verifyotptoken(Request $request)
{

    $registeredEmail = \Session::get('emailaddress');
    $token = $request->otp_token;
    $exist = User::where([['otp_token', $token],['email',$registeredEmail]])->first();
    if (!empty($exist)) {

            DB::table('users')
                    ->where('id', $exist->id)
                    ->update(['status' => 1, 'is_verified' => 1, 'verification_token' => NULL, 'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString()]);

            Auth::login($exist,true);
            return redirect($this->redirectTo);

    } else {
        return redirect()->route('otpverify')->with('error', 'Please enter correct OTP.');
    }

}

public function loginwithotp(Request $request)
{
    $registeredmobile = $request->mobileno;

    $exits = User::where('mobileno', $registeredmobile)->first();


    $otpnumber = mt_rand(100000,999999);


    if(!empty($exits)){


        \Session::put('emailaddress', $exits->email);
        \Session::put('mobileno', $registeredmobile);
        
        $sid = config('get.twilio-sid-key');
        $token = config('get.twili-auth-key');
        $ToNumber =  '+61'.str_replace(' ', '', $registeredmobile);
        
        $client = new Client($sid, $token);
        $message = $client->messages->create(
            $ToNumber, // Text this number
            array(
            'from' => 'SBDevice', // From a valid Twilio number
            'body' => 'Your OTP is '.$otpnumber,
            )
        );

        DB::table('users')
        ->where('id', $exits->id)
        ->update(['otp_token' => $otpnumber]);


        return view('usermanager::Users.auth.otpverify');

    }else{

        return redirect()->route('login')->with('error', 'Enter Mobile Number Registered in Site.');

    }



}



public function resendotp(){

    $registeredmobile = \Session::get('mobileno');
    $exits = User::where('mobileno', $registeredmobile)->first();
    $otpnumber = mt_rand(100000,999999);
    if(!empty($exits)){
        \Session::put('emailaddress', $exits->email);
        \Session::put('mobileno', $registeredmobile);
        $sid = config('get.twilio-sid-key');
        $token = config('get.twili-auth-key');

        $ToNumber =  '+61'.str_replace(' ', '', $registeredmobile);
        $client = new Client($sid, $token);
        $message = $client->messages->create(
            $ToNumber, // Text this number
            array(
            'from' => 'SBDevice', // From a valid Twilio number
            'body' => 'Your OTP is '.$otpnumber,
            )
        );

        DB::table('users')
        ->where('id', $exits->id)
        ->update(['otp_token' => $otpnumber]);
         $response = 'OTP has been successfully resend.';
      }else{
        $response = 'Mobile number not valid.';

    }

    echo $response; die;

}



   public function showResetForm(Request $request, $token = null) {

    return view('usermanager::Users.reset')->with(
                    ['token' => $token, 'email' => $request->email]
    );
   }

   public function ChangePassword() {
    $logInedUser=\Auth::user();
    return view('usermanager::Users.change-password',compact('logInedUser'));
    }

    /**
     * Method for user change password
     * @param \App\Http\Controllers\ChangePasswordRequest $request
     * @param \App\User $user
     */
    public function profileChangePassword(UpdatePasswordRequest $request) {

        try {
            $loggedUser = \Auth::guard()->user();

            $user = User::find($loggedUser->id);
            $user->password = $request->password;
            if ($user->save()) {
                \Session::flash('success', 'Your password has been changed successfully.');
            } else {
                \Session::flash('error', 'Your password hasn\'t been changed.');
            }

            return redirect()->back();
        } catch (Exception $ex) {

        }
    }


    public function addrole($roleid)
    {

        $loggedUser = \Auth::guard()->user();
        try{
                DB::table('users')
                   ->where("id", '=',  $loggedUser->id)
                   ->update(['role_id'=> $roleid]);

                DB::commit();
                $responce =  ['status' => true,'message' => 'Role updated Successfully'];
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $responce =  ['status' => false,'message' => $e->getMessage()];
            }
            return $responce;
    }


    public function featurepayment(Request $request)
    {

    $token = $request->token;
    $productID = $request->productid;
    $amount = $request->amount * 100;
    DB::table('products')
                       ->where('id', $productID)
                       ->update(['is_feature' => 1]);

       \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));
      $charge = \Stripe\Charge::create(['amount' => $amount, 'currency' => 'usd', 'source' => $token]);



    if($charge->status == 'succeeded'){

     $featuredStartDate = date('Y-m-d H:i:s');
     $featuredEndDate = date('Y-m-d H:i:s', strtotime('+14 days', strtotime($featuredStartDate)));
     $values = array('product_id' => $productID,'feature_price'=> $request->amount,'transcation_id'=>$charge->balance_transaction,'status'=>'1','feature_start_date'=>$featuredStartDate,'feature_end_date'=>$featuredEndDate);
     DB::table('product_features')->insert($values);
     $products = Product::find($productID);
     Product::FeatureEmailToadmin($products);
     $responce =  ['status' => true,'message' => 'Product has been set as featured successfully.'];
    }
    else{
        $responce =  ['status' => true,'message' => 'Payment not done, please try again'];
     }
     return $responce;

    }



    public function addPaymentDetail()
    {
        $logInedUser=\Auth::user();
        $user=\Auth::user();
        return view('usermanager::Users.add-payment-detail',compact('logInedUser','user'));

    }


    public function UpdateAccountStripe(UsersupdatestripeRequest $request)
    {

        $user=\Auth::user();
        $response = User::UpdateAccountOnStripe($request,$user);
     
        
        if(isset($response->error)){
            
            return redirect()->back()->with('message', $response->error->code);
            
        }else{
          
           return redirect()->back()->with('message', 'Your account details have been successfully updated.');  
        }
        
        


       
        


    }


}
