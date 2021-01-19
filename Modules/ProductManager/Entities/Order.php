<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
use Modules\UserManager\Entities\User;
use Modules\UserManager\Entities\UserAddressBook;

class Order extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['custom_order_id','product_id','charge_id','rat','user_id','total_amount','transcation_id','status','tracking_number','order_date','is_transfertoseller','order_status_date','is_return'];

    public function user() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'user_id','id');
    }

    public function stamp() {
        return $this->hasMany(\Modules\StampsManager\Entities\Stamps::class, 'charge_id','id');
    }

    public function RedemData() {
        return $this->hasMany(\Modules\StampsManager\Entities\RedemStamp::class, 'order_id','id');
    }

    public function productDetails() {
        return $this->hasMany(\Modules\ProductManager\Entities\OrderDetail::class, 'product_id', 'id');
    }


    public function OrderDetailsData() {
        return $this->hasMany(\Modules\ProductManager\Entities\OrderDetail::class, 'order_id', 'id');
    }

    public function OrderReturnData() {
        return $this->hasMany(\Modules\ProductManager\Entities\ReturnOrder::class, 'order_id', 'id');
    }




    public function UserBillingAddress() {
        return $this->belongsTo(\Modules\UserManager\Entities\UserAddressBook::class, 'user_id','user_id');
    }

     public function rattingdata() {
        return $this->hasMany(\Modules\ProductManager\Entities\Ratting::class, 'order_id', 'id');
    }

    public static function SendEmaltoCutomerWhenpurchaseStamp($userdata,$transctionid,$stampname)
    {

               $hook = "purchase-stamp";

               $replacement['USER_NAME'] = $userdata->first_name.' '.$userdata->last_name;
               $replacement['TRANSCATION_ID'] = $transctionid;
               $replacement['STAMP_NAME'] = $stampname;
               $data = ['template' => $hook, 'hooksVars' => $replacement];

            Mail::to($userdata->email)->send(new \App\Mail\ManuMailer($data));

    }


}
