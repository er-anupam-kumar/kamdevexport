<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

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
        $id = $this->route('category');
        $category = Category::findorfail(decrypt($id));

        $rules = [
            'name'             => getRule('name',true),
            'description'      => getRule('',true),
            'meta_description' => getRule('',false,true),
            'meta_tags'        => getRule('',false,true),
            'featured'         => getRule('',true)

        ];

        if($category->image_url){
            $rules['image'] = getRule('media',false,true);
        }else{
            $rules['image'] = getRule('media',true);
        }

        return $rules;
    }
}
