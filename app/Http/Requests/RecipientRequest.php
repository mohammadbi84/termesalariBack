<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipientRequest extends FormRequest
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
            'city_id' => 'required' ,
            'subcity_id' => 'required' ,
            'name' => 'required|string' ,
            'family' => 'required|string' ,
            'mobile' => 'required|numeric' ,
            'nationalCode' => 'required|numeric' ,
            'address' => 'required|string' ,
            'houseId' => 'required|numeric' ,
            'zipcode' => 'required|numeric' ,
            'lat' => 'nullable|numeric' ,
            'lan' => 'nullable|numeric' ,
        ];
    }
}
