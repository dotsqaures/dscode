<?php

namespace Modules\ProductManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Productstep2Request extends FormRequest
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

                    'allaccessories'=> 'nullable|image|mimes:jpeg,png,jpg',
                ];

            }





        }

    }


    public function messages()
    {
        return [

            //'imei_code.required'  => 'IMEI/SERIAL number is required field.',

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
