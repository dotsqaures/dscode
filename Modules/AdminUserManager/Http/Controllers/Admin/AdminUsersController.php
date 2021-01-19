<?php

namespace Modules\AdminUserManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminUserManager\Entities\AdminUser;
use Illuminate\Support\Facades\DB;
use Auth;
use Hash;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('adminusermanager::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('adminusermanager::create');
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
        return view('adminusermanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        $adminUser = AdminUser::find(Auth::user()->id);
        return view('adminusermanager::Admin.AdminUsers.createOrUpdate', compact('adminUser'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:admin_users,email,' . Auth::user()->id,
            'mobile' => 'required|numeric|digits_between:6,16',
        ],[
            'name.required'  => 'First Name is required field.',
            'email.required' => 'Email ID is required field',
            'email.unique' => 'This email ID have already created. please use another email id.',
        ]);
        DB::beginTransaction();

        try{

            $user = AdminUser::find(Auth::user()->id);

            $user->fill($request->all());
            $user->save();

            DB::commit();
          }
          catch (\Illuminate\Database\QueryException $e) {

            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
          }

        return redirect()->back()->with('success', 'User profile has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * Show the change password form for change a new password.
     * @return Response
     */

    public function showChangePasswordForm(){
        return view('adminusermanager::Admin.AdminUsers.changepassword');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withInput()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->withInput()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ],[
            'new-password.confirmed' => 'Your new password and Confirm New Password do not match',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }


}
