<?php

namespace Modules\StampsManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManager\Entities\User;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;

class RedemStamp extends Model
{
    protected $fillable = ['user_id','order_id','stamp_id','redeem_code','status','created_at','updated_at'];

    public function scopeFilter($query, $keyword)
    {
       $keywordnew = explode(' ', $keyword);


        $username = User::where('role_id',2)->where('restuarents_id','LIKE','%' . $keyword . '%')->first();

        if(!empty($keyword)){
        if (!empty($username)) {
            $query->where(function ($query) use ($username) {
                $query->where('redeem_code', 'LIKE', '%' . $username->employee_code. '%');



            });
        }else{
            $query->where(function ($query) use ($keyword) {
                $query->where('redeem_code', 'LIKE', '%' . $keyword . '%');



            });
        }
      }



        return $query;
    }

}
