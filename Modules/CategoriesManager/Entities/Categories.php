<?php

namespace Modules\CategoriesManager\Entities;


use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;

class Categories extends Model
{
    use Sluggable; // Attach the Sluggable trait to the model


    protected $fillable = ['title','parent_id', 'slug',  'meta_title', 'meta_keyword', 'meta_description', 'status','image'];
   // protected $fillable = [];


   public function sluggable() {
        return [
            'dbfield' => 'slug',
            'source' => 'title',
            'table' => 'categories',
        ];
    }




   /**
     * Set the category title.
     *
     * @param  string  $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }

    public function parent_category() {
        return $this->belongsTo(\Modules\CategoryManager\Entities\Category::class, 'parent_id', 'id');
    }

    public function deviceType() {
        return $this->belongsTo(\Modules\DeviceManager\Entities\Device::class, 'device_id', 'id');
    }

   public function products() {
        return $this->hasMany(\Modules\ProductManager\Entities\Product::class);
    }


    public function devicemodels(){
        return $this->hasMany(\Modules\ModelManager\Entities\Devicemodel::class,'category_id','id');
    }

    public function scopeStatus($query, $status = null)
    {
        if ($status === '0' || $status == 1 ) {
            $query->where('status', $status);
        }
        return $query;
    }

    public function scopeFilter($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('meta_title', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('meta_description', 'LIKE', '%' . $keyword . '%');
            });
        }
        return $query;
    }
}
