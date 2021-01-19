<?php

namespace Modules\EmailManager\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Events\Sluggable;

class EmailHook extends Model
{
    use Sluggable; // Attach the Sluggable trait to the model

    protected $fillable = ['title', 'slug', 'description', 'status'];


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


    public function getCustomSlugAttribute() {
       if(empty($this->slug)){
        return trim($this->title);
       }else{
        return trim($this->slug);
       }
    }

    /**
     * Get the comments for the blog post.
     */
    public function templates()
    {
        return $this->hasMany('Modules\EmailManager\Entities\EmailTemplate');
    }


    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
