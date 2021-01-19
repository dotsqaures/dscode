<?php

namespace Modules\UserManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManager\Entities\User;
use Modules\ProductManager\Http\Requests\ProductRequest;
use Modules\CategoriesManager\Entities\Categories;
use Modules\DeviceManager\Entities\Device;
use Modules\ProductManager\Entities\Product;
use Modules\ProductManager\Entities\ProductImage;
use Modules\SettingManager\Entities\Setting;


class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function dashboard() {

        $logInedUser=\Auth::user();

        $Product = Product::where([['user_id', '=',$logInedUser->id],])->orderBy('is_feature', 'DESC')->orderBy('id','DESC')->paginate(9);

        return view('usermanager::Dashboard.index',compact('Product','logInedUser'));
    }


}
