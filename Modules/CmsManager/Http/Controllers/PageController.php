<?php

namespace Modules\CmsManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CmsManager\Entities\Page;
use Modules\FaqManager\Entities\Faq;
use Modules\NewsManager\Entities\News;

class PageController extends Controller
{

    public function __construct() {

    }

    /**
     * @desc :  Method for get page details behalf on page slug
     * @param type $slug
     * @return type
     */
    public function index($slug) {

   if($slug == 'contact-us'){

    return view('cmsmanager::pages.' . $slug, compact('title', 'page', 'slug',  'pageTitle'));

   }else{

        $page = Page::whereSlug($slug)->first();

        if (!$page) {
            abort(404);
        }
        $pageTitle = $page->title;
        $title     = $slug;

            return view('cmsmanager::pages.index', compact('title', 'page', 'slug', 'pageTitle'));

    }
}

}
