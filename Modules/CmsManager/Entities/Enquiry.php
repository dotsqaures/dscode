<?php

namespace Modules\CmsManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Mail;

class Enquiry extends Model
{

    protected $fillable = ['name', 'phone_no', 'email', 'details'];
    
    
public static function sendemailtouser($request)
    {  
              $hook = "contact-us";

               $replacement['USER_NAME'] = $request['name'];

               $replacement['USER_EMAIL'] = $request['email'];

               $replacement['SUBJECT'] = $request['subject'];

               $replacement['MESSAGE'] = $request['message'];

              

               $to = 'sellbuydevice@yopmail.com';
               $hook = "contact-us";

                $data = ['template' => $hook, 'hooksVars' => $replacement];

            Mail::to($to)->send(new \App\Mail\ManuMailer($data));

    
}

}
