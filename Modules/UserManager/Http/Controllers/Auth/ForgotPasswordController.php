<?php

namespace Modules\UserManager\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    protected $redirectTo = '/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $user  =\Auth::guard()->user();
        if($user){
            return redirect('dashboard');
        }
        return view('usermanager::Users.auth.passwords.email');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker('users');
    }

/**
     * Handle a send reset link email request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $user_check = \Modules\UserManager\Entities\User::where('email', $request->email)->select(['id','first_name','last_name','mobileno','email','status','is_verified'])->first();



        if(!empty($user_check) && $user_check->is_verified === 0){
            return back()->withInput($request->input())->withErrors('Your account is not verified. Please verify your account.');
        }

        if(!empty($user_check) && $user_check->status === 0){
            return back()->withInput($request->input())->withErrors('Your account is not active.Please contact to SellBuyDevice team.');
        }

        /* custom cases*/
            //.....
        /* end custom cases*/

        $response = $this->broker()->sendResetLink(
                    $request->only('email')
                );
        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('success', trans($response));
        }

        return back()->withInput($request->input())->withErrors(
            ['email' => trans($response)]
        );
    }

}
