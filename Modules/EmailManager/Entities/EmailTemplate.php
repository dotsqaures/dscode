<?php

namespace Modules\EmailManager\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['email_hook_id', 'subject', 'description', 'footer_text', 'email_preference_id', 'status'];


    /**
     * Get the email that owns the hook.
     */
    public function email_hook()
    {
        return $this->belongsTo('Modules\EmailManager\Entities\EmailHook');
    }

    /**
     * Get the email that owns the hook.
     */
    public function email_preference()
    {
        return $this->belongsTo('Modules\EmailManager\Entities\EmailPreference');
    }

}
