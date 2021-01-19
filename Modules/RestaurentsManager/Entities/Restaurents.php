<?php

namespace Modules\RestaurentsManager\Entities;

use Illuminate\Database\Eloquent\Model;

class Restaurents extends Model
{
    protected $fillable = ['name','lat','lng','restro_picture','desciption','location','status'];

    public function restaurantTime() {
        return $this->hasMany(\Modules\RestaurentsManager\Entities\RestaurantTimes::class, 'restaurant_id','id');
    }
}
