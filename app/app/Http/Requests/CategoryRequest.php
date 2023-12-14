<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_vi' => 'required',
            'name_en' => 'required',
            'icon' => 'required'
        ];
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        return [
            'name_vi'     => __('label.category.field.name_vi'),
            'name_en'  => __('label.category.field.name_en'),
            'icon'  => __('label.category.field.icon')
        ];
    }
}
?>
