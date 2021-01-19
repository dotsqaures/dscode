<?php

namespace Modules\RestaurentsManager\Entities;

use Illuminate\Database\Eloquent\Model;

class RestaurantTimes extends Model
{
    protected $fillable = ['restaurant_id','week_day','morning_open_time','morning_close_time','evening_open_time','evening_close_time','status'];
}
