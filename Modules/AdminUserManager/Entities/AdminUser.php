<?php

namespace Modules\AdminUserManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mail;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','email','mobile'];

    protected $hidden = [
        'password', 'remember_token',
    ];

     /*
     * Override default password notification
     */
    public function sendPasswordResetNotification($token)
    {
        $replacement['token'] = $token;
        $replacement['RESET_PASSWORD_URL'] = url("/admin/password/reset/{$token}");
        $data = ['template'=>'forgot-password-email','hooksVars' => $replacement];
        Mail::to('surendra.s@dotsquares.com')->send(new \App\Mail\ManuMailer($data));
    }
}
