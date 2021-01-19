<?php

namespace Modules\UserManager\Entities;
use Illuminate\Support\Facades\Storage;
use App\Events\Sluggable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Notifications\Notifiable;
use Modules\ProductManager\Entities\chat;



class UserAddressBook extends Authenticatable
{

    //use Sluggable; // Attach the Sluggable trait to the model
    use Notifiable;
    use HasApiTokens;






    protected $fillable = ['user_id','shiping_name','shiping_last_name', 'shipping_mobileno','shipping_address_one', 'shipping_address_two',  'shipping_suburb','shiping_Unit_number','shiping_Street_number','shipping_state', 'shipping_postcode', 'billing_name', 'billing_last_name', 'billing_mobileno', 'billing_address_one', 'billing_address_two', 'billing_suburb','billing_Unit_number','billing_Street_number','billing_state', 'billing_postcode', 'status'];







    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();



    }







    public function address()
    {
        return $this->hasOne(\Modules\UserManager\Entities\UserAddresses::class, 'user_id')->where('is_default', '=' , 1);
    }






    public function chats() {
        return $this->hasMany(Chat::class, 'sender_id');
    }






}
