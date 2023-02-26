<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
        $rules = [
            'name'        => getRule('name',true),
            'category'    => getRule('',true),
            'short_description' => getRule('',true),
            'description' => getRule('',true),
            'meta_tags'   => getRule('',false,true),
            'meta_description'  => getRule('',false,true),
            'featured'    => getRule('',true),
            'images'      =>  'required|array|max:5'
        ];

        return $rules;
    }
}
