<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'name'             => getRule('name',true),
            'images'           => 'nullable|array|max:5',
            'description'      => getRule('',true),
            'short_description'=> getRule('',true),
            'meta_description' => getRule('',false,true),
            'meta_tags'        => getRule('',false,true),
            'featured'         => getRule('',true),
            'category'         => getRule('',true),
        ];

        return $rules;
    }
}
