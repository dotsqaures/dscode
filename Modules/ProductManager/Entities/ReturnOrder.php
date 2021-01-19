<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
use Modules\UserManager\Entities\User;

class ReturnOrder extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['complaint_id','return_product_ids','order_id','orderdetail_id','product_id','user_id','return_reason','status','return_order_date','return_confirm_order','created_at','updated_at','charge_id','transaction_id','amount'];

     public function setOrderdetailIdAttribute($value){
        //dd($value);
          settype($value, 'array');
          $this->attributes['orderdetail_id'] = serialize($value);
      }

    public function product() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class, 'product_id','id');
    }

    public function order() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Order::class, 'order_id','id');
    }

    public function orderDetail() {
        return $this->belongsTo(\Modules\ProductManager\Entities\OrderDetail::class, 'orderdetail_id','id');
    }


    public function Userdata() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'usser_id','id');
    }





}
