<?php

namespace Modules\RestaurentsManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\RestaurentsManager\Entities\Restaurents;
use Modules\RestaurentsManager\Entities\RestaurantTimes;
use Illuminate\Support\Facades\DB;

class RestaurentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $allowed_columns = ['id', 'name',];


        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';



        $resto = Restaurents::orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));

        //$products = Product::status(request('status'))->filter(request('keyword'))->categoryWise(request('category_id'))->orderBy($sort, $order)->with('category')->with('ProductImages')->with('user')->paginate(config('get.ADMIN_PAGE_LIMIT'));

        return view('restaurentsmanager::admin.index',compact('resto'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */


    public function create(Request $request)
    {
        return view('restaurentsmanager::admin.createOrUpdate');
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {


        $array = collect($request)->except('_token')->all();

        try {

            if($request->file('restro_picture')){

                $file     = $request->file('restro_picture');
                $filename = $file->getClientOriginalName();

                $path = $request->file('restro_picture')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['restro_picture'] = $path;
            }

            $restro = Restaurents::create($array);

            $MorningStartTime = array_filter($request->morning_open_time);
            $MorningEndTime = array_filter($request->morning_close_time);
            $EveningSatrtTime = array_filter($request->evening_open_time);
            $EveningEndTime = array_filter($request->evening_close_time);

            if(!empty($request->day) && isset($request->day)){

            foreach($request->day as $value){

                $restuarantTimeArray = array();

                if($value == 'Monday - Friday'){
                    $indexs = 0;
                
                }



                $restuarantTimeArray['restaurant_id'] = $restro->id;
                $restuarantTimeArray['week_day'] = $value;

                if(isset($MorningStartTime[$indexs])){
                $restuarantTimeArray['morning_open_time'] = $MorningStartTime[$indexs];
                }else{
                    $restuarantTimeArray['morning_close_time'] = '';
                }

                if(isset($MorningEndTime[$indexs])){
                $restuarantTimeArray['morning_close_time'] = $MorningEndTime[$indexs];
                }else{
                    $restuarantTimeArray['morning_close_time'] = '';
                }
                if(isset($EveningSatrtTime[$indexs])){
                    $restuarantTimeArray['evening_open_time'] = $EveningSatrtTime[$indexs];
                }else{
                    $restuarantTimeArray['evening_open_time'] = '';
                }

                if(isset($EveningEndTime[$indexs])){
                    $restuarantTimeArray['evening_close_time'] = $EveningEndTime[$indexs];
                }else{
                    $restuarantTimeArray['evening_close_time'] = '';
                }

                $restuarantTimeArray['status'] = 1;


                   $restrotimes = RestaurantTimes::create($restuarantTimeArray);



            }
        }



        } catch (\Illuminate\Database\QueryException $e) {

            return back()->withError($e->getMessage())->withInput();
        }

      return redirect()->route('admin.restaurents.index', app('request')->query())->with('success', 'Restaurant has been saved Successfully');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {   $restro = Restaurents::With('restaurantTime')->find($id);

        return view('restaurentsmanager::admin.show',compact('restro'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */



    public function edit(Request $request, $id)
    {
        $restro = Restaurents::find($id);

        return view('restaurentsmanager::admin.createOrUpdate', compact('restro'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */


    public function update(Request $request, $id)
    {


        $array = collect($request)->except('_token')->all();

        try {
            $restro = Restaurents::find($id);

            if($request->file('restro_picture')){

                $file     = $request->file('restro_picture');
                $filename = $file->getClientOriginalName();

                $path = $request->file('restro_picture')->storeAs(
                    'public/profileImage', $filename
                    );
                $array['restro_picture'] = $path;
            }

             $restro->fill($array);

            $restro->save();

            $MorningStartTime = array_filter($request->morning_open_time);
            $MorningEndTime = array_filter($request->morning_close_time);
            $EveningSatrtTime = array_filter($request->evening_open_time);
            $EveningEndTime = array_filter($request->evening_close_time);

            if(!empty($request->day) && isset($request->day)){
                RestaurantTimes::where('restaurant_id',$id)->delete();



            foreach($request->day as $value){

                $restuarantTimeArray = array();

                if($value == 'Monday - Friday'){
                    $indexs = 0;
                
                }



                $restuarantTimeArray['restaurant_id'] = $id;
                $restuarantTimeArray['week_day'] = $value;

                if(isset($MorningStartTime[$indexs])){
                $restuarantTimeArray['morning_open_time'] = $MorningStartTime[$indexs];
                }else{
                    $restuarantTimeArray['morning_close_time'] = '';
                }

                if(isset($MorningEndTime[$indexs])){
                $restuarantTimeArray['morning_close_time'] = $MorningEndTime[$indexs];
                }else{
                    $restuarantTimeArray['morning_close_time'] = '';
                }
                if(isset($EveningSatrtTime[$indexs])){
                    $restuarantTimeArray['evening_open_time'] = $EveningSatrtTime[$indexs];
                }else{
                    $restuarantTimeArray['evening_open_time'] = '';
                }

                if(isset($EveningEndTime[$indexs])){
                    $restuarantTimeArray['evening_close_time'] = $EveningEndTime[$indexs];
                }else{
                    $restuarantTimeArray['evening_close_time'] = '';
                }

                $restuarantTimeArray['status'] = 1;


                   $restrotimes = RestaurantTimes::create($restuarantTimeArray);



            }

        }

        } catch (\Illuminate\Database\QueryException $e) {

            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.restaurents.index', app('request')->query())->with('success', 'Restaurant has been updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        //  $user = User::find($id);
        $user = Restaurents::where('id', '=', $id)->first();

            // $user->roles()->detach();
            try {
                $user->delete();
                DB::commit();
                $responce = ['status' => true, 'message' => 'This Restaurent has been deleted Successfully!', 'data' => $user];
            } catch (\Exception $e) {
                DB::rollBack();
                $responce = ['status' => false, 'message' => $e->getMessage()];
            }
            return $responce;

    }
}
