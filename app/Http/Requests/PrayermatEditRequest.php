<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrayermatEditRequest extends FormRequest
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
        // dd($this->all());
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
            // 'uses' => 'nullable|string' ,

            'price' => 'required|array' ,
            'price.0' => 'bail|required_without_all:price.1,price.2|sometimes|numeric',
            'price.1' => 'required_if:price.0,"",price.2,""',
            'price.2' => 'required_if:price.0,"",price.1,""',

            'local' => 'required|array' ,
            'local.0' => 'required_with:price.0',
            'local.1' => 'required_with:price.1',
            'local.2' => 'required_with:price.2',

            'offType' => 'nullable|array' ,
            'offType.*' => 'nullable|string' ,

            'offPrice' => 'nullable|array' ,
            'offPrice.0' => 'required_with:offType.0',
            'offPrice.1' => 'required_with:offType.1',
            'offPrice.2' => 'required_with:offType.2',
            'quantity' => 'required|numeric' ,
            'description' => 'nullable|string' ,
        ];
    }
}
