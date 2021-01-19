<?php

namespace Modules\SettingManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SettingManager\Entities\Setting;
use Modules\SettingManager\Http\Requests\LogoRequest;
use Modules\SettingManager\Http\Requests\GeneralRequest;

class SettingManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function getlogos(Request $request)
    {
        $settings = Setting::where('manager' , '=','theme_images')->get();
        //dd($request->old('setting'));
        return view('settingmanager::Admin.settings.logo-setting',compact('settings'));
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function themedelete($id)
    {
     $setting = Setting::find($id);
     try{
        $setting->delete();
        $responce =  ['status' => true,'message' => 'Setting has been deleted Successfully!','data' => $setting];
     }catch (\Exception $e)
     {
        $responce =  ['status' => false,'message' => $e->getMessage()];
     }
     return $responce;
}

    public function storeLogos(LogoRequest $request)
    {
        $data = $request->input('setting');
        // dd($data);
        foreach($request->input('setting') as $setting){
            $newUser = Setting::updateOrCreate(
                 [
                 'id'   => (isset($setting['id']) && !empty($setting['id'])) ? $setting['id'] : 0,
                 ],$setting);
         }

       //die("Done");

        return redirect()->route('settingtheme')->with(['success' => 'Setting saved successfully!']);
    }

    public function storeTempImage(Request $request)
    {
        $real_path = $request->file('file')->store('public/temp');

        $fake_path = str_replace("public/","",$real_path);

        $image_path = asset("storage/".$fake_path);
        $imageArray = explode("/", $fake_path);
        $imageName = end($imageArray);

        return json_encode(['success' => true, 'image_path' => $image_path, 'fake_path' => $fake_path, 'filename' => $imageName]);
    }

    public function getGeneralSetting(Request $request)
    {
        $allowed_columns = ['id', 'title', 'slug'];
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';
        $order = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $settings = Setting::orderBy($sort, $order)->where('manager','general')->paginate(config('get.ADMIN_PAGE_LIMIT'));
        return view('settingmanager::Admin.settings.general.general-setting',compact('settings'));
    }

    public function addGeneralSetting()
    {
        return view('settingmanager::Admin.settings.general.add');
    }

    public function storeGeneralSetting(GeneralRequest $request)
    {
        //dd($request->all());die;
        try{
            Setting::create($request->all());
        }catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('setting.general')->with('success', 'General setting created successfully');
    }

    public function showGeneralSetting($id)
    {
        $settings = Setting::find($id);
        return view('settingmanager::Admin.settings.general.show',compact('settings'));
    }

    public function editGeneralSetting($id)
    {
        $settings = Setting::find($id);
        return view('settingmanager::Admin.settings.general.add',compact('settings'));
    }

    public function updateGeneralSetting(GeneralRequest $request, $id)
    {
        if($request->slug == 'admin-commission'){

                if ($request->config_value < 0)
                        {
                            return back()->withError('Please use positive value only')->withInput();


                        }else{

                        try{
                            $setting = Setting::find($id);
                            $setting->fill($request->all());
                            $setting->save();
                        }
                        catch (\Illuminate\Database\QueryException $e) {
                            return back()->withError($e->getMessage())->withInput();
                        }
                            return redirect()->route('setting.general')->with('success', 'Setting updated successfully!');
                    }
        }else{

                try{
                    $setting = Setting::find($id);
                    $setting->fill($request->all());
                    $setting->save();
                }
                catch (\Illuminate\Database\QueryException $e) {
                    return back()->withError($e->getMessage())->withInput();
                }
                    return redirect()->route('setting.general')->with('success', 'Setting updated successfully!');
        }
    }

    public function getSmtpSetting()
    {
        $smtp = Setting::where('manager','smtp')->get();
        return view('settingmanager::Admin.settings.smtp',compact('smtp'));
    }

    public function updateSmtpSetting(Request $request)
    {
        //dd($request->all());
        foreach($request->input('setting') as $setting){
        $newUser = Setting::updateOrCreate(
            [
            'slug'   => $setting['slug'],
            ],$setting);

        }

        return redirect()->route('setting.smtp')->with(['success' => 'Settings updated successfully!']);
    }

    public function updateSmtpSettingOld(Request $request)
    {
        for($i=0;$i<count($request->input('slug'));$i++)
        {
            $setting = Setting::where('slug',$request->input('slug')[$i])->first();
            if($setting != null)
            {
                $setting->config_value = $request->input('config_value')[$i];
                $setting->update();
            }
            else{
                $setting = new Setting();
                $setting->title = $request->input('title')[$i];
                $setting->slug = $request->input('slug')[$i];
                $setting->config_value = $request->input('config_value')[$i];
                $setting->field_type = $request->input('field_type')[$i];
                $setting->manager = $request->input('manager')[$i];
                $setting->save();
            }
        }

        return redirect()->route('setting.smtp')->with(['success' => 'Settings updated successfully!']);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('settingmanager::edit');
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
