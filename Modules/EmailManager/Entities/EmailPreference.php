<?php

namespace Modules\EmailManager\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailPreference extends Model
{
    protected $fillable = ['title', 'layout_html'];
}
