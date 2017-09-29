<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemDetailRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'color'     => 'required',
            'size'      => 'required',
            'stock'     => 'required',
            'image'     => 'required',
            'image.*'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
            'color.required'    => 'Item color is required',
            'size.required'     => 'Item size is required',
            'stock.required'    => 'Item stock is required',
            'image.required'    => 'Item image is required',
            'image.*.mimes'     => 'Item image file type is invalid',
            'image.*.image'     => 'Item image file uploaded is not an image',
            'image.*.max'       => 'Item image maximum file size is 2 MB'
        ];
    }
}
