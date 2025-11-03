<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CardPaymentRequest extends FormRequest
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
        // $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        // $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        // $output = str_replace($persian, $english, $this->date);
        // $this->date = $output;
        // dd($this->date);
        return [
            'tracing_code' => 'required|numeric|unique:card_payments,tracing_code,'. $this->id ,
            'date' => 'required' ,
            //'date' => 'jdatetime:YYYY/MM/DD H:m:s' ,
            'price_cardPay' => 'required|numeric' ,
        ];
    }
}
