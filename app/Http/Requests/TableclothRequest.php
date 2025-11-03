<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableclothRequest extends FormRequest
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
            'code' => 'required' ,
            // 'title' => 'string' ,
            'category_id' => 'required' ,
            'design_id' => 'required' ,
            'color_id' => 'required' ,
            'dimensions' => 'required' ,
            'weight' => 'required' ,
            'kind' => 'required' ,
            'contains' => 'nullable' ,
            'sewingType' => 'required' ,
            'haveEster' => 'required' ,
            'kindOfEster' => 'nullable' ,
            'washable' => 'required' ,
            'uses' => 'nullable|string' ,

            'price' => 'required|array' ,
            'price.0' => 'required|numeric' ,
            'price.1' => 'numeric|nullable' ,
            'price.2' => 'numeric|nullable' ,

            'local' => 'required|array' ,
            'local.0' => 'required|string' ,
            'local.1' => 'nullable|string' ,
            'local.2' => 'nullable|string' ,

            'offType' => 'nullable|array' ,
            'offType.*' => 'nullable|string' ,

            'offPrice' => 'nullable|array' ,
            'offPrice.*' => 'nullable|numeric' ,

            'quantity' => 'required|numeric' ,
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|string' ,

        ];
    }

    // public function messages()
    // {
    //     return [
    //         'required' => '*',
    //     ];
    // }
}
