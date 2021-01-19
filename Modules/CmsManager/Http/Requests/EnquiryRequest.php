<?php

namespace Modules\CmsManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EnquiryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request) {
        //dd($request->input());
        //dd($request->segment(3));
        return [
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'required|min:10|numeric',
            /*    'subject' => 'required|min:10|max:555', */
            'message' => 'required|max:50555'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required'    => 'Please enter your name.',
            //'name.min'         => 'Name must be at least 5 characters long.',
            //'name.max'         => 'Name must be at max 255 characters long.',
            'email.required'   => 'Please enter your email address.',
            'email.email'      => 'Please enter valid email address.',
            'phone.required'   => 'Please enter your phone number.',
            'phone.min'        => 'Phone number must be at least 10 characters long.',
            'phone.numeric'    => 'Phone number must be numeric.',
            'message.required' => 'Please enter your message.',

            'message.max'      => 'Name must be at max 50555 characters long.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
