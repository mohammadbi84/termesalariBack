<?php

namespace App\Http\Requests;
use Auth;

use Illuminate\Foundation\Http\FormRequest;
use Hekmatinasser\Verta\Verta;

class UserRequest extends FormRequest
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
            'name' => 'required|string' ,
            'family' => 'required|string' ,
            'nationalCode' => 'nullable|numeric|unique:users,nationalCode,'. Auth::id() ,
            'mobile' => 'required|numeric|unique:users,mobile,'. Auth::id() ,
            'birthday' => 'required|' ,
            'email' => 'bail|email|unique:users,email,'. Auth::id() ,
            'shaba_number' => 'nullable|numeric|digits:24' ,
            // 'password' => 'required|string|min:8|max:50' ,

            'image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=150,max_height=150' ,

            'companyName' => 'nullable|string' ,

            'companyEconomyID' => 'nullable|required_with:companyName,companyNationalID,companyRegistrationID,city_id,subcity_id|numeric|unique:users,companyEconomyID,'. Auth::id() ,

            'companyNationalID' => 'nullable|required_with:companyName,companyEconomyID,companyRegistrationID,city_id,subcity_id|numeric|unique:users,companyNationalID,'. Auth::id() ,

            'companyRegistrationID' => 'nullable|required_with:companyName,companyEconomyID,companyNationalID,city_id,subcity_id|numeric|unique:users,companyRegistrationID,'. Auth::id() ,

            'city_id' => 'required_with:companyName,companyEconomyID,companyNationalID,companyRegistrationID,subcity_id' ,

            'subcity_id' => 'required_with:companyName,companyEconomyID,companyNationalID,companyRegistrationID,city_id' ,

            'companyTel' => 'nullable|required_with:companyName,companyEconomyID,companyNationalID,companyRegistrationID|numeric' ,
            'companySite' => 'nullable' ,
        ];
    }
}
