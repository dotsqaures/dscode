<?php

namespace Modules\UserManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Http\Request;

class UserseditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {

        $passReq = "nullable";
        if($this->method() == "POST"){
            $passReq = "required";
        }
       // dd($this->has('agree'));

          $rule['first_name'] = 'required|regex:/^[\pL\s\-]+$/u';
        $rule['last_name'] = 'required|regex:/^[\pL\s\-]+$/u';


        //$rule['email'] = 'required|email|unique:users,email,' . $request->segment(3);


        //$rule['mobileno'] = array('required', 'regex:/^(?:\+?61|\(?0)[2378]\)?(?:[ -]?[0-9]){8}+$/');

        //$rule['role_id'] = 'required';
        if($this->has('password')){
            $rule['password'] = $passReq.'|sometimes|min:6|confirmed|regex:/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/';
        }
        if($this->has('password_confirmation')){
            $rule['password_confirmation'] = $passReq.'|required|same:password';
        }
        if($this->has('agree')){
            $rule['agree'] = 'required|in:1';
        }


        if($this->method() == "PATCH"){
            //$rule['first_name'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            //$rule['first_name'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rule['profle_photo'] = 'image|mimes:jpeg,png,jpg,gif|max:2000';
            $rule['bussiness_logo'] = 'image|mimes:jpeg,png,jpg,gif|max:2000';
            $rule['mobileno'] = 'required';
        }

        //dd($rule);
        return $rule;


    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required'  => 'First Name is required field.',
            'last_name.required'  => 'Last Name is required field.',
            'bussiness_logo.max' => 'Failed to upload an image. The image maximum size is 2MB.',
            'profle_photo.max' => 'Failed to upload an image. The image maximum size is 2MB.',
           // 'email.required' => 'Email ID is required field.',
            //'email.unique' => 'This email ID have already created. please use another email id.',
             'mobileno.required'=>'Mobile Field is required.',
             'mobileno.regex'=>'Phone Number should be this format:+614XXXXXXXX.',
            'password.regex'  => 'Password contain at least one number, one special character and have a mixture of uppercase and lowercase letters.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return mixed
     */

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Illuminate\Support\Facades\Session::flash('ValidatorError', 'Oops, something went wrong. please check required form field values.');
        return parent::failedValidation($validator);
    }
}
