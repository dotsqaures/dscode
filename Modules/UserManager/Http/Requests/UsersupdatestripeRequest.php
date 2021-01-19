<?php

namespace Modules\UserManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Http\Request;

class UsersupdatestripeRequest extends FormRequest
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

        $rule['account_holder_name'] = 'required|alpha|min:2|max:100';
        $rule['routing_number'] = 'required|numeric|min:6';
        $rule['account_number'] = 'required|numeric|min:8';
        //$rule['ssn_last_4'] = 'required|numeric|min:2';
        $rule['dob'] = 'required';

        $rule['city'] = 'required|alpha';
        $rule['state'] = 'required|alpha';
        $rule['postal_code'] = 'required|integer|min:5';
        $rule['stripe_document_front'] = 'mimes:jpeg,png|required';
        $rule['stripe_document_back'] =  'mimes:jpeg,png|required';



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
            'account_holder_name.alpha'  => 'Enter name should be without spac.',
            'routing_number.required'  => 'BSB field is required field.',
            'last_name.required'  => 'Last Name is required field.',
            'email.required' => 'Email ID is required field.',
            'city.required' => 'Suburb is required field.',
            'city.alpha' => 'Suburb field may contain only letters and without space.',
            'postal_code.required' => 'Postcode ID is required field.',
            'email.unique' => 'This email address already exists. Please use another email address.',
            'mobileno.unique'=>'Mobile number already exists.',
            'password_confirmation.required'=>'The confirm password field is required.',
            'stripe_document_front.required'  => 'Front document field is required.',
            'stripe_document_back.required'  => 'Back document field is required.',
             //'mobileno.regex'=>'Phone Number should be this format:4XX XXX XXX and 9 digit.',
            'password.regex'  => 'Password must contain at least one number, one special character and a combination of upper and lower letters.',
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
