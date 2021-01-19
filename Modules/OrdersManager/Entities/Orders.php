<?php

namespace Modules\OrdersManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManager\Entities\User;
use Modules\StampsManager\Entities\Stamps;
use Modules\StampsManager\Entities\RedemStamp;

class Orders extends Model
{
    protected $fillable = [];

    public function user() {
        return $this->belongsTo(\Modules\UserManager\Entities\User::class, 'user_id','id');
    }



    public function RedemData() {
        return $this->hasMany(\Modules\StampsManager\Entities\RedemStamp::class, 'order_id','id');
    }

    public function scopeStatus($query, $status = null)
    {
        if ($status === '0' || $status == 1 || $status == 2  ||  $status == 3) {
            $query->where('status', $status);
        }
        return $query;
    }

    public function scopeFilter($query, $keyword)
    {


    if(!empty($keyword)){

            $username = User::where('role_id',1)->where('first_name','LIKE','%' . $keyword . '%')
            ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')->first();
            
         



            if (!empty($username)) {
                $query->where(function ($query) use ($username) {
                    $query->where('user_id', 'LIKE', '%' . $username->id . '%');
                    });
            }else{
              
                $query->where(function ($query) use ($keyword) {
                    $query->where('user_id', 'LIKE', '%' . $keyword . '%');
                    });
            }
            
    }

        return $query;
    }
}
