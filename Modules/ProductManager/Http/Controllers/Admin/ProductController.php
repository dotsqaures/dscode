<?php

namespace Modules\ProductManager\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ProductManager\Entities\Product;
use Illuminate\Support\Facades\DB;
use Modules\ProductManager\Http\Requests\ProductRequest;
use Modules\CategoriesManager\Entities\Categories;
use Modules\ProductManager\Entities\ProductImage;
use Modules\DeviceManager\Entities\Device;
use Modules\StoragesManager\Entities\Storages;
use Modules\ModelManager\Entities\Devicemodel;
use Modules\ColorsManager\Entities\Colors;

use Modules\BrokenDevicesManager\Entities\BrokenDevices;
use Modules\CarriersManager\Entities\Carriers;
use Modules\HeadlineOnesManager\Entities\HeadlineOnes;
use Modules\HeadlineTwosManager\Entities\HeadlineTwos;
use Modules\HeadlineThreesManager\Entities\HeadlineThrees;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        $allowed_columns = ['id', 'item_title', 'phone_purchase_date','phone_condition','selling_price'];
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';
        $order = $request->get('direction') === 'desc' ? 'desc' : 'desc';
        //$products = Product::orderBy('id', 'desc')->paginate(config('get.ADMIN_PAGE_LIMIT'));

        $products = Product::status(request('status'))->filter(request('keyword'))->categoryWise(request('category_id'))->orderBy($sort, $order)->with('category')->with('ProductImages')->with('user')->paginate(config('get.ADMIN_PAGE_LIMIT'));


        $categories = Categories::orderBy('title', 'asc')->pluck('title', 'id', 'status');
        $categories->prepend('Select Category', "");


        $Devices = Device::orderBy('device_name', 'asc')->pluck('device_name', 'device_name', 'status');
        $Devices->prepend('Select Device type', "");


        return view('productmanager::admin.index',compact('products','categories','Devices'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {


        $categories = Categories::orderBy('title', 'asc')->pluck('title', 'id', 'status');
        $categories->prepend('Select Category', "");

        $Devices = Device::orderBy('device_name', 'asc')->pluck('device_name', 'device_name', 'status');
        $Devices->prepend('Select Device type', "");

        return view('productmanager::admin.createOrUpdate',compact('categories','Devices'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {

        $array = collect($request)->except(['_token','product_image'])->all();

        try{


            if($request->file('item_video')){

                $file     = $request->file('item_video');
                $filename = $file->getClientOriginalName();

                $path = $request->file('item_video')->storeAs(
                    'public/ProductVideo', $filename
                    );
                $array['item_video'] = $path;
            }

            $array['user_id'] = '1';

            $insertproduct = Product::create($array);




            if(!empty($request->only(['product_image']))){

                $imgData = $request->file('product_image');

               foreach($imgData as $pimage){

                $path = $pimage->store(
                    'public/ProductImages'
                    );

                    $proimag = new productImage();
                    $proimag->product_image = $path;

                    $insertproduct->ProductImages()->save($proimag);

                    }



                }


        }
        catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.product.index')->with('success', 'Product has been saved Successfully');

    }

   

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {




        $Product = Product::findOrFail($id)->where('id' ,'=', $id)->with('ProductImages')->first();

        $storageName = Storages::where('id',$Product->storage)->first();
        $Carriername = Carriers::where('id',$Product->carrier_id)->first();

        return view('productmanager::admin.show',compact('Product','storageName','Carriername'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {

        //$products = Product::find($id);

        $products = Product::where('id' ,'=', $id)->with('ProductImages')->first();

        $categories = Categories::orderBy('title', 'asc')->pluck('title', 'id', 'status');
        $categories->prepend('Select Category', "");


        $Devices = Device::orderBy('device_name', 'asc')->pluck('device_name', 'device_name', 'status');
        $Devices->prepend('Select Device type', "");


        $colors =  Colors::where([['status','1'],['color_name',$products->colour]])->orderBy('id', 'asc')->pluck('color_name', 'color_name', 'status');
        $colors->prepend('Select Colour', "");

        $storage = Storages::where([['status','1'],['id',$products->storage]])->orderBy('id', 'asc')->pluck('storage_name', 'id', 'status');
        $storage->prepend('Select Storage', "");

        //$DevicesModel = Devicemodel::where([['status','1'],['category_id',$products->category_id]])->orderBy('model_name', 'asc')->get();

        $headlines1 = HeadlineOnes::where('status','1')->get();
        $headlines2 = HeadlineTwos::where('status','1')->get();
        $headlines3 = HeadlineThrees::where('status','1')->get();

        $Carriers = Carriers::where([['status','1'],['id',$products->carrier_id]])->orderBy('carrier_name', 'asc')->pluck('carrier_name', 'id', 'status');
        $Carriers->prepend('Select Carrier', "");

        return view('productmanager::admin.createOrUpdate',compact('products','categories','Devices','colors','storage','headlines1','headlines2','headlines3','Carriers'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $array = collect($request)->except(['_token','product_image'])->all();
        try{
            $products = Product::find($id);



            $products->fill($array);
           $insertproduct =  $products->save();





          }
          catch (\Illuminate\Database\QueryException $e) {
              return back()->withError($e->getMessage())->withInput();
          }
        return redirect()->route('admin.product.index')->with('success', 'Rating  update successfully');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $products = Product::where('id', '=', $id)->first();

            try{
                $products->delete();
                DB::commit();
                $responce =  ['status' => true,'message' => 'This Product has been deleted Successfully!','data' => $products];
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $responce =  ['status' => false,'message' => $e->getMessage()];
            }
            return $responce;
    }




    public function deleteimage($id)
    {


        DB::beginTransaction();
        $productimage = ProductImage::where('id', '=', $id)->first();

            try{
                $productimage->delete();
                DB::commit();
                $responce =  ['status' => true,'message' => 'This Product Image has been deleted Successfully!'];
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $responce =  ['status' => false,'message' => $e->getMessage()];
            }
            return $responce;
    }


    public function  accept($id)
    {
               DB::table('products')
                ->where('id', $id)
                ->update(['status' => 1]);

                $products = Product::with('user')->find($id);



                Product::sendAcceptRejectMail($products);
                return redirect()->route('admin.product.index')->with('success', 'Product has been approved successfully.');

    }


    public function  reject($id)

    {
          DB::table('products')
            ->where('id', $id)
            ->update(['status' => 2]);

            $products = Product::with('user')->find($id);

            Product::sendAcceptRejectMail($products);
        return redirect()->route('admin.product.index')->with('success', 'Product has been rejected successfully.');

    }


    public function sentnotitifytoseller(Request $request)
    {
                $productid =  $request->productid;
                $message =  $request->message;

                $products = Product::with('user')->find($productid);


               Product::SendNotificationtoSellerForImprovementInProduct($products,$message);
               return redirect()->route('admin.product.index')->with('success', 'Message has been successfully sent.');

    }





}
