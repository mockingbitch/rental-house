<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRequest extends FormRequest
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
            'summary'       => 'required|max:200',
            'category_id'   => 'required|exists:App\Models\Category,id',
            'min_age'       => 'required',
            'max_age'       => 'required',
            'min_price'     => 'required',
            'max_price'     => 'required',
            'min_time'      => 'required',
            'max_time'      => 'required',
            'weekdays'      => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
            'language'      => 'required',
            'about_teacher' => 'required|max:200',
            'detail'        => 'required|max:500',
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
            'summary'       => __('label.request.field.summary'),
            'category_id'   => __('label.request.field.category_id'),
            'min_age'       => __('label.request.field.min_age'),
            'max_age'       => __('label.request.field.max_age'),
            'min_price'     => __('label.request.field.min_price'),
            'min_time'      => __('label.request.field.min_time'),
            'max_time'      => __('label.request.field.max_time'),
            'weekdays'      => __('label.request.field.weekdays'),
            'start_time'    => __('label.request.field.start_time'),
            'end_time'      => __('label.request.field.end_time'),
            'language'      => __('label.request.field.language'),
            'about_teacher' => __('label.request.field.about_teacher'),
            'detail'        => __('label.request.field.detail'),
        ];
    }
}
