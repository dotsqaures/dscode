<?php

namespace Modules\CmsManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CmsManager\Entities\Page;
use Modules\CmsManager\Http\Requests\PagesRequest;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $allowed_columns = ['id', 'title', 'slug'];
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $pages = Page::orderBy($sort, $order)->paginate(config('get.ADMIN_PAGE_LIMIT'));
        return view('cmsmanager::Admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('cmsmanager::Admin.pages.createOrUpdate');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(PagesRequest $request)
    {
        try{
            Page::create($request->all());
        }
        catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.pages.index')->with('success', 'CMS Page has been saved Successfully');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Page $page)
    {
        return view('cmsmanager::Admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        return view('cmsmanager::Admin.pages.createOrUpdate', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(PagesRequest $request, $id)
    {
        try{
            $page = Page::find($id);
            $page->fill($request->all());
            $page->save();
          }
          catch (\Illuminate\Database\QueryException $e) {
              return back()->withError($e->getMessage())->withInput();
          }
        return redirect()->route('admin.pages.index')->with('success', 'CMS Page has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
