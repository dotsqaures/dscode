<?php

namespace Modules\StampsManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\StampsManager\Entities\Stamps;
use Modules\UserManager\Entities\User;
use Illuminate\Support\Facades\DB;

class StampsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */


    public function index(Request $request)
    {
        $allowed_columns = ['id', 'title',];


        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $resto = Stamps::where('is_deleted',0)->orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));
        return view('stampsmanager::admin.index',compact('resto'));

    }

    public function freecards(Request $request){
        $userdata = User::where('role_id','1')->pluck('first_name','id');
        $userdata->prepend('Select User', "");

        $stampdata = Stamps::where('is_deleted',0)->pluck('title','id');
        $stampdata->prepend('Select Stamp', "");

        return view('stampsmanager::admin.freecards',compact('userdata','stampdata'));
    }

    public function updatefreecard(Request $request){



          $strampirce = Stamps::where('id',$request->charge_id)->first();

          $date = date('Y-m-d H:i:s');

          $values = array('user_id'=>$request->user_id, 'transcation_id'=>'FreecardUser','charge_id'=>$request->charge_id,'total_amount'=>$strampirce->normal_price,'status'=>'2','created_at'=>$date,'updated_at'=>$date);
          $orderId = DB::table('orders')->insertGetId($values);
          return redirect()->route('admin.stamps.freecards')->with('success', 'Free Stamp gave to user Successfully');
          //return back()->withError('free card added to user successfully.')->withInput();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */


    public function create(Request $request)
    {
        return view('stampsmanager::admin.createOrUpdate');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $array = collect($request)->except('_token')->all();
        DB::beginTransaction();
        try {





            if($request->file('stamp_picture')){

                $file     = $request->file('stamp_picture');
                $filename = $file->getClientOriginalName();

                $path = $request->file('stamp_picture')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['stamp_picture'] = $path;
            }

            $restro = Stamps::create($array);


            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.stamps.index', app('request')->query())->with('success', 'Stamps has been saved Successfully');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $restro = Stamps::find($id);
        return view('stampsmanager::admin.show',compact('restro'));

    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */


    public function edit(Request $request, $id)
    {
        $restro = Stamps::find($id);

        return view('stampsmanager::admin.createOrUpdate', compact('restro'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {


        $array = collect($request)->except('_token')->all();
        DB::beginTransaction();
        try {
            $restro = Stamps::find($id);
            if($request->file('stamp_picture')){

                $file     = $request->file('stamp_picture');
                $filename = $file->getClientOriginalName();

                $path = $request->file('stamp_picture')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['stamp_picture'] = $path;
            }
             $restro->fill($array);

            $restro->save();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.stamps.index', app('request')->query())->with('success', 'Stamp has been updated Successfully');

    }
    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {

        //  $user = User::find($id);
        $user = Stamps::where('id', $id)->first();


            try {
                Stamps::where('id', $id)
                ->update([
                    'is_deleted' => '1'
                 ]);

                $responce = ['status' => true, 'message' => 'This Stamp Card has been deleted Successfully!', 'data' => $user];
            } catch (\Exception $e) {

                $responce = ['status' => false, 'message' => $e->getMessage()];
            }
            return $responce;

    }
}
