<?php

namespace Modules\UserManager\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\UserManager\Entities\User;
use Cookie;
use Socialite;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo          = '/user-dashboard';
    protected $redirectAfterLogout = '/login';


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }



    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();


        $authuser =  $this->findOrCreateUser($user,$provider);
      
        if($authuser->status == 0){
            return redirect()->route('login')->with('error','Your account is inactive. Please contact to sell buy device team.');
            //return Redirect::to('/login')->with('message', 'Your account is inactive. Please contact to sell buy device team.'); 
           // return redirect($this->redirectTo)->with('error','Your account is inactive. Please contact to sell buy device team.');
        }else{
           Auth::login($authuser,true);
          return redirect($this->redirectTo);  
        }
       

        // $user->token;
    }


     public function findOrCreateUser($user,$provider){
         $authuser = User::where('email',$user->email)->first();

         //dd($authuser);

         if(!empty($authuser)){
            return $authuser;
        }
         return User::create([
            'first_name' => $user->name,
            'email' => $user->email,
             'status' => '1',
             'role_id' => '2',
             'is_verified' => '1',
            'access_token' => $user->token,
            'provider_id' => $user->id,
            'provider' => $provider

         ]);

     }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       // parent::__construct();
      //$this->middleware('auth:web')->except('logout');
    }

    /**
     * customize the login form.
     *
     * @return mix
     */
    public function showLoginForm(Request $request){

        $user  =\Auth::guard()->user();
        if($user){
            return redirect('dashboard');
        }

       // echo Hash::make('123456');die;
      //dd(Hash::check('12345678', '$2y$10$Tp.7yNA9uHYTlL87lBzfS.HYKW6AQFqB7h4muYTeFIGzMBRwaBGo2'));
        $authremem = [];
        if ($request->cookie('authremem')) {
            $authremem = json_decode($request->cookie('authremem'), true);
        }

        return view('usermanager::Users.auth.login', compact('authremem'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {


        $getuser = User::where('email',$request->email)->first();
       
        if(!empty($getuser)){
        if($getuser->is_verified == 0)
        { 
            return redirect()->back()->withError('Your account is not verified yet. Please verify your account.');
        }
        elseif($getuser->status == 0)
        { 
            return redirect()->back()->withError('Your account is inactive. Please contact to sell buy device team.');
        }else{
            
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            if ($request->input('remember')) {
                $cookinput = $request->only(['email', 'password', 'remember']);
                Cookie::queue('authremem', json_encode($cookinput));
            } else {
                Cookie::queue(Cookie::forget('authremem'));
            }


            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        /* custom cases goes here */

        /* end custom cases */
        return $this->sendFailedLoginResponse($request);
     }
        }else{

            $this->validateLogin($request);
            if ($this->hasTooManyLoginAttempts($request)) {

                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            if ($this->attemptLogin($request)) {
                if ($request->input('remember')) {
                    $cookinput = $request->only(['email', 'password', 'remember']);
                    Cookie::queue('authremem', json_encode($cookinput));
                } else {
                    Cookie::queue(Cookie::forget('authremem'));
                }


                return $this->sendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);
            /* custom cases goes here */

            /* end custom cases */
            return $this->sendFailedLoginResponse($request);

        }
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        $credentials = $request->only($this->username(), 'password');
        $credentials['status'] = 1;
       // $credentials['is_verified'] = 1;
        return $credentials;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request, $trans = 'auth.failed') {

        $errors = [$this->username() => trans($trans)];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors($errors);
    }

    /**
     * customize the guard.
     *
     * @return object
     */
    protected function guard() {
        return Auth::guard('web');
    }

    /**
     * customize the username.
     *
     * @return string
     */
    public function username() {
        return 'email';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    { 
        
    }

    /**
     * Remove user from session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /*public function logout(Request $request) {

        $this->guard()->logout($request);

        return redirect()
                        ->route('login')
                        ->with(['alert_type' => 'success', 'alert_message' => __('auth.logged_out')]);
    }*/

    public function logout(Request $request)
    {

		Auth::logout(); // logout user

        $this->guard()->logout();

        $request->session()->flush();

         //return redirect(\URL::previous());
        return redirect('/');
    }

}
