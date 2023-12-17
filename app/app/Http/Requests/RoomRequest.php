<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->type && $this->type = 'update') :
            return [
                'name'          => 'required|max:100',
                'description'   => 'required|max:1000',
                'floor'         => 'required',
                'price'         => 'required',
                'capacity'      => 'required',
                'tags'          => 'required',
                // 'images'        => 'required',
            ];
        endif;

        return [
            'name'          => 'required|max:100',
            'description'   => 'required|max:1000',
            'floor'         => 'required',
            'price'         => 'required',
            'capacity'      => 'required',
            'tags'          => 'required',
            'images'        => 'required',
        ];
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        // return [
        //     'name'          => __('label.house.field.name'),
        //     'description'   => __('label.house.field.description'),
        //     'province_code' => __('label.house.field.province_code'),
        //     'district_code' => __('label.house.field.district_code'),
        //     'ward_code'     => __('label.house.field.ward_code'),
        //     'address'       => __('label.house.field.address'),
        //     'thumbnail'     => __('label.house.field.thumbnail'),
        //     'category_id'   => __('label.house.field.category_id'),
        // ];
    }
}
