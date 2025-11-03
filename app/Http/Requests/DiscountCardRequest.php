<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCardRequest extends FormRequest
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
            'count' => 'required|numeric' ,
            'length' => 'required|numeric|min:5' ,
            'combination' => 'required|string' ,
            'type_amount' => 'required|string' ,
            'type_scope' => 'required|string' ,
            'count_usable' => 'nullable|numeric' ,
            'amount' => 'required|numeric' ,
            'start_date' => 'required|string' ,
            'expire_date' => 'required|string' ,
        ];
    }
}
