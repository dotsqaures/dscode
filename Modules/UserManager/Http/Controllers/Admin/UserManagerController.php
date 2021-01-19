<?php

namespace Modules\UserManager\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManager\Http\Requests\UsersRequest;
use Modules\RestaurentsManager\Entities\Restaurents;
use Illuminate\Support\Facades\DB;
use Modules\UserManager\Entities\User;
use App\UserRole;


class UserManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $allowed_columns = ['id', 'first_name', 'last_name', 'email', 'mobile'];
        $roles = UserRole::orderBy('id', 'asc')->pluck('role', 'id')->toArray();

        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';

       // $users = User::orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));

        $users = User::where(['role_id'=>1])->status(request('status'))->filter(request('keyword'))->orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));

        //$products = Product::status(request('status'))->filter(request('keyword'))->categoryWise(request('category_id'))->orderBy($sort, $order)->with('category')->with('ProductImages')->with('user')->paginate(config('get.ADMIN_PAGE_LIMIT'));

        return view('usermanager::admin.index',compact('users','roles'));
    }


    public function employee(Request $request)
    {

        $allowed_columns = ['id', 'first_name', 'last_name', 'email', 'mobile'];

        //$users = $query->paginate(config('get.ADMIN_PAGE_LIMIT'));
         $roles = UserRole::orderBy('id', 'asc')->pluck('role', 'id')->toArray();

        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $users = User::where(['role_id'=>2])->status(request('status'))->filter(request('keyword'))->orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));


        return view('usermanager::admin.employee',compact('users','roles'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $restro = Restaurents::orderBy('id', 'asc')->pluck('name', 'name');
        $restro->prepend('Select Restaurent', "");



        return view('usermanager::admin.createOrUpdate',compact('restro'));
    }


    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $roles = UserRole::orderBy('role', 'DESC')->pluck('role', 'id')->toArray();

        $ofType = $request->get('role') ? $request->get('role') : 1;
        $userType = isset($roles[$ofType]) ? $roles[$ofType] : 'User';

        $restro = Restaurents::orderBy('id', 'asc')->pluck('name', 'name', 'status');
        $restro->prepend('Select Restaurent', "");

        return view('usermanager::admin.createOrUpdate', compact('user','restro', 'roles',  'userType', 'ofType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(UsersRequest $request)
    {
        $array = collect($request)->except('_token')->all();
        DB::beginTransaction();
        try {

            if($request->file('profle_photo')){

                $file     = $request->file('profle_photo');
                $filename = $file->getClientOriginalName();

                $path = $request->file('profle_photo')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['profle_photo'] = $path;
            }

            $array['role_id'] = 2;
            $array['is_verified'] = 1;

            $user = User::create($array);

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.users.employee', app('request')->query())->with('success', 'User has been saved Successfully');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(User $user)
    {
       // return view('usermanager::admin.show');
      // dd($user);
        return view('usermanager::admin.show', compact('user'));
    }



    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UsersRequest $request, $id)
    {
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

            $user->fill($array);

            $user->save();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.users.employee', app('request')->query())->with('success', 'User has been updated Successfully');
    }else{

        $existmobile = User::where('id', '!=' ,$id)->pluck('mobileno')->toArray();
//dd($existmobile);
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

                    $user->fill($array);

                    $user->save();
                    DB::commit();
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollBack();
                    return back()->withError($e->getMessage())->withInput();
                }
                return redirect()->route('admin.users.employee', app('request')->query())->with('success', 'User has been updated Successfully');

            }
    }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        //  $user = User::find($id);
        $user = User::where('id', '=', $id)->first();

            // $user->roles()->detach();
            try {
                $user->delete();
                DB::commit();
                $responce = ['status' => true, 'message' => 'This user has been deleted Successfully!', 'data' => $user];
            } catch (\Exception $e) {
                DB::rollBack();
                $responce = ['status' => false, 'message' => $e->getMessage()];
            }
            return $responce;

    }



}
