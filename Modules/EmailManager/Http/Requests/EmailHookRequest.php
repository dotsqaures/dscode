<?php

namespace Modules\EmailManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailHookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5',
            'description' => 'required|min:10',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Please enter an email hook title!',
            'title.min'  => 'Email Hook must be at least 5 characters long!',
            'description.required'  => 'Please enter description!',
            'description.min'  => 'Hook description must be at least 50 characters long!',
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
}
