<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'name' => 'required|alpha_num',
            'count' => 'required|integer',
            'price' => 'required|numeric',
            'discount' => 'numeric|between:0,100',
            'description' => 'required',
            'images' => 'required'
        ];
    }


}
