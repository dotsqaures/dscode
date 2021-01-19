<?php

namespace Modules\EmailManager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\EmailManager\Entities\EmailHook;
use Modules\EmailManager\Entities\EmailTemplate;
use Modules\EmailManager\Entities\EmailPreference;
use Modules\EmailManager\Http\Requests\EmailTemplateRequest;

class EmailTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $emailTemplates = EmailTemplate::with(['email_hook' => function($q){
            $q->select(['id','title','slug']);
        }, 'email_preference' => function($q){
            $q->select(['id','title']);
        }])->get();
        //dd($emailTemplates);
        return view('emailmanager::Admin.templates.index', compact('emailTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $hooks = EmailHook::active()->orderBy('title', 'DESC')->pluck('title','id')->toArray();
        $emailPreference = EmailPreference::orderBy('title', 'DESC')->pluck('title','id')->toArray();
        $emailTemplateLists = EmailTemplate::with(['email_hook' => function($q){
            $q->select(['id','title','slug']);
        }, 'email_preference' => function($q){
            $q->select(['id','title']);
        }])->get();
        return view('emailmanager::Admin.templates.createOrUpdate', compact('hooks','emailPreference','emailTemplateLists'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(EmailTemplateRequest $request)
    {
        try{  
            EmailTemplate::create($request->all());
        }
        catch (\Illuminate\Database\QueryException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('admin.email-templates.index')->with('success', 'Email template has been saved Successfully');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(EmailTemplate $emailTemplate)
    {
        $fullUrl = \App::make('url')->to('/');
        $replacement = [];
        $default_replacement = [
           '##SYSTEM_APPLICATION_NAME##' => "Dotsquares",
           '##BASE_URL##' => $fullUrl,
           '##SYSTEM_LOGO##' => $fullUrl . 'img/noimage.jpg',
           '##COPYRIGHT_TEXT##' => "Copyright Dotsquares " . date("Y"),
       ];
       $message_body = str_replace('##EMAIL_CONTENT##', $emailTemplate->description, $emailTemplate->email_preference->layout_html);
       $message_body = str_replace('##EMAIL_FOOTER##', nl2br($emailTemplate->footer_text), $message_body);
       $message_body = strtr($message_body, $default_replacement);
       $message_body = strtr($message_body, $replacement);
       $subject = strtr($emailTemplate->subject, $default_replacement);
       $subject = strtr($subject, $replacement);
       $message = ['message' => $message_body, 'subject' => $subject];
       return view('emailmanager::Admin.templates.show',compact('emailTemplate','message'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $emailTemplate = EmailTemplate::find($id);
        $hooks = EmailHook::active()->orderBy('title', 'DESC')->pluck('title','id')->toArray();
        $emailPreference = EmailPreference::orderBy('title', 'DESC')->pluck('title','id')->toArray();

        $emailTemplateLists = EmailTemplate::where('id', '!=', $id)->with(['email_hook' => function($q){
            $q->select(['id','title','slug']);
        }, 'email_preference' => function($q){
            $q->select(['id','title']);
        }])->get();

        return view('emailmanager::Admin.templates.createOrUpdate', compact('emailTemplate','hooks','emailPreference','emailTemplateLists'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(EmailTemplateRequest $request, $id)
    {
        try{   
            $emailTemplate = EmailTemplate::find($id);
            $emailTemplate->fill($request->all());
            $emailTemplate->save();
          }
          catch (\Illuminate\Database\QueryException $e) {
              return back()->withError($e->getMessage())->withInput();
          }
            return redirect()->route('admin.email-templates.index')->with('success', 'Email template has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
