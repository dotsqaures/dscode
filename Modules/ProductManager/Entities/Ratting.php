<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
use Modules\UserManager\Entities\User;
use Modules\UserManager\Entities\UserAddressBook;

class Ratting extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['buyer_id','seller_id','rat','review','product_id','order_id'];

    public function productDetails() {
        return $this->hasMany(\Modules\ProductManager\Entities\OrderDetail::class, 'product_id', 'id');
    }

 public function OrderDetailsData() {
        return $this->hasMany(\Modules\ProductManager\Entities\OrderDetail::class, 'order_id', 'id');
    }

    public function OrderReturnData() {
        return $this->hasMany(\Modules\ProductManager\Entities\ReturnOrder::class, 'order_id', 'id');
    }


    public function user() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'user_id','id');
    }

    public function UserAddressBook() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'user_id','id');
    }



}
