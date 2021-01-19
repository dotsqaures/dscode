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



class User extends Authenticatable
{


    //use Sluggable; // Attach the Sluggable trait to the model
    use Notifiable;
    use HasApiTokens;




    protected $dates = ['date_of_birth'];
    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];

    protected $fillable = ['first_name','fcm', 'restuarents_id' ,'facebook_id','provider', 'last_name',  'email','employee_code', 'mobileno', 'address',  'remember_token', 'access_token', 'email_verified_at', 'password', 'profle_photo', 'status', 'verification_token', 'role_id','device_id','device_type','otp_token','bussiness_logo','bussiness_name','bussiness_location','stripe_account_id','is_verified'];
    //protected $fillable = ['first_name', 'provider_id','provider', 'last_name',  'email', 'mobileno', 'address',  'remember_token', 'access_token', 'email_verified_at', 'password', 'profle_photo', 'status', 'verification_token', 'role_id','device_id','device_type','otp_token','bussiness_logo','bussiness_name','bussiness_location','stripe_account_id','is_verified']
    protected $hidden = [
        'password', 'password_confirmation',
    ];







    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->sendRegEmail($model);
        });
        static::updating(function ($model) {
            $model->checkEmailVerified();
        });

        // static::updated(function($model)
        // {
        //     $model->sendRegEmail($model);
        //     //dd($model->getOriginal('email'));
        // });
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($pass)
    {

        if (!empty($pass)) {
            $this->attributes['password'] = Hash::make($pass);
            //Log::debug($pass. ' : ' . $this->attributes['password']);
        }
    }

    public function getDateOfBirthAttribute($value)
    {
        if(!empty($value)){
            return  \Carbon\Carbon::parse($value)->format('Y-m-d');
        }

    }


    public function reviews()
    {
        return $this->hasMany(\Modules\ReviewManager\Entities\Review::class, 'supplier_id');
    }



    public function products()
    {
        return $this->hasMany(\Modules\ProductManager\Entities\Product::class);
    }









    public function address()
    {
        return $this->hasOne(\Modules\UserManager\Entities\UserAddresses::class, 'user_id')->where('is_default', '=' , 1);
    }



    public function roles()
    {
        return $this->belongsToMany(\Modules\UserManager\Entities\Role::class);
    }
/**
     * The security questions that belong to user.
     */
    public function securityQuestions()
    {
        return $this->belongsToMany('\Modules\UserManager\Entities\SecurityQuestion')->withPivot('answer');
    }
    /**
     * Scope a query to only include users roles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $role)
    {
        // return $query->whereHas('roles', function($query) use($roles){
        //     if(is_array($roles)){
        //         $query->whereIn('id', $roles);
        //     }else{
        //         $query->where('id', $roles);
        //     }
        // });

        $query->where('role_id', $role);
    }

    /**
     * Scope a query to only include users roles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */


    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status = null)
    {
        if ($status === '0' || $status == 1) {
            $query->where('status', $status);
        }
        return $query;
    }



    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRoleWise($query, $role_id)
    {
        if (!empty($role_id)) {
            $query->where('role_id', $role_id);
        }
        return $query;
    }






    /**
     * Scope a query to only include filtered users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $keyword)
    {
       $keywordnew = explode(' ', $keyword);
      if(count($keywordnew) >1){

        $query->where(function ($query) use ($keywordnew) {
            $query->where('first_name', 'LIKE', '%' . $keywordnew[0] . '%');
            $query->orWhere('last_name', 'LIKE', '%' . $keywordnew[1] . '%');




        });

      }else{
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('first_name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('email', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('mobileno', 'LIKE', '%' . $keyword . '%');



            });
        }
       }

        return $query;
    }

    public function sendRegEmail($model)
    {
        /*if ($model->getAttribute('email') && $model->getOriginal('email') != $model->getAttribute('email')) {
            $userData = '';
            if ($model->getAttribute('password')) {
                $hook = "welcome-email";
                $verifyToken = strtoupper(\Illuminate\Support\Str::random(60));
                DB::table('users')
                    ->where('id', $model->id)
                    ->update(['verification_token' => $verifyToken]);
                $replacement['verify_n_password'] = url("verify/{$verifyToken}");
            } else {

                $token = app('auth.password.broker')->createToken($model);
                $replacement['token'] = $token;
                $hook = "forgot-password-email";
                $url = url("/users/password/reset/{$replacement['token']}");
                $replacement['CREATE_NEW_PASSWORD'] = $url;
            }
            $replacement['USER_INFO'] = $userData;
            $replacement['USER_NAME'] = $model->getAttribute('first_name');
            $replacement['USER_EMAIL'] = $model->getAttribute('email');
            $data = ['template' => $hook, 'hooksVars' => $replacement];

            Mail::to($model->getAttribute('email'))->send(new \App\Mail\ManuMailer($data));
        }*/
    }

     public static function Sendotptoemail($otpnumber,$email){
         
       $hook = "send-otp";
       $replacement['OTP'] = $otpnumber;
        $data = ['template' => $hook, 'hooksVars' => $replacement];

       Mail::to($email)->send(new \App\Mail\ManuMailer($data));

     }
    
    /*
     * Override default password notification
     */

    public function sendPasswordResetNotification($token)
    {
        $replacement['token'] = $token;
        $replacement['RESET_PASSWORD_URL'] = url("/password/reset/{$token}/?email=" . (base64_encode(request('email'))));
        $data = ['template' => 'forgot-password-email', 'hooksVars' => $replacement];
        Mail::to(request('email'))->send(new \App\Mail\ManuMailer($data));
    }

    /*
    public function roles() {
    return $this->belongsToMany(\Modules\UserManager\Entities\Role::class);
    } */

    public function role()
    {
        return $this->belongsTo(\Modules\UserManager\Entities\UserRole::class, 'role_id');
    }

    /*
    public function roles() {
    return $this->belongsToMany(\Modules\UserManager\Entities\Role::class);
    } */

    public function location()
    {
        return $this->belongsTo(\Modules\LocationManager\Entities\Location::class, 'country_id');
    }

    /**
     * CHECK IF USER HAS GIVEN ROLE.
     */
    public function hasRole($role)
    {

        return $this->role()->where('title', $role)->exists();
    }

    public function chats() {
        return $this->hasMany(Chat::class, 'sender_id');
    }



    /**
     * if email changed then neet to be change verified status for reverify account
     * activate the user's account.
     * @return bool
     */
    protected function checkEmailVerified()
    {
        if ($this->getAttribute('email') && $this->getOriginal('email') != $this->getAttribute('email')) {
            $this->attributes['is_verified'] = 0;
        }
    }



 /*---------------stripe function start here ---------------------------*/

  //$publishkey = 'pk_test_XavjwgF1BFYuvU632gwGg1m400p3ubcESz';
  //$secretkey = 'sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB';


 public static function CreateCustomerOnStripe($request)
 {
    \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
   // \Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');
     try{
        $customer = \Stripe\Customer::create(array(
            'email' => $request['email']
           ));

    }catch(Exception $e){
        dd($e);
    }



  if(!empty($customer))
    {
        return $customer->id;

    }else{
        return '';

    }

}

public static function CreateCustomerOnStripedemo($request)
 {
    \Stripe\Stripe::setApiKey('sk_test_51GprTaJ6sT2LBGdySqiYTJbpZnAsKqKqSELfFyl01z8AC4x9WowhbgahM2YJDk9pdv7BQIGlwzuCVJPmKVv79j6i00eHv5jpEk');
     try{
        $customer = \Stripe\Customer::create(array(
            'email' => $request['email']
           ));

    }catch(Exception $e){
        dd($e);
    }



  if(!empty($customer))
    {
        return $customer->id;

    }else{
        return '';

    }

}

public static function addcardDetail($logInedUser,$stripedata)
	{

            \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
             //\Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');
            

            $stripetoken =  \Stripe\Token::create([
                'card' => [
                  'number' => $stripedata['card_number'],
                  'exp_month' => $stripedata['exp_month'],
                  'exp_year' => $stripedata['exp_year'],
                  'cvc' => $stripedata['cvc'],
                ],
              ]);

			try{
			  $updatecard = \Stripe\Customer::createSource(
				$logInedUser->stripe_account_id,
			   ['source' => $stripetoken->id]
			  );
			}catch(Exception $e){
				dd($e);
			}

		   return  $updatecard;

	}


public static function getcustomercard($stripeid)
{

	$accountdi =  $stripeid;


    $response = array();
        try {
            //\Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));
             \Stripe\Stripe::setApiKey('sk_live_bxJZgmxasb0tjRykxB0HkOH6003sDGDgJm');
            // \Stripe\Stripe::setApiKey('sk_test_GIXHEBmsSFZj5UtDkjQdPzsP007rjpX8KB');
             
           // $record = \Stripe\Account::retrieve($accountdi);
            $record = \Stripe\Customer::allSources($accountdi);
            $response['status'] = 1;

            $response['data'] = $record;
        } catch (\Stripe\Error\ApiConnection $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
            // Network problem, perhaps try again.
        } catch (\Stripe\Error\InvalidRequest $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
            // You screwed up in your programming. Shouldn't happen!
        } catch (\Stripe\Error\Api $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
            // Stripe's servers are down!
        } catch (\Stripe\Error\Card $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
        }



  return $response;
}





 public static function CreateAccountOnStripe($request)
 {


   \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));




    $account = \Stripe\Account::create([
        'type' => 'custom',
        'country' => 'AU',
        'email' => $request['email'],
       'requested_capabilities' => ['card_payments', 'transfers'],
    ]);




  if(!empty($account))
    {
        return $account->id;

    }else{
        return '';

    }

}


public static function UpdateAccountOnStripe($data,$user)
{
    \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));

    if($data->file('stripe_document_front')){

        $file     = $data->file('stripe_document_front');
        $filename = $file->getClientOriginalName();

       $path = $data->file('stripe_document_front')->storeAs(
            'public/DocumentImages', $filename
            );

         $fp1 =   asset(Storage::url($path));

         $newpath = explode('DocumentImages/',$fp1);

         $filePathFront = storage_path("app/public/DocumentImages/".$newpath['1']);

       $fp = fopen($filePathFront, 'r');
        $uploadFront  = \Stripe\File::create([
        'purpose' => 'identity_document',
        'file' => $fp
        ]);

         $frontDocId = isset($uploadFront->id) ? $uploadFront->id : "";
    }

    if($data->file('stripe_document_back')){

        $file     = $data->file('stripe_document_back');
        $filename = $file->getClientOriginalName();

       $path = $data->file('stripe_document_back')->storeAs(
            'public/DocumentImages', $filename
            );

         $fp1 =   asset(Storage::url($path));

         $newpath = explode('DocumentImages/',$fp1);

         $filePathFront = storage_path("app/public/DocumentImages/".$newpath['1']);

       $fp = fopen($filePathFront, 'r');
        $uploadFront  = \Stripe\File::create([
        'purpose' => 'identity_document',
        'file' => $fp
        ]);

         $backDocId = isset($uploadFront->id) ? $uploadFront->id : "";
    }

    date_default_timezone_set("UTC");
    $utc_time = gmdate("Y-m-d\TH:i:s\Z");
    $tos_acceptance_date = strtotime($utc_time);
    $tos_acceptance_ip = request()->ip();

   $dobs = explode('/',$data['dob']);
   $day = $dobs['0'];
   $month = $dobs['1'];
   $year = $dobs['2'];

    /*$stripe_data = [
        'business_name' => 'SELLBYDEVICE', //$data['stripe_business_name'],
        'tos_acceptance' => array(
            'date' => $tos_acceptance_date,
            'ip' => $tos_acceptance_ip
        ),
        'legal_entity' => array(
            'type' => 'individual',
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'dob' => array('day' => $day, 'month' => $month, 'year' => $year),
            'address' => array('line1' => $data['address'], 'city' => $data['city'], 'state' => $data['state'], 'postal_code' => $data['postal_code']),
            'business_name' => 'SELLBYDEVICE', //$data['legal_business_name'],
            'personal_id_number' => '123456789', //$data['personal_id_number'],
            'verification' => array(
                "document" =>
                array("back" => $backDocId, "front" => $frontDocId)
            )

        ),
        'external_account' => array(
            'object' => 'bank_account',
            'account_holder_name' => $data['account_holder_name'],
            'account_number' => $data['account_number'],
            'routing_number' => $data['routing_number'],
            'country' => 'AU', //$data['country'],
            'currency' => 'AUD'//$data['currency']
        )
    ];*/

    $stripe_data = [
                'business_type' => 'individual',
                'individual' => array(
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'dob' => array('day' => $day, 'month' => $month, 'year' => $year),
                    'address' => array('line1' => $data['address'], 'city' => $data['city'], 'state' => $data['state'], 'postal_code' => $data['postal_code']),
                    'verification' => array(
                        "document" =>
                        array("back" => $backDocId, "front" => $frontDocId)
                    )
                ),




                'tos_acceptance' => array(
                    'date' => $tos_acceptance_date,
                    'ip' => $tos_acceptance_ip
                ),
                'external_account' => array(
                    'object' => 'bank_account',
                    'account_holder_name' => $data['account_holder_name'],
                    'account_number' => $data['account_number'],
                    'routing_number' => $data['routing_number'],
                    'country' => 'AU', //$data['country'],
                    'currency' => 'AUD'
                )


            ];



    $postfields = json_decode(json_encode($stripe_data));



    $headers = array(
        "Authorization: Bearer " . config('get.stripe_secret_key'),
        "Content-Type: application/x-www-form-urlencoded"
    );

    $endpoint = 'https://api.stripe.com/v1/accounts/'.$user['stripe_account_id'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data_response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = "Error: " . curl_error($ch);
    } else {
        // Assign response to variable
        $response = json_decode($data_response);
        // close curlSession
        curl_close($ch);
    }

//echo "<pre>";
//print_r($response); die;
    return $response;

}

public static function RetriveAccountOnStripe($data)
{   $accountdi =  $data->stripe_account_id;


    $response = array();
        try {
            \Stripe\Stripe::setApiKey(config('get.stripe_secret_key'));
            $record = \Stripe\Account::retrieve($accountdi);
            $response['status'] = 1;

            $response['data'] = $record;
        } catch (\Stripe\Error\ApiConnection $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
            // Network problem, perhaps try again.
        } catch (\Stripe\Error\InvalidRequest $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
            // You screwed up in your programming. Shouldn't happen!
        } catch (\Stripe\Error\Api $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
            // Stripe's servers are down!
        } catch (\Stripe\Error\Card $e) {
            $response['status'] = 0;

            $response['error'] = $e->getMessage();
        }

        return $response;
}




}
