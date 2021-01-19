<?php

namespace Modules\ProductManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'item_title' => 'required',
                    'category_id' => 'required',
                    'device_type' => 'required',
                     'device_model' => 'required',
                     'colour' =>'required',
                     'storage' =>'required',
                     'carrier_id' =>'required',
                    // 'imei_code' => 'required |min:15|max:15',


                     'product_tag_one' => 'required',
                     'product_tag_two' => 'required',
                     'product_tag_three' => 'required',

                    //'upload_verification_photo' => 'required|image|mimes:jpeg,png,jpg',
                     'status' => 'required',
                     'item_description' => 'required',

                     'shipping_charge' => 'required',
                     'selling_price' => 'required|numeric',
                     'termcondition' =>'accepted',

                     'imei_number_photo' => 'nullable|image|mimes:jpeg,png,jpg',
                     'google_id_photo' => 'nullable|image|mimes:jpeg,png,jpg',

                     'mainphoto' => 'nullable|image|mimes:jpeg,png,jpg',
                     'backphoto' => 'nullable|image|mimes:jpeg,png,jpg',

                     'leftphoto' => 'nullable|image|mimes:jpeg,png,jpg',
                     'rightphoto' => 'nullable|image|mimes:jpeg,png,jpg',

                     'topphoto' => 'nullable|image|mimes:jpeg,png,jpg',
                     'bottomphoto' => 'nullable|image|mimes:jpeg,png,jpg',

                     'scratchphoto' => 'nullable|image|mimes:jpeg,png,jpg',
                     'scratchphoto2' => 'nullable|image|mimes:jpeg,png,jpg',

                     'allaccessories'=>'nullable|image|mimes:jpeg,png,jpg',


                     //'product_image'=> 'image|mimes:jpeg,png,jpg',
                     //'phone_purchase_date'=>'required',
                ];

            }

            case 'PATCH':
            {
                return [
                    'item_title' => 'required',
                    'category_id' => 'required',
                   /* 'device_type' => 'required',
                    'device_model' => 'required',
                    'colour' =>'required',
                    'storage' =>'required',
                    'carrier_id' => 'required',
                    'imei_code' => 'required | digits:15',

                     'status' => 'required',
                     'item_description' => 'required',


                     'product_tag_one' => 'required',
                     'product_tag_two' => 'required',
                     'product_tag_three' => 'required',

                     'shipping_charge' => 'required',
                     'selling_price' => 'required|numeric',
                     'termcondition' =>'accepted',

                     //'product_image'=> 'image|mimes:jpeg,png,jpg',
                     //'phone_purchase_date'=>'required',*/
                ];

            }



        }

    }


    public function messages()
    {
        return [
            'item_title.required'  => 'Item title is required field.',
            'shipping_charge.required' => 'this is Required field',
            'category_id.required'  => 'Please select brand.',
            'device_type.required'  => 'Please select device.',


            'device_model.required'  => 'Please select device model.',
            'colour.required'  => 'Please select colour.',
            'carrier_id.required' => 'Please select carrier.',
            'storage.required'  => 'Please select storage.',
            //'imei_code.required'  => 'IMEI/SERIAL number is required field.',

            'product_tag_one.required'  => 'Product tagline 1 is required field.',
            'product_tag_two.required'  => 'Product tagline 2 is required field.',
            'product_tag_three.required'  => 'Product tagline 3 is required field.',



            //'slug.unique' => 'Each category must have a unique slug! this category slug already created!!',
            'item_description.required'  => 'Please enter Item Description.',

            'selling_price.required'  => 'Please enter selling price.',

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
