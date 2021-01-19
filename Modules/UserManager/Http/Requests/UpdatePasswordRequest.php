<?php

namespace Modules\UserManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Ap\User;

class UpdatePasswordRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // only allow updates if the user is logged in
        return \Auth::guard()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'old_password'     => 'required',
            // 'new_password'     => 'required_if:old_password,==,1|min:6|regex:/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/',
            'password' => 'required|string|min:6|confirmed|regex:/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/',
            //'confirm_password' => 'required|same:new_password|min:6',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            // check old password matches
            if (!empty($this->input('old_password'))) {
                if (!Hash::check($this->input('old_password'), \Auth::guard()->user()->password)) {
                    $validator->errors()->add('old_password', trans('You entered wrong old password.'));
                }
            }
        });
    }
  /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'password.regex'        => 'Password contain at least one number, one special character and have a mixture of uppercase and lowercase letters.',
            'password.confirmed'        => 'New password and confirm password does not match.',
        ];
    }
}
