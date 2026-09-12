<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideshowRequest extends FormRequest
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
            'position' => 'required|string' ,
            'title' => 'required|string' ,
            'e_title' => 'required|string' ,
            'ar_title' => 'required|string' ,
            'description' => 'nullable|string' ,
            'e_description' => 'nullable|string' ,
            'ar_description' => 'nullable|string' ,
            'image' => 'required',
            'video' => 'nullable',
            'link' => 'required|string' ,
            'duration' =>'required|integer',
            'order' => 'required|numeric|unique:slideshows,order,NULL,id,position,'.$this->position,
            // 'order' => 'required|numeric',
            //     Rule::unique('slideshows')->where(function ($query) use($position) {
            //         return $query->where('position', $this->position);
            //         // ->where('hostname', $hostname);
            //     }),
        ];
    }
}
