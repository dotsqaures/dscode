<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;

class Chat extends Model
{
    protected $fillable = ['product_id','sender_id',  'receiver_id', 'status','conversion_id','message'];

    public function sluggable() {
        return [
            'dbfield' => 'product_id',
            'source' => 'product_id',
            'table' => 'chats',
        ];
    }

    public function productsdata() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class, 'product_id', 'id');
    }



    public function userdata() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'receiver_id', 'id');
    }

    public function products() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class);
    }

    public function userdatasender() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'sender_id', 'id');
    }


}
