<?php

namespace Modules\ProductManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Events\Sluggable;
use Mail;
use Modules\UserManager\Entities\User;

class Cart extends Model
{
    //use Sluggable;     // Attach the Sluggable trait to the model
    protected $fillable = ['user_id','product_id','status','from_offer'];


}
