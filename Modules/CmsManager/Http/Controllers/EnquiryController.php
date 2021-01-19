<?php

namespace Modules\CmsManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CmsManager\Entities\Enquiry;
use Modules\CmsManager\Http\Requests\EnquiryRequest;
use Mail;


class EnquiryController extends Controller
{

    /**
     * @desc :  Method for get page details behalf on page slug
     * @param type $slug
     * @return type
     */
    public function saveEnquiry(EnquiryRequest $request) {
        $enquiry = new Enquiry;
        $input   = $request->all();

       // $enquiry->fill($request->all());
               $hook = "contact-us";

               $replacement['USER_NAME'] = $request->name;

               $replacement['USER_EMAIL'] = $request->email;

               $replacement['SUBJECT'] = $request->subject;

               $replacement['MESSAGE'] = $request->message;

               $data = ['template' => $hook, 'hooksVars' => $replacement];

               $to = 'sellbuydevice@yopmail.com';
               
               Enquiry::sendemailtouser($input);

           // Mail::to($to)->send(new \App\Mail\ManuMailer($data));

            \Session::flash('success', 'Thank you for contacting with us. We will contact you as soon as we review your message.');
            return redirect()->back();


    }

}
