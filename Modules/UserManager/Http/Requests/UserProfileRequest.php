<?php

namespace Modules\UserManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule['routing_number'] = 'required';
        $rule['account_number'] = 'required';
        $rule['stripe_document_front'] = 'nullable|image|mimes:jpeg,png,jpg|max:5000';
        $rule['stripe_document_back'] = 'nullable|image|mimes:jpeg,png,jpg|max:5000';
        return $rule;
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

    public function messages() {
        return [
            'ssn_last_4.required'     => 'The Last 4 digits of SSN is required field.',
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
