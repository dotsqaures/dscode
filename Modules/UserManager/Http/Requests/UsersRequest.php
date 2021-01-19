<?php

namespace Modules\UserManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Http\Request;

class UsersRequest extends FormRequest
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

        $rule['employee_code'] = 'required|min:4|max:4';
        //$rule['email'] = 'required|email|unique:users,email,' . $request->segment(3);



        //$rule['mobileno'] = array('required', 'regex:/^(?:00|\\+)[0-9\\s.\\/-]{6,20}$/','digits:9');

        //$rule['role_id'] = 'required';
        if($this->has('password')){
            $rule['password'] = $passReq.'|sometimes|min:6|regex:/^.*(?=.{5,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/';
        }
        if($this->has('password_confirmation')){
            $rule['password_confirmation'] = $passReq.'|required|same:password';
        }
        if($this->has('agree')){
            $rule['agree'] = 'required|in:1';
        }

        if($this->method() == "PATCH"){
            $rule['profle_photo'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rule['employee_code'] = 'required|min:4|max:4';
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
            'first_name.required'  => 'Employee Name is required field.',
            'last_name.required'  => 'Last Name is required field.',
            'email.required' => 'Email ID is required field.',
            'profle_photo.required' => 'Profle photo is required field.',
            'email.unique' => 'This email address already exists. Please use another email address.',
            'mobileno.required'=>'Mobile number is required field.',
            'mobileno.unique'=>'Mobile number already exists.',
            'password.required'=>'The  password field is required.',
            'password_confirmation.required'=>'The confirm password field is required.',
             //'mobileno.regex'=>'Phone Number should be this format:4XX XXX XXX and 9 digit.',
            'password.min'  => 'Password must be 6 characters long and must contain at least one number, one special character and a combination of upper and lower character.',
            'password.regex'  => 'Password must be 6 characters long and must contain at least one number, one special character and a combination of upper and lower character.',
            //'password.regex'  => 'Password must contain at least one number, one special character and a combination of upper and lower letters.',
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
