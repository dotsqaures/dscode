<?php

namespace Modules\UserManager\Http\Controllers\Auth;
use Illuminate\Http\Response;
use Modules\UserManager\Entities\User;
use Modules\UserManager\Entities\UserAddresses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Modules\UserManager\Entities\Role;
use Modules\UserManager\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Session;
use Twilio\Exceptions\TwilioException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
   // protected $redirectTo = '/login';

    protected $redirectTo = '/otpverify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        //$this->middleware('setcurrency');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $otpnumber = mt_rand(100000,999999);
        $data['otp_token'] = $otpnumber;
        //$data['otp_token'] = '123456';
        \Session::put('otpnumber', $otpnumber);
        \Session::put('emailaddress', $data['email']);
        \Session::put('mobileno',$data['mobileno']);


        
         $response = User::CreateAccountOnStripe($data);
     

         $data['stripe_account_id'] = $response;

      

        // Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
       $user = User::create($data);
       return $user;
    }

     /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $user  =\Auth::guard()->user();
        if($user){
            return redirect('dashboard');
        }

        return view('usermanager::Users.auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UsersRequest $request)
    {
           try{
                event(new Registered($user = $this->create($request->except(['agree']))));
                return $this->registered($request, $user)
                                ?: redirect($this->redirectPath($user->id))->with('success', 'We have sent you a verification code to your mobile number. Please enter it below to verify your account.');
               }
           catch (\Throwable $th) {

                    if($th->getCode() == 23000){

                        return back()->withError('This email already  exists.')->withInput();
                    }
           }
        
      }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(UsersRequest $request, $user)
    {
        $ToNumber =  '+61'.str_replace(' ', '', $user->mobileno);

        $sid = config('get.twilio-sid-key');
        $token = config('get.twili-auth-key');

       $otpnumber = \Session::get('otpnumber');
        $client = new Client($sid, $token);
         try {
        $message = $client->messages->create(
            $ToNumber, // Text this number
          array(
            'from' => 'SBDevice', // From a valid Twilio number
            'body' => 'Your OTP is '.$otpnumber,
          )
        );
    }catch (TwilioException $e) {
        $e->getCode() . ' : ' . $e->getMessage()."<br>"; 
    }

        Session::forget('otpnumber');

    }
}
