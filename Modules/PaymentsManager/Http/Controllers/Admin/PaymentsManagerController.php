<?php

namespace Modules\PaymentsManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\OrdersManager\Entities\Orders;
use Illuminate\Support\Facades\DB;
use Modules\OrdersManager\Http\Requests\OrdersRequest;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\ProductManager\Entities\Cart;
use Modules\ProductManager\Entities\Order;
use Modules\ProductManager\Entities\OrderDetail;
use Modules\ProductManager\Entities\ProductFeature;
use Modules\ProductManager\Entities\ReturnOrder;
use Carbon\Carbon;
class PaymentsManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if(!empty($request->all()))
        {
           if($request->status == 1)
           {
            $featureData = [];
            $startdate = date("Y-m-d", strtotime($request->start_date) );
            $senddate = date("Y-m-d", strtotime($request->end_date) );
	    $orderData = Order::whereDate('order_date','>=',$startdate.' 00:00:00')->whereDate('order_date','<=',$senddate.' 23:59:59')->with('OrderDetailsData.product.user')->get();
            $totalreturn = ReturnOrder::where('status',3)->whereDate('return_confirm_order','>=',$startdate.' 00:00:00')->whereDate('return_confirm_order','<=',$senddate.' 23:59:59')->get();

            
            
            $ReturnordermonthData= array();
            for ($i=1; $i<=13; $i++){

            $monthwiseData[$i-1] = DB::table("orders")
              ->select(DB::raw("SUM(total_amount) as total_count"))
              ->whereDate('order_date','>=',$startdate.' 00:00:00')->whereDate('order_date','<=',$senddate.' 23:59:59')
              ->whereMonth('order_date', date('m',strtotime($i.' month')))->get();

              $ReturnordermonthData[$i-1] = DB::table("return_orders")
              ->select(DB::raw("SUM(amount) as total"))
              ->where('status',3)
              ->whereDate('return_confirm_order','>=',$startdate.' 00:00:00')->whereDate('return_confirm_order','<=',$senddate.' 23:59:59')
              ->whereMonth('return_confirm_order', date('m',strtotime($i.' month')))->get();


            }

            unset($monthwiseData[0]);
            unset($ReturnordermonthData[0]);

            foreach($monthwiseData as $va)
            {
                $ordercountmonthwsie[] =  $va[0]->total_count;
            }

            foreach($ReturnordermonthData as $va)
            {
                $Returnodermonthwsie[] =  $va[0]->total;
            }


            return view('paymentsmanager::admin.index',compact('featureData','orderData','startdate','senddate','ordercountmonthwsie','Returnodermonthwsie','totalreturn'));
           }elseif($request->status == 2){


            $orderData = [];
            $senddate = date("Y-m-d", strtotime($request->start_date) );
            $startdate = date("Y-m-d", strtotime($request->end_date) );
            

            $currentDate = date('Y-m-d');
            if($currentDate == $senddate && $currentDate == $startdate)
            {  
              
               $featureData = ProductFeature::whereDate('feature_start_date','>=',$startdate.' 00:00:00')->whereDate('feature_start_date','<=',$senddate.' 23:59:59')->get();
             }else {
          
              
               $featureData = ProductFeature::whereDate('feature_start_date','<=',$startdate.' 00:00:00')->whereDate('feature_start_date','>=',$senddate.' 23:59:59')->get();
               }

            for ($i=1; $i<=13; $i++){
                $featuremonthData[$i-1] = DB::table("product_features")
                ->select(DB::raw("SUM(feature_price) as total"))
                ->whereMonth('feature_start_date', date('m',strtotime($i.' month')))->get();
              }

            unset($featuremonthData[0]);
            foreach($featuremonthData as $va)
            {
                $Featuremonthwsie[] =  $va[0]->total;
            }




            return view('paymentsmanager::admin.index',compact('orderData','featureData','startdate','senddate','Featuremonthwsie'));

           }else{

          $senddate = date("Y-m-d", strtotime($request->start_date));
          $startdate = date("Y-m-d", strtotime($request->end_date));
            
             //$orderData = Order::whereDate('order_date','>=',$startdate.' 00:00:00')->whereDate('order_date','<=',$senddate.' 23:59:59')->with('OrderDetailsData.product.user')->get();
            //$totalreturn = ReturnOrder::where('status',3)->whereDate('return_confirm_order','>=',$startdate.' 00:00:00')->whereDate('return_confirm_order','<=',$senddate.' 23:59:59')->get();

           $currentDate = date('Y-m-d');
            if($currentDate == $senddate && $currentDate == $startdate)
            {  
              $orderData =  Order::whereDate('order_date','>=',$startdate.' 00:00:00')->whereDate('order_date','<=',$senddate.' 23:59:59')->with('OrderDetailsData.product.user')->get();
              $featureData = ProductFeature::whereDate('feature_start_date','>=',$startdate.' 00:00:00')->whereDate('feature_start_date','<=',$senddate.' 23:59:59')->get();
              $totalreturn = ReturnOrder::where('status',3)->whereDate('return_confirm_order','>=',$startdate.' 00:00:00')->whereDate('return_confirm_order','<=',$senddate.' 23:59:59')->get();
           
             }else {
          
               $orderData =  Order::whereDate('order_date','<=',$startdate.' 00:00:00')->whereDate('order_date','>=',$senddate.' 23:59:59')->with('OrderDetailsData.product.user')->get();
               $featureData = ProductFeature::whereDate('feature_start_date','<=',$startdate.' 00:00:00')->whereDate('feature_start_date','>=',$senddate.' 23:59:59')->get();
               $totalreturn = ReturnOrder::where('status',3)->whereDate('return_confirm_order','<=',$startdate.' 00:00:00')->whereDate('return_confirm_order','>=',$senddate.' 23:59:59')->get();
             }
          
          
            
            $ReturnordermonthData= array();
            for ($i=1; $i<=13; $i++){

            $monthwiseData[$i-1] = DB::table("orders")
              ->select(DB::raw("SUM(total_amount) as total_count"))
              ->whereDate('order_date','<=',$startdate.' 00:00:00')->whereDate('order_date','>=',$senddate.' 23:59:59')
              ->whereMonth('order_date', date('m',strtotime($i.' month')))->get();

              $ReturnordermonthData[$i-1] = DB::table("return_orders")
              ->select(DB::raw("SUM(amount) as total"))
              ->where('status',3)
              ->whereDate('return_confirm_order','<=',$startdate.' 00:00:00')->whereDate('return_confirm_order','>=',$senddate.' 23:59:59')
              ->whereMonth('return_confirm_order', date('m',strtotime($i.' month')))->get();

              $featuremonthData[$i-1] = DB::table("product_features")
              ->select(DB::raw("SUM(feature_price) as total"))
              ->whereMonth('feature_start_date', date('m',strtotime($i.' month')))->get();


            }

            unset($monthwiseData[0]);
            unset($ReturnordermonthData[0]);
            unset($featuremonthData[0]);

            foreach($monthwiseData as $va)
            {
                $ordercountmonthwsie[] =  $va[0]->total_count;
            }

            foreach($ReturnordermonthData as $va)
            {
                $Returnodermonthwsie[] =  $va[0]->total;
            }

            foreach($featuremonthData as $va)
            {
                $Featuremonthwsie[] =  $va[0]->total;
            }


           return view('paymentsmanager::admin.index',compact('orderData','featureData','startdate','senddate','ordercountmonthwsie','ReturnordermonthData','Returnodermonthwsie','Featuremonthwsie','totalreturn'));

           }

          $orderData = [];
          return view('paymentsmanager::admin.index',compact('orderData','featureData','startdate','senddate','ordercountmonthwsie','ReturnordermonthData','Returnodermonthwsie','Featuremonthwsie','totalreturn'));

        }else{

			$senddate = '';
            $startdate = '';
            $orderData = Order::with('OrderDetailsData.product.user')->get();
            $featureData = ProductFeature::get();
            $totalreturn = ReturnOrder::where('status',3)->get();





           $ReturnordermonthData= array();
            for ($i=1; $i<=13; $i++){

            $monthwiseData[$i-1] = DB::table("orders")
              ->select(DB::raw("SUM(total_amount) as total_count"))
              ->whereMonth('order_date', date('m',strtotime($i.' month')))->get();

              $ReturnordermonthData[$i-1] = DB::table("return_orders")
              ->select(DB::raw("SUM(amount) as total"))
              ->where('status',3)
              ->whereMonth('return_confirm_order', date('m',strtotime($i.' month')))->get();

              $featuremonthData[$i-1] = DB::table("product_features")
              ->select(DB::raw("SUM(feature_price) as total"))
              ->whereMonth('feature_start_date', date('m',strtotime($i.' month')))->get();


            }

            unset($monthwiseData[0]);
            unset($ReturnordermonthData[0]);
            unset($featuremonthData[0]);

            foreach($monthwiseData as $va)
            {
                $ordercountmonthwsie[] =  $va[0]->total_count;
            }

            foreach($ReturnordermonthData as $va)
            {
                $Returnodermonthwsie[] =  $va[0]->total;
            }

            foreach($featuremonthData as $va)
            {
                $Featuremonthwsie[] =  $va[0]->total;
            }

           //$retrunorder = ReturnOrder::where('status',3)->whereDate('feature_start_date','<=',$startdate.' 00:00:00')->whereDate('feature_start_date','>=',$senddate.' 23:59:59')->get();

        return view('paymentsmanager::admin.index',compact('orderData','featureData','startdate','senddate','ordercountmonthwsie','ReturnordermonthData','Returnodermonthwsie','Featuremonthwsie','totalreturn'));
       }
    }



    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('paymentsmanager::create');
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
        return view('paymentsmanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('paymentsmanager::edit');
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
