<?php

namespace Modules\AdminUserManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManager\Entities\User;
use Modules\ProductManager\Entities\Order;
use Modules\StampsManager\Entities\RedemStamp;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $Users = User::where('role_id',1)->get();
        $employee = User::where('role_id',2)->get();
        $order = Order::all();
        $senddate = date('Y-m-d');
        $todayRedem =  RedemStamp::whereDate('created_at','=',$senddate)->get();
        
       // $orderData = $orderData->filter(request('keyword'))->orderBy($sort, $order)->with('user')->with('RedemData')->paginate(config('get.ADMIN_PAGE_LIMIT'));
       /* $Product = Product::all();
        $order = Order::all();
        $retunrorder = ReturnOrder::all();
        $senddate = date('Y-m-d H:i:s');
        $startdate = date('Y-m-d H:i:s', strtotime('-7 days', strtotime($senddate)));
        $monthdate = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($senddate)));

        $WeeklyorderData =  Order::whereDate('order_date','>=',$startdate.' 00:00:00')->whereDate('order_date','<=',$senddate)->with('OrderDetailsData.product.user')->get();
        $monthlyorderData =  Order::whereDate('order_date','>=',$monthdate.' 00:00:00')->whereDate('order_date','<=',$senddate)->with('OrderDetailsData.product.user')->get();*/
        return view('adminusermanager::Admin.Dashboard.index',compact('Users','employee','order','todayRedem'));
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
        return view('adminusermanager::edit');
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
}
