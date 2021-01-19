<?php

namespace Modules\CategoriesManager\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DeviceManager\Entities\Device;
use Modules\CategoriesManager\Entities\Categories;
use Illuminate\Support\Facades\DB;
use Modules\CategoriesManager\Http\Requests\CategoriesRequest;

class CategoriesManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        $allowed_columns = ['id', 'title', 'slug'];
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'slug';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'asc';
        //$categories = Categories::orderBy('title', 'desc')->paginate(config('get.ADMIN_PAGE_LIMIT'));

        $categories = Categories::status(request('status'))->with('deviceType')->filter(request('keyword'))->orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));

        return view('categoriesmanager::admin.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $device = Device::orderBy('device_name', 'asc')->pluck('device_name', 'id', 'status');
        $device->prepend('Select Device Type', "");

        return view('categoriesmanager::admin.createOrUpdate',compact('device'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CategoriesRequest $request)
    {   
        $array = collect($request)->except('_token')->all();
        try{


            if($request->file('image')){

                $file     = $request->file('image');
                $filename = $file->getClientOriginalName();

                $path = $request->file('image')->storeAs(
                    'public/category_image', $filename
                    );
                $array['image'] = $path;
            }

            Categories::create($array);
        }
        catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.categories.index')->with('success', 'Manufacturer has been saved Successfully');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('categoriesmanager::admin.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $category = Categories::find($id);

        $device = Device::orderBy('device_name', 'asc')->pluck('device_name', 'id', 'status');
        $device->prepend('Select Device Type', "");


       return view('categoriesmanager::admin.createOrUpdate', compact('category','device'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */

    public function update(Request $request, $id)
    {
        $array = collect($request)->except('_token')->all();
        try{
            $category = Categories::find($id);

            if($request->file('image')){

                $file     = $request->file('image');
                $filename = $file->getClientOriginalName();

                $path = $request->file('image')->storeAs(
                    'public/category_image', $filename
                    );
                $array['image'] = $path;
            }

            $category->fill($array);
            $category->save();
          }
          catch (\Illuminate\Database\QueryException $e) {
              return back()->withError($e->getMessage())->withInput();
          }
        return redirect()->route('admin.categories.index')->with('success', 'Manufacturer has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $category = Categories::where('id', '=', $id)->first();

            try{
                $category->delete();
                DB::commit();
                $responce =  ['status' => true,'message' => 'This Menufacturer has been deleted Successfully!','data' => $category];
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $responce =  ['status' => false,'message' => $e->getMessage()];
            }
            return $responce;

    }
}
