<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;

class ProductFeature extends Model
{
    protected $fillable = ['product_id','feature_price','transcation_id','status','created_at','feature_start_date','feature_end_date'];

    public function product() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class, 'product_id','id');
    }
}
