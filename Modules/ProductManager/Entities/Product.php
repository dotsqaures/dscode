<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
Use Storage;
use Modules\UserManager\Entities\User;
use Modules\UserManager\Entities\UserAddressBook;
use Modules\CarriersManager\Entities\Carriers;
use Modules\HeadlineOnesManager\Entities\HeadlineOnes;
use Modules\HeadlineTwosManager\Entities\HeadlineTwos;
use Modules\HeadlineThreesManager\Entities\HeadlineThrees;
use Modules\StoragesManager\Entities\Storages;
use Modules\ColorsManager\Entities\Colors;
use Modules\ModelManager\Entities\Devicemodel;
use Modules\DeviceManager\Entities\Device;




class Product extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['custom_product_id','qty','weight','item_title','location','phone_purchase_date','is_bill_avaialble',
    'phone_condition','item_video','item_description','selling_price','is_price_negotiable',
    'user_id','category_id','status','star_ratting','device_type','device_model','product_slug',
    'shipping_charge','admin_charge','final_price','imei_number_photo',
    'google_id_photo','imei_code','is_feature','is_sold','product_tag_one','product_tag_two','product_tag_three',
    'carrier_id','colour','storage','lowest_price','broken_device_id','termcondition','mainphoto',
    'frontphoto','backphoto','leftphoto','rightphoto','topphoto','bottomphoto','scratchphoto','allaccessories','serial_number','offer_price','is_return'];

    public function sluggable() {
        return [
            'dbfield' => 'product_slug',
            'source' => 'item_title',
            'table' => 'product',
        ];
    }


    public function setProductSlugAttribute($value){
         return $this->attributes['product_slug'] = strtolower(str_replace(" ", "-",$value));
    }





    public function category() {
        return $this->belongsTo(\Modules\CategoriesManager\Entities\Categories::class, 'category_id', 'id');
    }





    public function scopeStatus($query, $status = null)
    {
        if ($status === '0' || $status == 1 || $status == 2) {
            $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */


    /**
     * Scope a query to only include filtered users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('item_title', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('item_description', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('phone_condition', 'LIKE', '%' . $keyword . '%');
            });
        }
        return $query;
    }

    public function scopeCategoryWise($query, $category_id)
    {

        if (!empty($category_id)) {
            $rootIds = \Modules\CategoriesManager\Entities\Categories::where('id','=',$category_id)->pluck('id')->toArray();
            $rootIds[] = $category_id;
            $query->whereIn('category_id', $rootIds);
        }
        return $query;
    }






















}
