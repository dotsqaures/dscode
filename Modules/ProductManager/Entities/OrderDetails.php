<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
use Modules\UserManager\Entities\User;

class OrderDetail extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['order_id','product_id','status'];


    public function product() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class, 'product_id','id');
    }


    public function order() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Order::class, 'order_id','id');
    }





}
