<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Frontend\Pages\PagesRepository;
use Modules\SettingManager\Entities\Setting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;







/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    protected $pagination;

    public function __construct()
    {
        //$this->pagination = config('pagination.pagination.home_pagination');
    }


    public function index()
    {

        $logInedUser=\Auth::user();
        $settingData = Setting::where('manager' , '=','theme_images')->get();
        $setting = Setting::all();

        $url = url('admin/login');
        return Redirect::to($url);
    }















}
