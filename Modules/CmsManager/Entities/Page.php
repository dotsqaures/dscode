<?php

namespace Modules\CmsManager\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Events\Sluggable;

class Page extends Model
{
    use Sluggable; // Attach the Sluggable trait to the model

    protected $fillable = ["title","sub_title","slug","short_description","description","banner","meta_title","meta_keyword","meta_description","status"];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

	public function sluggable() {
		return [
            'dbfield' => 'slug',
            'source' => 'title',
		];
	}
}
