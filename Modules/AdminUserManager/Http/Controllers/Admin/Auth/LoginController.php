<?php

namespace Modules\AdminUserManager\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;
use Cookie;

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
    protected $redirectTo = '/admin/dashboard';
    protected $redirectAfterLogout = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * customize the login form.
     *
     * @return mix
     */
    public function showLoginForm(Request $request){
        $adminckrem = [];
        if($request->cookie('adminckrem')){
            $adminckrem = json_decode($request->cookie('adminckrem'), true);
        }
       return view('adminusermanager::Admin.login',compact('adminckrem'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if($request->input('remember')){
                $cookinput = $request->only(['email', 'password','remember']);
                Cookie::queue('adminckrem', json_encode($cookinput));
            }else{
                Cookie::queue(Cookie::forget('adminckrem'));
            }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        /* custom cases goes here */

        /* end custom cases*/
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        $credentials = $request->only($this->username(), 'password');
        //$credentials['is_admin']= 1;
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
    protected function guard(){
         return Auth::guard('admin');
    }

    /**
     * customize the username.
     *
     * @return string
     */
    public function username(){
        return 'email';
    }

    /**
     * Remove user from session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        $this->guard()->logout($request);
        return redirect()
                    ->route('admin.login')
                    ->with(['alert_type' => 'success', 'alert_message' => __('auth.logged_out')]);
    }
}
