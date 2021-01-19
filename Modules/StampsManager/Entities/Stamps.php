<?php

namespace Modules\StampsManager\Entities;

use Illuminate\Database\Eloquent\Model;

class Stamps extends Model
{
    protected $fillable = ['title','is_deleted','short_description','description','stemp_no','stemp_valid','normal_price','descoun_price','stamp_picture','saving_price','status','is_free'];
}
