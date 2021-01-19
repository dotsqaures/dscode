<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;

class RecentlyView extends Model
{
    protected $fillable = ['user_id','product_id','status'];

    public function product() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class, 'product_id','id');
    }

    public function user() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'user_id','id');
    }
}
