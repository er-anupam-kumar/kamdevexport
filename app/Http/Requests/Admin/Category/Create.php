<?php

namespace App\Http\Requests\Admin\Category;

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
            'name'             => getRule('name',true),
            'image'            => 'required | image',
            'description'      => getRule('',true),
            'meta_description' => getRule('',false,true),
            'meta_tags'        => getRule('',false,true),
            'featured'         => getRule('',true)
        ];

        return $rules;
    }
}