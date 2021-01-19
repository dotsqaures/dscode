<?php

namespace Modules\CategoriesManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Http\Request;

class CategoriesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {

        return [
            'title' => 'required|min:2|max:100|unique:categories',
            //'device_id' => 'required',
            'status' => 'required',
            'meta_title' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            //'image' => 'image',
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
            'title.required'  => 'Menufacturer Title is required field.',
            //'device_id.required' => 'Please select device type',
            //'slug.unique' => 'Each category must have a unique slug! this category slug already created!!',
            'meta_title.required'  => 'Please enter meta title.',
            'meta_keyword.required'  => 'Please enter meta keyword.',
            'meta_description.required'  => 'Please enter meta description.',
            //'image.required' =>'Image is Required field',
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
