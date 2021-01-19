<?php

namespace Modules\OrdersManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\OrdersManager\Entities\Orders;
use Illuminate\Support\Facades\DB;
use Modules\OrdersManager\Http\Requests\OrdersRequest;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\ProductManager\Entities\Cart;
use Modules\ProductManager\Entities\Order;
use Modules\StampsManager\Entities\Stamp;
use Modules\StampsManager\Entities\RedemStamp;
use Modules\ProductManager\Entities\OrderDetail;
use Modules\UserManager\Entities\User;
use Carbon\Carbon;

class OrdersController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {
        $allowed_columns = ['id', 'order_id','transcation_id'];
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $orderData = Orders::where([['status',2],['transcation_id','!=','FreecardUser'],['transcation_id','!=','FirstFreeCard']])->status(request('status'));
        if (request('start_date') && request('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->start_date)) . ' 00:00:00';
            $end_date = date("Y-m-d", strtotime($request->end_date)) . ' 23:59:59';
//            echo $start_date.'=='.$end_date;die;
            $orderData = $orderData->whereDate('order_date', '>=', $start_date)->with('user')->whereDate('order_date', '<=', $end_date);
        }
        $orderData = $orderData->filter(request('keyword'))->orderBy($sort, $order)->with('user')->paginate(20);
        return view('ordersmanager::admin.index', compact('orderData'));
    }


    public function histroy(Request $request) {
        $allowed_columns = ['id', 'order_id','transcation_id'];
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $orderData = RedemStamp::where('status',0);
        $orderredem = RedemStamp::where('status',0);
        if (request('start_date') && request('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->start_date)) . ' 00:00:00';
            $end_date = date("Y-m-d", strtotime($request->end_date)) . ' 23:59:59';
//            echo $start_date.'=='.$end_date;die;
            $orderData = $orderData->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            $totalredem = $orderredem->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }
       // $orderData = $orderData->filter(request('keyword'))->orderBy($sort, $order)->with('user')->with('RedemData')->paginate(20);



       $orderData = $orderData->filter(request('keyword'))->orderBy($sort, $order)->paginate(20);

       $totalredem = $orderredem->filter(request('keyword'))->orderBy($sort, $order)->get();

        return view('ordersmanager::admin.histroy', compact('orderData','totalredem'));
    }


    public function notification(){

         $Userlist = User::where('role_id',1)->get();

        return view('ordersmanager::admin.notification', compact('Userlist'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('ordersmanager::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {

        $Userlist = User::where('role_id',1)->get();

        if(!empty($request->user_id) && !empty($request->desciption)){
        foreach($request->user_id as $val){

            $userdata = User::where('id',$val)->first();

            if(isset($userdata)){

        $url = 'https://fcm.googleapis.com/fcm/send';

     $key = 'AAAAvgd7OIk:APA91bG-zNk9Py_HfVc-86WZLlpZqAPMK8EhAPZVkcZyAxiOepAyeXpWLvo7rxnAaGok6srysJ5mMQFLgWOUjUwv_SqtJyNEx31BHv2EM9Yb0MroVPisAO5Z9-wHKqpVthv3JSfSO0IR';
     $headers = array('Authorization: key=' . $key, 'Content-Type: application/json');
     $user = auth()->guard('api')->user();

     $finalmsg["body"] = $request->desciption;

     $finalmsg["title"] = "Mad & Kaffe";
     $finalmsg["message"] = $request->desciption;
     $finalmsg["type"] = 'Admin Notification';
     $finalmsg["login_user_name"] = $userdata->first_name;

     $finalmsg["unique_key"] = mt_rand(10000, 99999);
     $finalmsg["priority"] = 'high';
     $finalmsg["sound"] = 'default';

        $fields = array(
             'to' => $userdata->fcm,
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
        }
        }
        //redirect()->back()->withSuccess('Notification sent successfully.');
        return redirect()->route('admin.Orders.notification', compact('Userlist'))->with('success', 'Notification sent Successfully');
       // return view('ordersmanager::admin.notification', compact('Userlist'));
    }else{
        return redirect()->route('admin.Orders.notification', compact('Userlist'))->with('error', 'User name and message is required.');
    }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($orderid) {
        $orderData = Order::where('id', $orderid)->with('OrderDetailsData.product.user')->get();

        return view('ordersmanager::admin.show', compact('orderData'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit() {
        return view('ordersmanager::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id) {
        DB::beginTransaction();
        //  $user = User::find($id);
        $user = Order::where('id', '=', $id)->first();

            // $user->roles()->detach();
            try {
                $user->delete();
                DB::commit();
                $responce = ['status' => true, 'message' => 'Record been deleted Successfully!', 'data' => $user];
            } catch (\Exception $e) {
                DB::rollBack();
                $responce = ['status' => false, 'message' => $e->getMessage()];
            }
            return $responce;
    }

}
