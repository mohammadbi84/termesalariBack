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
            'description' => 'nullable|string' ,
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'link' => 'required|string' ,
            'order' => 'required|numeric|unique:slideshows,order,NULL,id,position,'.$this->position,
            // 'order' => 'required|numeric',
            //     Rule::unique('slideshows')->where(function ($query) use($position) {
            //         return $query->where('position', $this->position);
            //         // ->where('hostname', $hostname);
            //     }),
        ];
    }
}
