<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;

class ProductImage extends Model
{
    protected $fillable = ['product_id','product_image'];

    public function product() {
        return $this->belongsTo(\Modules\ProductManager\Entities\Product::class, 'product_id','id');
    }
}
